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
    <title>create customer</title>

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
            <h1>Create Customer</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->

        <?php
        $nameErr = $passErr = $firErr = $lasErr = $genErr = $dobErr = "";
        $flag = false;

        if ($_POST) {
            // include database connection
            include 'config/databased.php';
            try {



                // posted values
                if (empty($_POST["username"])) {
                    $nameErr = "UserName is required *";
                    $flag = true;
                } else {
                    $username = htmlspecialchars(strip_tags($_POST['username']));
                }



                if (empty($_POST["password"])) {
                    $passErr = "Password is required *";
                    $flag = true;
                } else {
                    $password = md5($_POST['password']);


                }
                if (empty($_POST["confirm_password"])) {
                    $passErr = "Please Confirm Your Password  *";
                    $flag = true;
                } else if ($_POST["password"] == $_POST["confirm_password"]) {
                    // success!
        
                    $password = md5($_POST['password']);

                } else {
                    $passErr = "Please make sure your password are match.  *";
                    $flag = true;
                }

                if (empty($_POST["first_name"])) {
                    $firErr = "First Name is required *";
                    $flag = true;
                } else {
                    $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                }
                if (empty($_POST["last_name"])) {
                    $lasErr = "Last Name is required *";
                    $flag = true;
                } else {
                    $last_name = htmlspecialchars(strip_tags($_POST['last_name']));

                }
                if (empty($_POST["gender"])) {
                    $genErr = "please choose a gender *";
                    $flag = true;
                } else {
                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                }
                if (empty($_POST["date_of_birth"])) {
                    $dobErr = "date of birth is required *";
                    $flag = true;
                } else {
                    $date_of_birth = ($_POST['date_of_birth']);

                }




                if ($flag == false) {
                    // insert query
                    $query = "INSERT INTO customer SET username=:username, password=:password,first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth , time_registration=:time_registration";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    // specify when this record was inserted to the database
                    $time_registration = date('Y-m-d H:i:s');
                    $stmt->bindParam(':time_registration', $time_registration);
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
            //show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><span class="error">
                            <?php echo $nameErr; ?>
                        </span>
                        <input type='text' name='username' minlength="6" class='form-control' value='<?php
                        if (isset($_POST['username'])) {
                            echo $_POST['username'];
                        }
                        ?> ' />
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><span class="error">
                            <?php echo $passErr; ?>
                        </span>
                        <input type='password' name='password' minlength="6" class='form-control' value='<?php if (isset($_POST['password'])) {
                            echo $_POST['password'];
                        } ?>' />
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><span class="error">
                            <?php echo $passErr; ?>
                        </span>
                        <input type='password' name='confirm_password' minlength="6" class='form-control' value='<?php if (isset($_POST['password'])) {
                            echo $_POST['password'];
                        }
                        ?>' />
                    </td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><span class="error">
                            <?php echo $firErr; ?>
                        </span>
                        <input type='text' name='first_name' class='form-control' value='<?php
                        if (isset($_POST['first_name'])) {
                            echo $_POST['first_name'];
                        }
                        ?> ' />
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><span class="error">
                            <?php echo $lasErr; ?>
                        </span>
                        <input type='text' name='last_name' class='form-control' value='<?php
                        if (isset($_POST['last_name'])) {
                            echo $_POST['last_name'];
                        } ?>' />
                    </td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><span class="error">
                            <?php echo $genErr; ?>
                        </span>
                        <input type='radio' id="gender" name='gender' value='male' <?php if (isset($_POST["gender"])) {
                            if ($_POST['gender'] == "male") {
                                echo "checked";
                            }
                        } ?>/>
                        <label for="male">MALE</label><br>
                        <input type='radio' id="gender" name='gender' value='female' <?php if (isset($_POST["gender"]))
                            if ($_POST['gender'] == "female") {
                                echo "checked";
                            } ?>/>
                        <label for="female">FEMALE</label><br>

                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><span class="error">
                            <?php echo $dobErr; ?>
                        </span>
                        <input type='date' name='date_of_birth' class='form-control' value='<?php
                        if (isset($_POST['date_of_birth'])) {
                            echo $_POST['date_of_birth'];
                        } ?>' />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-success' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to Read Customer</a>
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


</html>