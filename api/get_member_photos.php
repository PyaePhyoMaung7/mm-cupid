<?php 
    session_start();
    require('../site-config/connect.php');
    require('../site-config/config.php');
    require('../site-config/check_member_auth.php');

    $response = [];
    $response['status'] = '500';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $request_data   = file_get_contents('php://input');
        $decoded_data   = json_decode($request_data,true);
        $id             = $decoded_data['id'];
        $id             = $mysqli->real_escape_string($id);
        $sql    = "SELECT name FROM `member_gallery` WHERE member_id = '$id'";
        $result = $mysqli->query($sql);
        
        $data = [];
        while($row = $result->fetch_assoc()){
            $photo_path = $base_url . 'assets/uploads/' .  $id . '/' . $row['name'];
            array_push($data, $photo_path);
        }
        $response['data'] = $data;
    }  

    echo json_encode($response);
?>