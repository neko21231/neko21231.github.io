
<!DOCTYPE HTML>
<html>

<head>
    <title> Create a Record </title>
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

    <nav class="navbar navbar-dark bg-info fixed-top ">
        <div class="container-fluid">
            <a class="navbar-brand " href="#">neko Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-info " tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">neko Shop</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 ">
                        <li class="nav-item">
                            <a class="nav-link " href="Home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="product_create.php">Create Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="contact_us.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="Create_Customer.php">Create Customer</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

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
                if (empty($_POST["description"])) {
                    $desErr = "Description is required *";
                    $flag = true;
                } else {
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                }
                if (empty($_POST["price"])) {
                    $priErr = "Price is required *";
                    $flag = true;
                } else {
                    $price = htmlspecialchars(strip_tags($_POST['price']));
                }
                if (empty($_POST["promotion_price"])) {
                    $proErr = "Promotion price is required *";
                    $flag = true;
                } else {
                    $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                    if (($_POST["promotion_price"]) > ($_POST['price'])) {
                        $proErr = "Promotion price should be cheaper than original price *";
                        $flag = true;
                    }
                }
                if (empty($_POST["manufacture_date"])) {
                    $manuErr = "Manufacture date is required *";
                    $flag = true;
                } else {
                    $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                }
                if (empty($_POST["expire_date"])) {
                    $exErr = "Expired date is required *";
                    $flag = true;
                } else {
                    $expire_date = htmlspecialchars(strip_tags($_POST['expire_date']));
                    if (($_POST["expire_date"]) < ($_POST['manufacture_date'])) {
                        $exErr = "Expired date should be later than manufacture date *";
                        $flag = true;
                    }
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
                        echo "<div class='alert alert-success'>Record was saved.</div>";
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
                    <td><span class="error"><?php echo $nameErr; ?></span>
                        <input type='text' name='name' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><span class="error"><?php echo $desErr; ?></span>
                        <textarea name='description' class='form-control'></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><span class="error"><?php echo $priErr; ?></span>
                        <input type='text' name='price' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><span class="error"><?php echo $proErr; ?></span>
                        <input type='text' name='promotion_price' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><span class="error"><?php echo $manuErr; ?></span>
                        <input type='date' name='manufacture_date' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td>Expire Date</td>
                    <td><span class="error"><?php echo $exErr; ?></span>
                        <input type='date' name='expire_date' class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-success' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->

    <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
        <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
    </div>

</body>

<grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration>

</html>

