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
                $useErr = $proErr = $quaErr = "";
                $flag = false;
                // link to create record form
                

                if ($_POST) {
                    if (empty($_POST["username"])) {
                        $userErr = "Username is required*";
                        $flag = true;
                    } else {
                        $username = htmlspecialchars(strip_tags($_POST['username']));
                    }

                    //submit user fill in de product and quantity
                    $product_id = $_POST["product_id"];
                    $value = array_count_values($product_id);
                    $quantity = $_POST["quantity"];


                    if ($product_id[0] == "" && $product_id[1] == "" && $product_id[2] == "") {
                        echo "<div class='alert alert-danger'>Please at least choose a product *</div>";
                    } else {

                        //if product != empty, quatity = empty
                        if ((!empty($product_id[0]) && empty($quantity[0])) or (!empty($product_id[1]) && empty($quantity[1])) or (!empty($product_id[2]) && empty($quantity[2]))) {
                            echo "<div class='alert alert-danger'>Please type the quantity of your product *</div>";
                        } else {
                            //error if more than 1 (duplicate)
                            for ($x = 0; $x < count($product_id); $x++) {
                                if (!empty($product_id[$x]) && !empty($quantity[$x])) {

                                    if ($value[$product_id[$x]] == 1) {
                                        if ($flag == false) {


                                            //send data to 'order_summary' table in myphp
                                            $order_date = date('Y-m-d');
                                            $query = "INSERT INTO order_summary SET username=:username, order_date=:order_date";

                                            $stmt = $con->prepare($query);
                                            $stmt->bindParam(':username', $username);
                                            $stmt->bindParam(':order_date', $order_date);

                                            if ($stmt->execute()) {
                                                echo "<div class='alert alert-success'>Create order successful.</div>";

                                                $order_id = $con->lastInsertId();



                                                //send data to 'order_detail' table in myphp
                                                $query = "INSERT INTO order_detail SET product_id=:product_id, quantity=:quantity,order_id=:order_id";

                                                $stmt = $con->prepare($query);
                                                $stmt->bindParam(':product_id', $product_id[$x]);
                                                $stmt->bindParam(':quantity', $quantity[$x]);
                                                $stmt->bindParam(':order_id', $order_id);
                                                $stmt->execute();
                                            } else {
                                                echo "<div class='alert alert-danger'>Unable to create order.</div>";
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger'>Unable to create order.</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Please select different product.</div>";
                                    }
                                }
                            }
                        }
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
                        for ($x = 0; $x < 3; $x++) {
                            // select product
                            $query = "SELECT id, name, price,promotion_price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();
                        ?>

                        <div class="row">
                            <label class="order-form-label">Product</label><label
                                class="order-form-label">Quantity</label>
                        </div>
                        <div class="col-3 mb-2 mt-2">

                            <select class="form-select" name="product_id[]" aria-label="form-select-lg example">
                                <option value="" selected>Choose your product </option>

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
                                    <?php if (isset($_POST['product_id[]'])) {
                                        echo $_POST['product_id[]'];
                                    } ?>
                                </option>
                                <?php }
                            }
                                ?>

                            </select>
                        </div>
                        <div class="col-3 mb-2">

                            <input type='number' id='quantity[]' name='quantity[]' class='form-control' min=1 />
                        </div>
                        <?php } ?>


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