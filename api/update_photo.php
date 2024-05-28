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
        $file   = $_FILES['file'];
        $file_name    = $file['name'];
        $sort   = $_POST['sort']; 
        $member_id        = $_SESSION['uid'];
        $dir            = "../assets/uploads";

        if(checkImageExtension($file_name) && getimagesize($file['tmp_name'])){
            $unique_file_name = makeUniqueImageName($file_name);
            $today_dt       = date('Y-m-d H:i:s');
            $upload_dir     = $dir . '/' . $member_id . '/';

            if(!file_exists($upload_dir) || !is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            $destination = $upload_dir . $unique_file_name;

            if(move_uploaded_file($file['tmp_name'], $destination)) {

                $old_photo_sql  = "SELECT T01.name, T02.thumbnail 
                                    FROM `member_gallery` AS T01
                                    JOIN `members` AS T02
                                    ON T01.member_id = T02.id
                                    WHERE T01.member_id = '$member_id' 
                                    AND sort = '$sort' 
                                    AND T01.deleted_at IS NULL";

                $old_photo_res  = $mysqli->query($old_photo_sql);

                if($old_photo_res->num_rows <= 0) {
                    $new_photo_sql = "INSERT INTO `member_gallery` 
                                        (member_id, name, sort, created_at, created_by, updated_at, updated_by)
                                        VALUES ('$member_id', '$unique_file_name', '$sort', '$today_dt', '$member_id', '$today_dt', '$member_id')";
                } else {
                    $old_photo = $old_photo_res->fetch_assoc();
                    $old_photo_name = $old_photo['name'];
                    $old_photo_path = $upload_dir . $old_photo_name;
                    if(file_exists($old_photo_path)){
                        unlink($old_photo_path);
                    }

                    if($sort == 1){
                        $thumb_upload_dir = $dir . '/' . $member_id . '/thumb/';
                        if(!file_exists($thumb_upload_dir) || !is_dir($thumb_upload_dir)){
                            mkdir($thumb_upload_dir, 0777, true);
                        }
                        $unique_thumb_name = makeUniqueThumbName($file_name);
                        $thumb_destination = $thumb_upload_dir . $unique_thumb_name;
                        cropAndResizeImage($destination, $thumb_destination, $thumb_width, $thumb_height);
                        
                        $old_thumb_name = $old_photo['thumbnail'];
                        $old_thumb_path = $thumb_upload_dir . $old_thumb_name;

                        if(file_exists($old_thumb_path)) {
                            unlink($old_thumb_path);
                        }

                        $new_thumb_sql  = "UPDATE `members` 
                                            SET thumbnail   = '$unique_thumb_name',
                                            updated_at      = '$today_dt',
                                            updated_by      = '$member_id'
                                            WHERE id        = '$member_id'";
                        $mysqli->query($new_thumb_sql);
                    }

                    $new_photo_sql = "UPDATE `member_gallery` 
                                        SET name        = '$unique_file_name', 
                                        updated_at      = '$today_dt',
                                        updated_by      = '$member_id' 
                                        WHERE member_id = '$member_id' AND sort = '$sort'";
                }

                $mysqli->query($new_photo_sql);

                $response['status'] = '200';
            };

        }else{
            $error_message .= 'Invalid file type at upload ' . $sort . '<br/>';
            $error_message .= 'Only jpg, jpeg, png, gif, webp images are accepted. <br/>';
            $response['error_msg'] = $error_message;
        }

        echo json_encode($response);
    }
?>