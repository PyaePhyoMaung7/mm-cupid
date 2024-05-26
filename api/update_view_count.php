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
        $id           = $decoded_data['id'];
        $sql = "UPDATE `members` SET view_count = view_count + 1 WHERE id = '$id'";
        
        $result = $mysqli->query($sql);
        
        if($result) {
            $response['status'] = '200';
            $response['id'] = $id;
            echo json_encode($response);
        }
    }
?>