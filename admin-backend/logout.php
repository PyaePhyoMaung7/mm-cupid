<?php
    require('../site-config/config.php');

    session_start();
    session_unset();
    session_destroy();

    setcookie('id', '', time()-3600, '/');
    setcookie('username', '', time()-3600, '/');

    $url    = $admin_base_url.'login.php';
    header('Refresh:0; url='.$url);
    exit();

?>