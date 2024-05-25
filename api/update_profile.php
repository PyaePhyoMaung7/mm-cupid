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
        $data = json_decode($request_data,true);
        
        $user_id        = $_SESSION['uid'];
        $username       = $mysqli->real_escape_string($data['username']);
        $phone          = $mysqli->real_escape_string($data['phone']);
        $birthday       = $mysqli->real_escape_string($data['birthday']);
        $city           = $mysqli->real_escape_string($data['city_id']);
        $hfeet          = $mysqli->real_escape_string((int) $data['hfeet']);
        $hinches        = $mysqli->real_escape_string((int) $data['hinches']);
        $education      = $mysqli->real_escape_string($data['education']);
        $about          = $mysqli->real_escape_string($data['about']);
        $gender         = $mysqli->real_escape_string((int)$data['gender']);
        $hobbies        = $data['hobbies'];
        $partner_gender = $mysqli->real_escape_string((int) $data['partner_gender']);
        $min_age        = $mysqli->real_escape_string((int) $data['partner_min_age']);
        $max_age        = $mysqli->real_escape_string((int) $data['partner_max_age']);
        $religion       = $mysqli->real_escape_string((int) $data['religion']);
        $work           = $mysqli->real_escape_string($data['work']);
        
        $today_dt       = date('Y-m-d H:i:s');

        $update_sql     ="UPDATE `members` SET username = '$username', phone = '$phone', gender = '$gender', date_of_birth = '$birthday', 
                        education = '$education', city_id = '$city', height_feet='$hfeet', height_inches='$hinches', about='$about', 
                        partner_gender='$partner_gender', partner_min_age = '$min_age', partner_max_age = '$max_age', work = '$work', 
                        religion = '$religion', updated_at = '$today_dt', updated_by = '$user_id'
                        WHERE id = '$user_id'";

        $result = $mysqli->query($update_sql);

        if($result){
            $hobby_delete_sql = "DELETE FROM `member_hobbies` WHERE member_id = '$user_id'";
            $mysqli->query($hobby_delete_sql);

            foreach ($hobbies as $hobby) {
                $hobby_sql = "INSERT INTO `member_hobbies`
                            (member_id, hobby_id, created_at, created_by, updated_at, updated_by)
                            VALUES
                            ('$user_id', '$hobby', '$today_dt', '$user_id', '$today_dt', '$user_id')";
                
                $mysqli->query($hobby_sql);
            }

            $response['status'] = '200';
            echo json_encode($response);
        }
    }
?>