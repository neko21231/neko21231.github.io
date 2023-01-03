<?php
include 'session.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title> Create a Product</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>create product</title>

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
    <div class="container mt-5 p-5">
        <div class="page-header text-center">
            <h1>Create Product</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->

        <?php
        $nameErr = $desErr = $priErr = $proErr = $manuErr = $exErr = "";
        $flag = false;

        if ($_POST) {
            // include database connection
            include 'config/databased.php';
            try {
                // posted values
                if (empty($_POST["name"])) {
                    $nameErr = "Name is required *";
                    $flag = true;
                } else {
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                }

                $description = htmlspecialchars(strip_tags($_POST['description']));


                if (empty($_POST["price"])) {
                    $priErr = "Price is required *";
                    $flag = true;
                } else {
                    $price = htmlspecialchars(strip_tags($_POST['price']));
                }

                if (empty($_POST["promotion_price"])) {
                    $promotion_price = null;

                } else if (($_POST["promotion_price"]) > ($_POST["price"])) {
                    $proErr = "Promotion price should be cheaper than original price *";
                    $flag = true;
                } else {
                    $promotion_price = htmlspecialchars(strip_tags($_POST["promotion_price"]));
                }

                if (empty($_POST["manufacture_date"])) {
                    $manuErr = "Manufacture date is required *";
                    $flag = true;
                } else {
                    $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                }

                if (empty($_POST["expire_date"])) {
                    $expire_date = "-";

                } else if (($_POST["expire_date"]) < ($_POST['manufacture_date'])) {
                    $exErr = "Expired date should be later than manufacture date *";
                    $flag = true;
                } else {
                    $expire_date = htmlspecialchars(strip_tags($_POST['expire_date']));
                }
                if ($flag == false) {
                    // insert query
        
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expire_date=:expire_date";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expire_date', $expire_date);
                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);
                    // Execute the query
        
                    if ($stmt->execute()) {
                        header("Location:product_read.php?action=successful");

                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }

                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><span class="error">
                            <?php echo $nameErr; ?>
                        </span>
                        <input type='text' name='name' class='form-control' value='<?php
                        if (isset($_POST['name'])) {
                            echo $_POST['name'];
                        }
                        ?>' />
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><span class="error">
                            <?php echo $desErr; ?>
                        </span>
                        <textarea name='description' class='form-control'><?php
                        if (isset($_POST['description'])) {
                            echo $_POST['description'];
                        }
                        ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><span class="error">
                            <?php echo $priErr; ?>
                        </span>
                        <input type='text' name='price' class='form-control' value='<?php
                        if (isset($_POST['price'])) {
                            echo $_POST['price'];
                        }
                        ?>' />
                    </td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><span class="error">
                            <?php echo $proErr; ?>
                        </span>
                        <input type='text' name='promotion_price' class='form-control' value='<?php
                        if (isset($_POST['promotion_price'])) {
                            echo $_POST['promotion_price'];
                        } ?>' />
                    </td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><span class="error">
                            <?php echo $manuErr; ?>
                        </span>
                        <input type='date' name='manufacture_date' class='form-control' value='<?php
                        if (isset($_POST['manufacture_price'])) {
                            echo $_POST['manufacture_price'];
                        } ?>' />
                    </td>
                </tr>
                <tr>
                    <td>Expire Date</td>
                    <td><span class="error">
                            <?php echo $exErr; ?>
                        </span>
                        <input type='date' name='expire_date' class='form-control' value='<?php
                        if (isset($_POST['expire_date'])) {
                            echo $_POST['expire_date'];
                        } ?>' />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-success' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->

    <?php
    include 'copyright.php';

    ?>

</body>

<grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration>

</html>