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
        $sql = "SELECT T01.*, TIMESTAMPDIFF(YEAR, T01.date_of_birth, CURDATE()) AS age, 
                            CASE 
                                WHEN gender = 0 THEN 'male'
                                ELSE 'female'
                            END AS gender_name,
                            CASE
                                WHEN religion = 1 THEN 'Christian'
                                WHEN religion = 2 THEN 'Muslim'
                                WHEN religion = 3 THEN 'Buddhist'
                                WHEN religion = 4 THEN 'Hindu'
                                WHEN religion = 5 THEN 'Jain'
                                WHEN religion = 6 THEN 'Shinto'
                                WHEN religion = 7 THEN 'Atheist'
                                ELSE 'Other'
                            END AS religion_name,
                            T02.name AS city_name
                            FROM `members` AS T01
                            LEFT JOIN `city` AS T02
                            ON T01.city_id = T02.id
                            WHERE T01.id = '$member_id'";

        $result = $mysqli->query($sql);

        $data = [];
        $row = $result->fetch_assoc();

        $data['id'] = (int) ($row['id']);
        $data['username']       = htmlspecialchars($row['username']);
        $data['age']            = (int) ($row['age']);
        $thumb_name             = $row['thumbnail'];
        $data['thumb']          = $base_url . 'assets/uploads/' . $member_id . '/thumb/' . $thumb_name;
        $data['email']          = htmlspecialchars($row['email']);
        $data['phone']          = htmlspecialchars($row['phone']);
        $data['city_id']        = (int) $row['city_id'];
        $data['city_name']      = htmlspecialchars($row['city_name']);
        $data['birthday']       = htmlspecialchars($row['date_of_birth']);
        $data['hfeet']          = (int)$row['height_feet'];
        $data['hinches']        = (int) $row['height_inches'];
        $data['education']      = htmlspecialchars($row['education']);
        $data['about']          = htmlspecialchars($row['about']);
        $data['religion']       = (int) $row['religion'];
        $data['gender']         = (int) $row['gender'];
        $data['gender_name']    = $row['gender_name'];
        $data['partner_gender'] = (int) $row['partner_gender'];
        $data['partner_min_age']= (int) $row['partner_min_age'];
        $data['partner_max_age']= (int) $row['partner_max_age'];
        $data['work']           = htmlspecialchars($row['work']);


        $gallery_sql = "SELECT name, sort FROM `member_gallery` WHERE member_id = '$member_id'";
        $gallery_res = $mysqli->query($gallery_sql);
        $images = [];
        $photo  = [];
        while($row = $gallery_res->fetch_assoc()){
            $image          = htmlspecialchars($row['name']);
            $sort           = (int) $row['sort'];
            $photo_path     = $base_url . 'assets/uploads/' .  $member_id . '/' . $image;
            $photo['image'] = $photo_path;
            $photo['sort']  = $sort;
            array_push($images, $photo);
        }
        $data['images']     = $images;

        $response['data']   = $data;
        $response['status'] = '200';
        
        echo json_encode($response);
    }
?>