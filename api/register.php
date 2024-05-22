<?php
    require('../site-config/connect.php');
    require('../site-config/config.php');
    require('../site-config/include_functions.php');

    $response = [];
    $response['status'] = '500';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $request_data = file_get_contents('php://input');
        $data = json_decode($request_data,true);
        
        $username = $mysqli->real_escape_string($data['username']);
        $email = $mysqli->real_escape_string($data['email']);
        $password = $data['password'];
        $phone = $mysqli->real_escape_string($data['phone']);
        $birthday = $mysqli->real_escape_string($data['birthday']);
        $city = $mysqli->real_escape_string($data['city']);
        $hfeet = $mysqli->real_escape_string($data['hfeet']);
        $hinches = $mysqli->real_escape_string($data['hinches']);
        $education = $mysqli->real_escape_string($data['education']);
        $about = $mysqli->real_escape_string($data['about']);
        $gender = $mysqli->real_escape_string($data['gender']);
        $hobbies = $data['hobbies'];
        $partner_gender = $mysqli->real_escape_string($data['partner_gender']);
        $min_age = $mysqli->real_escape_string($data['min_age']);
        $max_age = $mysqli->real_escape_string($data['max_age']);
        $religion = $mysqli->real_escape_string($data['religion']);
        $work = $mysqli->real_escape_string($data['work']);
        $hashed_password = generatePassword($password, $sha_key);
        
        $today_dt = date('Y-m-d H:i:s');
        $point_sql = "SELECT * FROM `setting`";
        $point_result = $mysqli->query($point_sql);
        $point_row = $point_result->num_rows;
        if($point_row <= 0){
            $point = 0;
        }else{
            $row = $point_result->fetch_assoc();
            $point = $row['point'];
        }

        $email_confirm_code = getEmailConfirmCode();
        $register_sql = "INSERT INTO `members`
                        (username, password, email, phone, email_confirm_code, gender, date_of_birth, education, city_id, height_feet, height_inches, status, about,
                        partner_gender, partner_min_age, partner_max_age, last_login, point, work, religion, created_at, updated_at, updated_by)
                        VALUES
                        ('$username', '$hashed_password', '$email', '$phone', '$email_confirm_code',  '$gender', '$birthday', '$education', '$city', '$hfeet', '$hinches', '0', '$about',
                        '$partner_gender','$min_age','$max_age','$today_dt','$point', '$work', '$religion', '$today_dt', '$today_dt', '1');
                        ";
        $result = $mysqli->query($register_sql);

        if($result){
            $insert_id = $mysqli->insert_id;
            foreach ($hobbies as $hobby) {
                $hobby_sql = "INSERT INTO `member_hobbies`
                            (member_id, hobby_id, created_at, created_by, updated_at, updated_by)
                            VALUES
                            ('$insert_id', '$hobby', '$today_dt', '$insert_id', '$today_dt', '$insert_id')";
                
                $mysqli->query($hobby_sql);
            }

            $response['status'] = '200';
            $response['member_id'] = $insert_id;
            $response['email_confirm_code'] = $email_confirm_code;
            echo json_encode($response);
        }
    }
?>