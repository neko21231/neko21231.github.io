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
    <title>Order Read</title>

    <style>
        .error {
            color: red;
        }

        .td {
            display: flex;
            justify-content: space-evenly;
        }

        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <?php
    include 'menu.php';
    ?>

    <br>
    <!-- container -->
    <div class="container mt-5 p-5">
        <div class="page-header text-center">
            <h1>Order Read</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/databased.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? 
            $_GET['action'] : "";

        // if it was redirected from delete.php
        
        if ($action == 'deleted') {

            echo "<div class='alert alert-success'>Order was deleted.</div>";

        }
        if ($action == 'successful') {

            echo "<div class='alert alert-success'>Record was successful.</div>";

        }

        // select all data
        $query = "SELECT order_id, o.username,c.first_name,c.last_name ,order_date,total_amount 
        FROM order_summary o
        INNER JOIN customer c
        ON o.username = c.username";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='order_create.php' class='btn btn-primary m-b-1em'>Create New Order</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table
        
            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>userame</th>";
            echo "<th>first_name</th>";
            echo "<th>last_name</th>";
            echo "<th>order_date</th>";
            echo "<th>total_amount</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$first_name}</td>";
                echo "<td>{$last_name}</td>";
                echo "<td>{$order_date}</td>";

                echo "<td class= \"text-end\" > RM" . number_format((float) $total_amount, 2, '.', '') . "</td>";
                echo "<td>";
                // read one record
                echo "<a href='order_read_one.php?order_id={$order_id}' class='btn btn-info m-r-1em '>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='order_update.php?order_id={$order_id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$order_id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }



            // end table
            echo "</table>";


        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>


    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>

        // confirm record deletion

        function delete_user(order_id) {

            var answer = confirm('Are you sure ? ');

            if (answer) {

                // if user clicked ok,

                // pass the id to delete.php and execute the delete query

                window.location = 'order_delete.php?order_id=' + order_id;

            }

        }

    </script>

    <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
        <p>Copyrights &copy; 2022 Neko Online Shop. All rights reserved.</p>
    </div>
</body>

</html>