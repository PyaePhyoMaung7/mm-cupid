<?php
    $auth = false;
    if(isset($_SESSION['id']) || isset($_SESSION['username']) ){
        $user_id = $_SESSION['id'];
        $auth   = true;
    }

    if(isset($_COOKIE['id']) | isset($_COOKIE['username'])){
        $user_id = $_COOKIE['id'];
        $auth   = true;
    }

    if(!$auth){
        $url= $admin_base_url.'login.php';
        header('Refresh:0; url='.$url);
        exit();
    }else{
        $auth_sql   = "SELECT status FROM `user` WHERE id = '$user_id' AND deleted_at IS NULL";
        $result     = $mysqli->query($auth_sql);
        $res_row    = $result->num_rows;
        if($res_row <= 0){
            $url= $admin_base_url.'logout.php';
            header('Refresh:0; url='.$url);
            exit();
        }else{
            $user = $result->fetch_assoc();
            if($user['status'] == 1){
                $url= $admin_base_url.'logout.php';
                header('Refresh:0; url='.$url);
                exit();
            }
        }
    }
?>