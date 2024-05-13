<?php
    function generatePassword($password, $sha_key){
        $password = md5( md5($password) . $sha_key );
        return $password;
    }

    function checkImageExtension($file_name){
        $explode = explode('.',$file_name);
        $extension = strtolower(end($explode));
        $allow_extensions = ['jpg','jpeg','png','gif', 'webp', 'avif'];
        if(in_array($extension, $allow_extensions)){
            return true;
        }else{
            return false;
        }
    }

    function makeUniqueImageName($file_name){
        $date = date('YmdHis');
        $unique_name = $date . uniqid() . '_'. $file_name;
        return $unique_name;
    }

    function makeUniqueThumbName($file_name){
        $date = date('YmdHis');
        $unique_name = $date . '_' . uniqid() . '_thumb_'. $file_name;
        return $unique_name;
    }

    function cropAndResizeImage($src_image_path, $dest_image_path, $new_width, $new_height) {

        list($original_width, $original_height, $image_type) = getimagesize($src_image_path);

        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $original_image = imagecreatefromjpeg($src_image_path);
                break;
            case IMAGETYPE_PNG:
                $original_image = imagecreatefrompng($src_image_path);
                break;
            case IMAGETYPE_GIF:
                $original_image = imagecreatefromgif($src_image_path);
                break;
            default:
                $original_image = imagecreatefromstring(file_get_contents($src_image_path));
                break;
        }

        $original_aspect_ratio = $original_width / $original_height;
        $new_aspect_ratio = $new_width / $new_height;

        if ($original_aspect_ratio > $new_aspect_ratio) {
            $crop_height = $original_height;
            $crop_width = $original_height * $new_aspect_ratio;
        } else {
            $crop_width = $original_width;
            $crop_height = $original_width / $new_aspect_ratio;
        }
    
        // Perform cropping
        $crop_x = ($original_width - $crop_width) / 2;
        $crop_y = ($original_height - $crop_height) / 2;
    
        $cropped_image = imagecrop($original_image, ['x' => $crop_x, 'y' => $crop_y, 'width' => $crop_width, 'height' => $crop_height]);
    

        $new_image = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled(
            $new_image, // Destination image
            $cropped_image, // Source image
            0, // Destination X coordinate
            0, // Destination Y coordinate
            0, // Source X coordinate
            0, // Source Y coordinate
            $new_width, // Destination width
            $new_height, // Destination height
            $crop_width, // Source width
            $crop_height // Source height
        );

        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_image, $dest_image_path);
                break;
            case IMAGETYPE_PNG:
                imagepng($new_image, $dest_image_path);
                break;
            case IMAGETYPE_GIF:
                imagegif($new_image, $dest_image_path);
                break;
            default:
                imagejpeg($new_image, $dest_image_path);
                break;
        }

        // Free up memory
        imagedestroy($new_image);
        imagedestroy($original_image);
    }

    function getEmailConfirmCode(){
        $unique_number  = uniqid();
        $today_dt       = date("Y-m-d H:i:s");
        $email_confirm_code = md5($unique_number . $today_dt);
        return $email_confirm_code;
    }

?>