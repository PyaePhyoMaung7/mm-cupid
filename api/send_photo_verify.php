<?php
    session_start();
    require('../site-config/connect.php');
    require('../site-config/config.php');
    require('../site-config/include_functions.php');
    require('../site-config/check_member_auth.php');

    $response = [];
    $response['status'] = '500';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $request_data = file_get_contents('php://input');
        $decoded_data = json_decode($request_data,true);
        
        $user_id        = $_SESSION['uid'];
        $src            = $decoded_data['src'];
        $today_dt       = date('Y-m-d H:i:s');

        $update_sql     ="UPDATE `members` SET 
                            verify_photo= '$src',
                            status      =   2,
                            updated_at  = '$today_dt', 
                            updated_by  = '$user_id'
                            WHERE id    = '$user_id'";

        $result = $mysqli->query($update_sql);
        if($result){
            $_SESSION['status']= '2';
            $response['status']= '200';
            echo json_encode($response);
        }
    }
?>