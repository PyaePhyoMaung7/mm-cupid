<?php 
    session_start();

    $auth_role  = [1];
    require('../site-config/admin_require.php');
    $title      = ": Confirm Member";
    $id         = (int) $_GET['id'];
    $id         = $mysqli->real_escape_string($id);
    $user_id    = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];

    $today_dt   = date('Y-m-d H:i:s');
    $sql        = "UPDATE `members` SET status = '4', updated_at = '$today_dt', updated_by = '$user_id' WHERE id = '$id'";
    $result     = $mysqli->query($sql);

    $url        = $admin_base_url . 'show_member.php';
    header('Refresh: 0 ; url = '.$url);
    exit();
?>