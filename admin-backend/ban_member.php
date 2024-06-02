<?php 
    session_start();

    $auth_role  = [1];
    require('../site-config/admin_require.php');
    $title      = ": Delete Member";
    $id         = (int) $_GET['id'];
    $status     = (int) $_GET['status'];
    $id         = $mysqli->real_escape_string($id);
    $status     = $mysqli->real_escape_string($status);
    $user_id    = isset($_SESSION['id']) ? $_SESSION['id'] : $_COOKIE['id'];

    $today_dt   = date('Y-m-d H:i:s');
    $sql        = "UPDATE `members` SET status = '$status',  updated_at = '$today_dt', updated_by = '$user_id' WHERE id = '$id'";
    $result     = $mysqli->query($sql);

    // $url        = $admin_base_url . 'show_member.php';
    // header('Refresh: 0 ; url = '.$url);
    echo "<script>history.back()</script>";
    exit();
   
?>