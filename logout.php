<?php
    session_start();
    require('../site-config/config.php');

    session_unset();
    session_destroy();

    $url    = $admin_base_url.'login';
    header('Refresh:0; url='.$url);
    exit();

?>