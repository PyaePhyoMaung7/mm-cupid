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
        $record_per_page= 9;
        $offset         = ($pageNo - 1) * $record_per_page;
        $member_id      = $_SESSION['uid'];
        $total_show_data= $pageNo * $record_per_page;
        $where_gender   = '';
        $where_min_age   = '';
        $where_max_age   = '';
        $filter_conditions = '';

        if(array_key_exists('partner_gender', $decoded_data)) {
            $partner_gender =  $decoded_data['partner_gender'];

            if($partner_gender != 2) {
                $where_gender = "T01.gender = '$partner_gender' AND";
            }
        }else{
            $partner_gender= $_SESSION['partner_gender'];

            if($partner_gender != 2) {
                $where_gender = "T01.gender = '$partner_gender' AND";
            }
        }

        if(array_key_exists('min_age', $decoded_data) && $decoded_data['min_age'] != ''){
            $partner_min_age=  $decoded_data['min_age'];
            $where_min_age = " T01.date_of_birth <= CURDATE() - INTERVAL '$partner_min_age' YEAR AND";
        }

        if(array_key_exists('max_age', $decoded_data) && $decoded_data['max_age'] != ''){
            $partner_max_age=  $decoded_data['max_age'];
            $where_max_age = " T01.date_of_birth >= CURDATE() - INTERVAL '$partner_max_age' YEAR AND";
        }

        $filter_conditions = $where_gender . $where_min_age . $where_max_age;

        $get_members_sql = "SELECT T01.*, TIMESTAMPDIFF(YEAR, T01.date_of_birth, CURDATE()) AS age, 
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
                            WHERE T01.id != '$member_id' AND T01.status != 0 AND T01.status != 5 AND T01.love_status != 1 AND " . $filter_conditions . " T01.deleted_at IS NULL LIMIT $offset, $record_per_page";
        
        $result = $mysqli->query($get_members_sql);

        $data = [];
        $response_data = [];
        while($row = $result->fetch_assoc()){
            $id = (int) $row['id'];
            $data['id'] = $id;
            $data['username'] = htmlspecialchars($row['username']);
            $data['age'] = (int) $row['age'];
            $data['gender'] = htmlspecialchars($row['gender_name']);
            $data['city'] = htmlspecialchars($row['city_name']);
            $data['religion'] = htmlspecialchars($row['religion_name']);
            $data['about'] = htmlspecialchars($row['about']);
            $data['status'] = htmlspecialchars($row['status']);
            $data['height'] = $row['height_feet'] . "' " . $row['height_inches'] . "''";
            $data['education'] = htmlspecialchars($row['education']);
            $data['work'] = htmlspecialchars($row['work']);

            $thumb = htmlspecialchars($row['thumbnail']);
            if($thumb == ''){
                $data['thumb'] = $base_url . 'assets/default_images/no_image.png';
            }else{
                $data['thumb'] = $base_url . 'assets/uploads/' .  $data['id'] . '/thumb/' . $thumb;
            }

            $hobbies    = [];
            $hobby_sql  = "SELECT T01.hobby_id, T02.name 
                            FROM `member_hobbies` T01
                            JOIN `hobbies` T02
                            ON T01.hobby_id = T02.id
                            WHERE T01.member_id = '$id'";
            $hobby_res  = $mysqli->query($hobby_sql);
            while($hobby_row = $hobby_res->fetch_assoc()){
                array_push($hobbies, $hobby_row['hobby_id']);
            }
            $data['hobbies']    = $hobbies;
            
            $gallery_sql = "SELECT name, sort FROM `member_gallery` WHERE member_id = '$id' AND deleted_at IS NULL ORDER BY sort ASC";
            $gallery_res = $mysqli->query($gallery_sql);
            $images = [];
            $photo  = [];
            while($row2 = $gallery_res->fetch_assoc()){
                $image          = htmlspecialchars($row2['name']);
                $sort           = htmlspecialchars($row2['sort']);
                $photo_path     = $base_url . 'assets/uploads/' .  $id . '/' . $image;
                $photo['image'] = $photo_path;
                $photo['sort']  = $sort;
                array_push($images, $photo);
            }
            $data['images'] = $images;
            array_push($response_data, $data);
        }

        $more_members_sql = "SELECT count(T01.id) AS total FROM `members` T01 WHERE T01.id != '$member_id' AND T01.status != 0 AND T01.status != 5 AND T01.love_status != 1 AND " . $filter_conditions . " T01.deleted_at IS NULL";
        $more_memebrs_res = $mysqli->query($more_members_sql);
        $row2 = $more_memebrs_res->fetch_assoc();
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