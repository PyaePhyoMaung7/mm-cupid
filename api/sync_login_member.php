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
        $member_id      = $_SESSION['uid'];
        $sql = "SELECT T01.id, T01.username, T01.email, T01.phone, T01.gender, T01.date_of_birth, TIMESTAMPDIFF(YEAR, T01.date_of_birth, CURDATE()) AS age, 
                T01.education, T01.city_id, T01.height_feet, T01.height_inches, T01.status, T01.about, 
                T01.partner_gender, T01.partner_min_age, T01.partner_max_age, T01.last_login, 
                T01.point, T01.work, T01.religion, T01.thumbnail, T01.view_count,
                T02.name AS city
                FROM `members` T01
                JOIN `city` T02
                ON T01.city_id = T02.id
                WHERE T01.id = '$member_id'";
        $result = $mysqli->query($sql);

        $response_data = [];
        $row = $result->fetch_assoc();

        $member_id = (int) ($row['id']);
        $username  = htmlspecialchars($row['username']);
        $age = (int) ($row['age']);
        $thumb_name = $row['thumbnail'];
        $thumb_path = $base_url . 'assets/uploads/' . $member_id . '/thumb/' . $thumb_name;
        $email      = htmlspecialchars($row['email']);
        $phone      = htmlspecialchars($row['phone']);
        $gender     = (int)$row['gender'];
        $date_of_birth = htmlspecialchars($row['date_of_birth']);
        $education  = htmlspecialchars($row['education']);
        $work       = htmlspecialchars($row['work']);
        $about      = htmlspecialchars($row['about']);

        $city       = $row['city'];

        $response_data['id'] = $member_id;
        $response_data['username'] = $username;
        $response_data['age'] = $age;
        $response_data['thumb'] = $thumb_path;
        $response_data['email'] = $email;
        $response_data['phone'] = $phone;
        $response_data['gender'] = $gender;
        $response_data['birthday'] = $date_of_birth;
        $response_data['education'] = $education;
        $response_data['work'] = $work;
        $response_data['about'] = $about;

        $response_data['city'] = $city;

        $response['data'] = $response_data;
        $response['status'] = '200';
        $response['data'] = $response_data;
        
        echo json_encode($response);
    }
?>