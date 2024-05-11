<?php
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : $_COOKIE['role'];
    
    if(!in_array($user_role, $auth_role)) {
        $url = $admin_base_url . '403_page.php';
        header('Refresh: 0 ; url = '.$url);
        exit();
    }
?>