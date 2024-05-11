<?php 
    require('./site-config/config.php');
    require('./site-config/connect.php');
    
    $email_confirm_code = isset($_GET['code']) ? $_GET['code'] : '';
    $email_confirm_code = $mysqli->real_escape_string($email_confirm_code);

    $sql = "UPDATE `members` SET status = '1' WHERE email_confirm_code = '$email_confirm_code'";
    $result = $mysqli->query($sql);

    if($result){
        $url = $base_url . 'login.php?msg=1';
        header('Refresh: 0 ; url = '.$url);
        exit();
    }else{
        $url = $admin_base_url . 'login.php';
        header('Refresh: 0 ; url = '.$url);
        exit();
    }
?>