<?php
    if (isset($_SESSION['uid'])) {
        $url = $base_url . 'index';
        header('Refresh: 0 ; url = '.$url);
        exit();
    }
?>