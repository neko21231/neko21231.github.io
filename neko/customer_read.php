<!DOCTYPE HTML>
<html>
<head>
    <title> Create a Record </title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read customer</title>

    <style>
        .error {
            color: red;
        }
        .td{display: flex;
  justify-content: space-evenly;}
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
<br>
    <!-- container -->
    <div class="container mt-5 p-5">
        <div class="page-header text-center">
            <h1>Read customer</h1>
        </div>
     
        <!-- PHP code to read records will be here -->
        <?php
// include database connection
include 'config/databased.php';
 
// delete message prompt will be here
 
// select all data
$query = "SELECT  username, gender FROM customer ORDER BY username DESC";
$stmt = $con->prepare($query);
$stmt->execute();
 
// this is how to get number of rows returned
$num = $stmt->rowCount();
 
// link to create record form
echo "<a href='Create_Customer.php' class='btn btn-primary m-b-1em'>Create New customer</a>";
 
//check if more than 0 record found
if($num>0){
 
    // data from database will be here
    echo "<table class='table table-hover table-responsive table-bordered'>";//start table
 
    //creating our table heading
    echo "<tr>";
        echo "<th>username</th>";
        echo "<th>gender</th>";
        echo "<th>Action</th>";
    echo "</tr>";
     
    // table body will be here
    // retrieve our table contents
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // extract row
    // this will make $row['firstname'] to just $firstname only
    extract($row);
    // creating new table row per record
    echo "<tr>";
        
        echo "<td>{$username}</td>";
        echo "<td>{$gender}</td>";
        echo "<td>";
            // read one record
            echo "<a href='customer_read_one.php?username={$username}' class='btn btn-info m-r-1em '>Read</a>";
             
            // we will use this links on next part of this post
            echo "<a href='update.php?username={$username}' class='btn btn-primary m-r-1em'>Edit</a>";
 
            // we will use this links on next part of this post
            echo "<a href='#' onclick='delete_user({$username});'  class='btn btn-danger'>Delete</a>";
        echo "</td>";
    echo "</tr>";
}


 
// end table
echo "</table>";

     
}
// if no records found
else{
    echo "<div class='alert alert-danger'>No records found.</div>";
}
?>

         
    </div> <!-- end .container -->
 
    <!-- confirm delete record will be here -->
  <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
        <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
    </div>
</body>
</html>