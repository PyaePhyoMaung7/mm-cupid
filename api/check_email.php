<?php 
    require('../site-config/connect.php');
    require('../site-config/config.php');

    $email = $_GET['email'];
    $sql = "SELECT count(id) AS total FROM `members` WHERE email = '$email'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    if($row['total'] > 0){
        echo json_encode(['email_exist'=>true]);
    }else{
        echo json_encode(['email_exist'=>false]);
    }
    
?>