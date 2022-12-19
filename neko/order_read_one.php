<?php
include 'session.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title> Create a Record </title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read order details </title>

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

    < !-- container -->
        <div class="container mt-5 p-5">
            <div class="page-header text-center">
                <h1>Read order details </h1>
            </div>

            <!-- PHP read one record will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
            $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/databased.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT order_detail_id, product_id, quantity, order_id ,price_each FROM order_detail WHERE order_id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $order_id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $order_detail_id = $row['order_detail_id'];
                $product_id = $row['product_id'];
                $quantity = $row['quantity'];
                $order_id = $row['order_id'];
                $price_each = $row['price_each'];


            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>


            <!-- HTML read one record table will be here -->
            <!--we have our html table here where the record will be displayed-->
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>order detail id</td>
                    <td>
                        <?php echo htmlspecialchars($order_detail_id, ENT_QUOTES); ?>
                    </td>
                </tr>
                <tr>
                    <td>product id</td>
                    <td>
                        <?php echo htmlspecialchars($product_id, ENT_QUOTES); ?>
                    </td>
                </tr>
                <tr>
                    <td>order id</td>
                    <td>
                        <?php echo htmlspecialchars($order_id, ENT_QUOTES); ?>
                    </td>
                </tr>
                <tr>
                    <td>price each</td>
                    <td>
                        <?php echo htmlspecialchars($price_each, ENT_QUOTES); ?>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <a href='order_read.php' class='btn btn-danger'>Back to read order</a>
                    </td>
                </tr>
            </table>


        </div> <!-- end .container -->
        <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
            <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
        </div>
</body>

</html>