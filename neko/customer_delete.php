<?php

// include database connection

include 'config/databased.php';

try {

    // get record ID

    // isset() is a PHP function used to verify if a value is there or not

    $username = isset($_GET['username']) ? $_GET['username'] :
        die('ERROR: Record ID not found.');

    // delete query

    $query = "SELECT o.username, c.username FROM order_summary o INNER JOIN customer c ON c.username = o.username WHERE c.username = ? LIMIT 0,1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();
    $num = $stmt->rowCount();

    //if num > 0 means it found related info in database
    if ($num > 0) {
        header('Location:customer_read.php?action=failed');
    } else {
        $query = "DELETE FROM customer WHERE username = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $username);

        if ($stmt->execute()) {
            header('Location:customer_read.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }

}
// show error
catch (PDOException $exception) {

    die('ERROR: ' . $exception->getMessage());

}


?>