<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
    echo "<h1>You are now logged out.</h1>";
    header('Refresh: 2; URL = login.php');
?>
