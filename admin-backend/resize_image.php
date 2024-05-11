<?php
    $auth_role = [1];
    require('../site-config/admin_require.php');
    
    $uploadDir = '../assets/images/';

if(isset($_POST['form-sub']) && $_POST['form-sub'] == '1'){
    
    $file = $_FILES['logo'];
    if($file){
        $file_name = $file['name'];
        $unique_file_name = makeUniqueImageName($file_name);
        $destination = $uploadDir . $unique_file_name;
        resizeAndSaveImage($file['tmp_name'], $destination, 0.1);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $admin_base_url; ?>resize_image.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="logo" id="">
        <input type="hidden" name="form-sub" value="1">
        <input type="submit">
    </form>
</body>
</html>