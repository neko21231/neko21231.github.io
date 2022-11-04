<!DOCTYPE HTML>
<html>
<head>
    <title>Create a Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
</head>
<body>  
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
       

        <nav class="navbar navbar-expand-lg bg-info">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"" href="product_create.php">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Create_Customer.php">Create Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
      
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
if($_POST){
    // include database connection
    include 'config/databased.php';
    try{
        // posted values
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $description=htmlspecialchars(strip_tags($_POST['description']));
        $price=htmlspecialchars(strip_tags($_POST['price']));
        $promo=htmlspecialchars(strip_tags($_POST['promotion']));
        $manu=htmlspecialchars(strip_tags($_POST['manu']));
        $expire=htmlspecialchars(strip_tags($_POST['expire']));
        // insert query
        $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion,manufacture_date=:manu ,expire_date=:expire, created=:created";
        // prepare query for execution
        $stmt = $con->prepare($query);
        // bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':promotion', $promo);
        $stmt->bindParam(':manu', $manu);
        $stmt->bindParam(':expire', $expire);
        
        // specify when this record was inserted to the database
        $created=date('Y-m-d H:i:s');
        $stmt->bindParam(':created', $created);
        // Execute the query

        // True because $stmt is empty
        
        if (empty($_POST['name'])) {
            echo "<div class='alert alert-danger'>Your the name is empty.</div>";
        } elseif (empty($_POST['description'])) {
            echo "<div class='alert alert-danger'>Your the Description is empty.</div>";
        } elseif (empty($_POST['price'])) {
            echo "<div class='alert alert-danger'>Your the Price is empty.</div>";
        } elseif (empty($_POST['promotion'])) {
            echo "<div class='alert alert-danger'>Your the Promotion Price is empty.</div>";
        } elseif (empty($_POST['manu'])) {
            echo "<div class='alert alert-danger'>Your the Manufacture Date is empty.</div>";
        }elseif($promo>$price){
            echo "<div class='alert alert-danger'>Promotion price should be smaller than actual price.</div>";
        }



        if (empty($_POST["expire"])) {
            $expErr = "<div class='alert alert-danger'>Your the Expired Date is empty .</div>";
            echo $expErr;
        } else {
            $expire = $_POST["expire"];
            if (($_POST["expire"]) < ($_POST["manu"])) {
                $expErr = "<div class='alert alert-danger'>Expired date should be later than manufacture date.</div>";
                echo $expErr;
            }
        }     

        if (empty($_POST["price"])) {
            $expErr = "<div class='alert alert-danger'>Your the price is empty .</div>";
            echo $expErr;
        } else {
            $price = $_POST["price"];
            if (($_POST["price"]) < ($_POST["promotion"])) {
                $expErr = "<div class='alert alert-danger'>price should be more than promotion price.</div>";
                echo $expErr;
            }
        }  
        
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        } 

    }
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>


        
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control' rows="4" cols="50"></textarea></td>
        </tr>
        
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
        <tr>
            <td>Promotion_price</td>
            <td><input type='text' name='promotion' class='form-control' /></td>
        </tr>
            <td>Manufacture_date</td>
            <td><input type='date' name='manu' class='form-control' /></td>
        </tr>   

            <td>Expire_date</td>
            <td><input type='date' name='expire' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
                <a href='index.php' class='btn btn-danger'>Back to read products</a>
            </td>
        </tr>
    </table>
</form>


    </div> 
    <!-- end .container -->  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

