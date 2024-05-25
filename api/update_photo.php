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
        $user_id        = $_SESSION['uid'];
        $dir            = "../assets/uploads";

        if(checkImageExtension($file_name) && getimagesize($file['tmp_name'])){
            $unique_file_name = makeUniqueImageName($file_name);
            $today_dt       = date('Y-m-d H:i:s');
            $upload_dir     = $dir . '/' . $user_id . '/';

            if(!file_exists($upload_dir) || !is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }
            $destination = $upload_dir . $unique_file_name;

            if(move_uploaded_file($file['tmp_name'], $destination)) {
                $old_photo_sql  = "SELECT name FROM `member_gallery` WHERE member_id = '$user_id' AND sort = '$sort'";
                $old_photo_res  = $mysqli->query($old_photo_sql);

                if($old_photo_res->num_rows <= 0) {
                    $insert_photo_sql = "INSERT INTO `member_gallery` 
                                        (member_id, name, sort, created_at, created_by, updated_at, updated_by)
                                        VALUES ('$user_id', '$unique_file_name', '$sort', '$today_dt', '$user_id', '$today_dt', '$user_id')";


                }
                $old_photo_name = $old_photo_res->fetch_assoc()['name'];

                unlink($upload_dir . $old_photo_name);

                echo $old_photo_name;
                exit();
                // $response['status'] = '200';
            };

            // if(!$is_thumb){
            //     $thumb_upload_dir = $dir . '/' . $member_id . '/thumb/';
            //     if(!file_exists($thumb_upload_dir) || !is_dir($thumb_upload_dir)){
            //         mkdir($thumb_upload_dir, 0777, true);
            //     }
            //     $unique_thumb_name = makeUniqueThumbName($upload_name);
            //     $thumb_destination = $thumb_upload_dir . $unique_thumb_name;
            //     cropAndResizeImage($destination, $thumb_destination, $thumb_width, $thumb_height);
            //     $is_thumb = true;
            // }
        }else{
            $error_message .= 'Invalid file type at upload ' . $sort . '<br/>';
            $error_message .= 'Only jpg, jpeg, png, gif, webp images are accepted. <br/>';
            $response['error_msg'] = $error_message;
        }

        echo json_encode($response);
    }
?>