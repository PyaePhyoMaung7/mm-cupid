<?php
    session_start();
    require('../site-config/connect.php');
    require('../site-config/config.php');
    require('../site-config/include_functions.php');
    require('../site-config/check_member_auth.php');

    $response = [];
    $response['status'] = '500';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $request_data   = file_get_contents('php://input');
        $decoded_data   = json_decode($request_data, true);
        $member_id      = $_SESSION['uid'];
        $status         = $decoded_data['status'];
        $today_dt       = date('Y-m-d H:i:s');
        $sql = "UPDATE `members` 
                SET love_status = '$status',
                updated_at      = '$today_dt',
                updated_by      = '$member_id'
                WHERE id = '$member_id'";
                
        $result = $mysqli->query($sql);
        
        if($result) {
            $_SESSION['status']         = $status;
            $response['status']         = '200';
            $response['love_status']    = $status;
            echo json_encode($response);
        }
    }
?>