<?php
include 'session.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Update Product</title>
    <!-- Latest compiled and minified Bootstrap CSS →-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update product</title>
    <!--custom css →-->
    <style>
        .error {
            color: red;
        }

        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <?php
    include 'menu.php';
    ?>

    <!--container →-->
    <div class="container">
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <!-- PHP read record by ID will be here →-->
        <?php
        // get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/databased.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description, price,promotion_price, manufacture_date, expire_date FROM products WHERE id = ? ";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expire_date = $row['expire_date'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!--HTML form to update record will be here   -->
        <!-- PHP post to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE products
                  SET name=:name, description=:description, price=:price ,promotion_price=:promotion_price, manufacture_date=:manufacture_date, expire_date=:expire_date WHERE id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));

                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));


                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expire_date = htmlspecialchars(strip_tags($_POST['expire_date']));

                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':promotion_price', $promotion_price);
                $stmt->bindParam(':manufacture_date', $manufacture_date);
                $stmt->bindParam(':expire_date', $expire_date);
                $stmt->bindParam(':id', $id);

                if (empty($promotion_price)) {
                    $promotion_price = NULL;
                } else if (($_POST["promotion_price"]) > ($_POST["price"])) {
                    $proErr = "Promotion price should be cheaper than original price *";
                }
                if (empty($expire_date)) {
                    $expire_date = NULL;
                } else if (($_POST["expire_date"]) < ($_POST["manufacture_date"])) {
                    $proErr = "Promotion price should be cheaper than original price *";

                }
                // Execute the query
                if ($stmt->execute()) {
                    header("Location:product_read.php?action=successful");
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>


        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                            class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES); ?>
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>"
                            class='form-control' />
                    </td>

                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td>
                        <input type='text' name='promotion_price' value="<?php
                        if (empty($promotion_price)) {
                            echo "-";
                        } else {
                            echo htmlspecialchars($promotion_price, ENT_QUOTES);
                        }
                        ?>" class='form-control' />
                    </td>
                </tr>

                <tr>
                    <td>Manufacture Date</td>
                    <td>
                        <input type='date' name='manufacture_date'
                            value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES); ?>"
                            class='form-control' />
                    </td>
                </tr>

                <tr>
                    <td>Expire Date</td>
                    <td>
                        <input type='date' name='expire_date' value="<?php
                        if (empty($expire_date)) {
                            echo "-";
                        } else {
                            echo htmlspecialchars($expire_date, ENT_QUOTES);
                        } ?>" class='form-control' />
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
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

</html>