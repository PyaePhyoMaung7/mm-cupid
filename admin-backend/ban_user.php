<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');
    $id = (int) $_GET['id'];
    $id = htmlspecialchars($id);
    $ban_sql = "UPDATE `user` SET status = 1 WHERE id = '$id'";
    $result = $mysqli->query($ban_sql);
    if($result) {
        $url = $admin_base_url . 'show_user.php';
        header('Refresh: 0 ; url = '.$url);
        exit();
    }
?>