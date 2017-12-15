<?php 
    session_start();
    unset($_SESSION['user']);
    unset($_SESSION['username']);
    header("Location: catalog.php"); 
    die("Redirecting to: catalog.php");
?>