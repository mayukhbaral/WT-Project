<?php

    $dbHost = 'localhost';
    $dbName = 'register';
    $dbUsername = 'root';
    $dbPassword = '';
    $conn = mysqli_connect($dbHost, $dbUsername,$dbPassword, $dbName);
    if (!$conn) {
        echo "Something is wrong";
    }

?>