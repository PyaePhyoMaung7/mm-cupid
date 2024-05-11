<?php
    $auth = false;
    if(isset($_SESSION['uid']) || isset($_SESSION['uemail']) ){
        $member_id = $_SESSION['uid'];
        $auth   = true;
    }

    if(!$auth){
        $url= $base_url.'login';
        header('Refresh:0; url='.$url);
        exit();
    }else{
        $auth_sql   = "SELECT status FROM `members` WHERE id = '$member_id' AND deleted_at IS NULL";
        $result     = $mysqli->query($auth_sql);
        $res_row    = $result->num_rows;
        if($res_row <= 0){
            $url= $base_url.'logout';
            header('Refresh:0; url='.$url);
            exit();
        }else{
            $user = $result->fetch_assoc();
            if($user['status'] == 0 || $user['status'] == 3){
                $url= $admin_base_url.'logout';
                header('Refresh:0; url='.$url);
                exit();
            }
        }
    }
?>