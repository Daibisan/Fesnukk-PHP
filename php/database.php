<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "businessdb";
    $db_port = 3307;
    $conn = "";

    try {
        $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name,$db_port);

    } catch(mysqli_sql_exception) {
        echo"Cant connect to DB <br>";
    }
?>