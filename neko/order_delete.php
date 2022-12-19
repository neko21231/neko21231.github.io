<?php

// include database connection

include 'config/databased.php';

try {

    // get record ID

    // isset() is a PHP function used to verify if a value is there or not

    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] :
        die('ERROR: Record ID not found.');

    // delete query

    $query = "DELETE FROM order_summary  WHERE order_id = ?";

    $stmt = $con->prepare($query);

    $stmt->bindParam(1, $order_id);

    if ($stmt->execute()) {
        $query = "DELETE FROM order_detail WHERE order_id=?";
        $stmt = $con->prepare($query);

        $stmt->bindParam(1, $order_id);
        if ($stmt->execute()) {

            // redirect to read records page and

            // tell the user record was deleted

            header('Location:order_read.php?action=deleted');

        } else {

            die('Unable to delete order detail.');

        }

    } else {
        die('Unable to delete order summary.');

    }
}

// show error
catch (PDOException $exception) {

    die('ERROR: ' . $exception->getMessage());

}

?>