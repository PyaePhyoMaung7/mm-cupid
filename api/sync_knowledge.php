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
        $record_per_page= 6;
        $offset         = ($pageNo - 1) * $record_per_page;
        $member_id      = $_SESSION['uid'];
        $total_show_data= $pageNo * $record_per_page;

        $get_knowledge_sql = "SELECT id, title, description, thumbnail, image, created_at, updated_at 
                                FROM `knowledge` WHERE deleted_at IS NULL LIMIT $offset, $record_per_page";
        
        $result = $mysqli->query($get_knowledge_sql);

        $data = [];
        $response_data = [];
        while($row = $result->fetch_assoc()){
            $id                 = (int) $row['id'];
            $data['id']         = $id;
            $data['title']      = htmlspecialchars($row['title']);
            $data['description']= htmlspecialchars($row['description']);
            $thumb              = htmlspecialchars($row['thumbnail']);
            $image              = htmlspecialchars($row['image']);
            $data['thumb']      = $base_url . 'assets/post_images/' .  $id . '/thumb/' . $thumb;
            $data['image']      = $base_url . 'assets/post_images/' .  $id . '/' . $image;
            $data['created_at'] = $row['created_at'];
            $data['updated_at'] = $row['updated_at'];
            array_push($response_data, $data);
        }

        $more_knowledge_sql = "SELECT count(id) AS total FROM `knowledge` WHERE deleted_at IS NULL";
        $more_knowledge_res = $mysqli->query($more_knowledge_sql);
        $row2 = $more_knowledge_res->fetch_assoc();
        $total_count = $row2['total'];

        if($total_count <= $total_show_data){
            $response['show_more'] = false;
        }else{
            $response['show_more'] = true;
        }

        $response['status'] = '200';
        $response['data'] = $response_data;
        
        echo json_encode($response);
    }
?>