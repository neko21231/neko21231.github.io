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
 
    < !-- container -->
    <div class="container mt-5 p-5">
        <div class="page-header text-center">
            <h1>Read customer Detail </h1>
        </div>
         
        <!-- PHP read one record will be here -->
        <?php

 
//include database connection
include 'config/databased.php';

// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$username=isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record username not found.');

// read current record's data
try {
    // prepare select query
    $query = "SELECT  username, gender, first_name,last_name,date_of_birth FROM customer WHERE username = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
 
    // this is the first question mark
    $stmt->bindParam(1, $username);
 
    // execute our query
    $stmt->execute();
 
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // values to fill up our form
    $username = $row['username'];
    $gender = $row['gender'];
    $first_name = $row['first_name'];
    $last_name=$row['last_name'];
    $date_of_birth=$row['date_of_birth'];
   
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

 
        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Gender</td>
        <td><?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>First Name</td>
        <td><?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td><?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Birthday</td>
        <td><?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?></td>
    </tr>
    
    <tr>
        <td></td>
        <td>
            <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
        </td>
    </tr>
</table>

 
    </div> <!-- end .container -->
    <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
        <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
    </div>
</body>
</html>