<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Create a Record</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="username"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .error {
            color: red;
        }
    </style>
</head>





<!-- Custom styles for this template -->
<link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <?php
    $useErr = $pasErr = $staErr = "";

    if ($_POST) {

        include 'config/databased.php';

        //find username
        $username = htmlspecialchars(strip_tags($_POST['username']));
        //insert query 
        $query = "SELECT password , status FROM customer WHERE username=:username";
        //prepare query for execution
        $stmt = $con->prepare($query);
        //bind the parameters
        $stmt->bindParam(':username', $username);
        //execute the query
        $stmt->execute();
        $num = $stmt->rowCount();


        //if num > 0 means it found related info in database
        if ($num > 0) {

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $password = $row['password'];
            $status = $row['status'];

            if ($password == md5($_POST['password'])) {
                if ($status == 'Active') {
                    header("Location:http://localhost/webdev/neko/Home.php");
                    $_SESSION['user'] = $_POST['username'];

                } else {
                    $staErr = "Your Account is suspended *";
                }
            } else {
                $pasErr = "Incorrect Password*";
            }
        } else {
            $useErr = "User not found *";
        }
    }
    ?>

    <main class="form-signin">
        <span class="error">
            <?php echo $useErr; ?>
        </span>
        <span class="error">
            <?php echo $pasErr; ?>
        </span>
        <span class="error">
            <?php echo $staErr; ?>
        </span>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <img class="mb-4" src="image/IMG_20220107_162438_674.jpg" width="72" height="auto">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating ">
                <input type="text" class="form-control" name="username" value='<?php if (isset($_POST['username'])) {
                    echo $_POST['username'];
                } ?>'>
                <label for="username">
                    Username
                    </span>
                </label>
            </div>


            <div class="form-floating">
                <input type="password" class="form-control" name="password" value=''>
                <label for="password ">
                    Password
                </label>
            </div>

            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022 Online Shop. All rights reserved.</p>

        </form>
    </main>



</body>

</html>