<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order</title>
    <style>
        .error {
            color: red;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    include 'menu.php';


    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3 ">
                    <h2>Create Order </h2>
                </div>

                <!-- html form to create product will be here -->
                <!-- PHP insert code will be here -->

                <?php
                include 'config/databased.php'; // include database connection
                
                // check if form was submitted
                $errmsg = "";

                // link to create record form
                

                if ($_POST) {

                    //submit user fill in de product and quantity
                    $product_id = $_POST["product_id"];
                    $value = array_count_values($product_id);
                    $quantity = $_POST["quantity"];


                    if (empty($_POST["username"])) {
                        $errmsg .= "Username is required*";

                    } else {
                        $username = htmlspecialchars(strip_tags($_POST['username']));
                    }

                    for ($a = 0; $a < count($product_id); $a++) {

                        if ($product_id[$a] != "") {
                            if ($quantity[$a] == "") {
                                $errmsg .= "<div class='alert alert-danger'>Choose Product $a with quatity</div>";
                            }
                            if ($value[$product_id[$a]] > 1) {
                                $errmsg .= "<div class='alert alert-danger'>No Duplicate Product $a allowed</div>";
                            }
                        }

                    }
                    if (empty($errmsg)) {
                        $total_amount = 0;

                        for ($x = 0; $x < 3; $x++) {

                            $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':id', $product_id[$x]);
                            $stmt->execute();
                            $num = $stmt->rowCount();

                            if ($num > 0) {
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                //if database pro price is 0/no promo, price = row price
                                if ($row['promotion_price'] == 0) {
                                    $price = $row['price'];
                                } else {
                                    $price = $row['promotion_price'];
                                }
                            }
                            //combine prvious total_amount with new ones, loop (3 times)
                            $total_amount = $total_amount + ((float) $price * (int) $quantity[$x]);
                        }


                        //send data to 'order_summary' table in myphp
                        $order_date = date('Y-m-d');
                        $query = "INSERT INTO order_summary SET username=:username, order_date=:order_date, total_amount=:total_amount";

                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':order_date', $order_date);
                        $stmt->bindParam(':total_amount', $total_amount);

                        if ($stmt->execute()) {


                            $order_id = $con->lastInsertId();

                            for ($a = 0; $a < count($product_id); $a++) {
                                $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                $stmt = $con->prepare($query);
                                //bind user choose product(id) with order details product id
                                $stmt->bindParam(':id', $product_id[$a]);
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                $num = $stmt->rowCount();

                                if ($num > 0) {
                                    if ($row['promotion_price'] == 0) {
                                        $price = $row['price'];
                                    } else {
                                        $price = $row['promotion_price'];
                                    }
                                }
                                $price_each = ((float) $price * (int) $quantity[$a]);

                                //send data to 'order_detail' table in myphp
                                $query = "INSERT INTO order_detail SET product_id=:product_id, quantity=:quantity,order_id=:order_id, price_each=:price_each";

                                $stmt = $con->prepare($query);
                                $stmt->bindParam(':product_id', $product_id[$a]);
                                $stmt->bindParam(':quantity', $quantity[$a]);
                                $stmt->bindParam(':order_id', $order_id);
                                $stmt->bindParam(':price_each', $price_each);
                                $stmt->execute();
                            }

                            echo "<div class='alert alert-success'>Create order successful.</div>";
                        }

                    } else {
                        echo "<div class='alert alert-danger'>$errmsg.</div>";
                    }
                }

                ?>


                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                    <?php
                    // select customer
                    $query = "SELECT username FROM customer ORDER BY username DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();
                    ?>


                    <table class='table table-hover table-responsive table-bordered mb-5'>
                        <div class="row">
                            <label class="order-form-label">Username</label>
                        </div>

                        <div class="col-6 mb-3 mt-2"><span class="error">

                            </span>
                            <select class="form-select" name="username" aria-label="form-select-lg example">
                                <option value='' selected>Choose Username</option>
                                <?php
                                //if more then 0, value="01">"username"</option>
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                <option value="<?php echo $username; ?>">
                                    <?php echo htmlspecialchars($username, ENT_QUOTES); ?>
                                </option>
                                <?php }
                                }
                                ?>

                            </select>
                        </div>

                        <?php
                        //forloop, for 3 product
                        

                        for ($a = 0; $a < 3; $a++) {
                            // select product
                            $query = "SELECT id, name, price,promotion_price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();


                        ?>

                        <div class="row">
                            <label class="order-form-label">Product</label>
                        </div>
                        <div class="col-3 mb-2 mt-2">

                            <select class="form-select" name="product_id[]" aria-label="form-select-lg example">
                                <option value='' selected>Choose your product </option>

                                <?php if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row); ?>
                                <option value="<?php echo $id; ?>">
                                    <?php echo htmlspecialchars($name, ENT_QUOTES);
                                    if ($promotion_price == 0) {
                                        echo " (RM$price)";
                                    } else {
                                        echo " (RM$promotion_price)";
                                    } ?>

                                </option>
                                <?php }
                            }
                                ?>

                            </select>
                        </div>
                        <div class="col-3 mb-2"><label class="order-form-label">Quantity</label>

                            <input type='number' id='quantity[]' name='quantity[]' class='form-control' min=1 />
                        </div>
                        <?php

                        }
                        ?>




                    </table>
                    <input type="submit" class="btn btn-primary" />
                </form>

            </div> <!-- end .container -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
                crossorigin="anonymous"></script>
            <!-- confirm delete record will be here -->
            <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
                <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
            </div>
</body>

</html>