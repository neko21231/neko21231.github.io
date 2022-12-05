<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location:loginpage.php?action=denied");

}

?>