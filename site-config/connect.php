<?php
    $mysqli = new mysqli('localhost','root','','mm-cupid');

    // check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>