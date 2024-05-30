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
        $decoded_data   = json_decode($request_data,true);
        $invite_id      = $decoded_data['id'];
        $status         = $decoded_data['status'];
        $member_id      = $_SESSION['uid'];
        $status         = $mysqli->real_escape_string($status);
        
        $today_dt       = date('Y-m-d H:i:s');

        $update_sql     ="UPDATE `date_request` 
                            SET status = '$status',
                            updated_at = '$today_dt',
                            updated_by = '$member_id'
                            WHERE invite_id = '$invite_id' AND accept_id = '$member_id'";

        $result = $mysqli->query($update_sql);

        $response['status'] = '200';
        echo json_encode($response);
    }
?>