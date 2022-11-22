<!DOCTYPE HTML>
<html>

<head>
    <title> Create a Record </title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read product details </title>

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
    include 'menu.php'
        ?>

    < !-- container -->
        <div class="container mt-5 p-5">
            <div class="page-header text-center">
                <h1>Read Product Detail </h1>
            </div>

            <!-- PHP read one record will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

            //include database connection
            include 'config/databased.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
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
                    <td>Name</td>
                    <td>
                        <?php echo htmlspecialchars($name, ENT_QUOTES); ?>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <?php echo htmlspecialchars($description, ENT_QUOTES); ?>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <?php echo htmlspecialchars($price, ENT_QUOTES); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>


        </div> <!-- end .container -->
        <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
            <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
        </div>
</body>

</html>