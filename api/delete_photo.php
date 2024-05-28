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
        $sort           = $decoded_data['sort'];
        $today_dt       = date('Y-m-d H:i:s');
        $member_id      = $_SESSION['uid'];

        $delete_sql = "UPDATE `member_gallery` 
                        SET deleted_at  = '$today_dt',
                        deleted_by      = '$member_id'
                        WHERE member_id = '$member_id'
                        AND sort        = '$sort'
                        AND deleted_at IS NULL";
        $mysqli->query($delete_sql);

        if($result) {
            $response['status'] = '200';
            echo json_encode($response);
        }
    }
?>