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
        $pageNo         = $decoded_data['page'];
        $limit          = 3;
        $offset         = ($pageNo - 1) * $limit;
        $afterLimit     = $offset + $limit;
        $member_id      = $_SESSION['uid'];

        $get_members = "SELECT id, username, thumbnail, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM `members` WHERE id != '$member_id' AND deleted_at IS NULL LIMIT $offset, $limit";
        $result = $mysqli->query($get_members);
        $data = [];
        $response_data = [];
        while($row = $result->fetch_assoc()){
            $data['id'] = (int) $row['id'];
            $data['username'] = htmlspecialchars( $row['username']);
            $data['age'] = (int) $row['age'];
            $data['thumb'] = $base_url . 'assets/uploads/' .  $data['id'] . '/thumb/' . $row['thumbnail'];
            array_push($response_data, $data);
        }

        $more_members = "SELECT id FROM `members` WHERE id != '$member_id' LIMIT $afterLimit, 1";
        $more_memebrs_res = $mysqli->query($more_members);
        if($more_memebrs_res->num_rows > 0){
            $response['more_member_exist'] = true;
        }else{
            
            $response['more_member_exist'] = false;
        }
        $response['status'] = '200';
        $response['data'] = $response_data;
        
        echo json_encode($response);
    }
?>