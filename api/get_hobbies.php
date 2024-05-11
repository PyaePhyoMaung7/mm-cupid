<?php 
    require('../site-config/connect.php');
    require('../site-config/config.php');

    $sql = "SELECT id, name FROM `hobbies` WHERE deleted_at IS NULL";
    $result = $mysqli->query($sql);
    $data = [];
    $response_data = [];
    while($row = $result->fetch_assoc()){
        $id = $row['id'];
        $name = $row['name'];
        $data['id'] = $id;
        $data['name'] = $name;
        array_push($response_data, $data);
    }
    echo json_encode($response_data);
?>