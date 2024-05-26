<?php
    session_start();

    $auth_role = [1, 2];
    require('../site-config/admin_require.php');

    $title              = ": Edit Knowledge Post";
    $process_error      = false;
    $error              = false;
    $error_message      = '';
    $id                 = '';
    $post_title         = '';
    $post_description   = '';
    $post_image         = '';
    $post_image_path    = '';
    $dir                = '../assets/post_images/';

    if (isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $post_id            = $_POST['id'];
        $post_title         = $mysqli->real_escape_string($_POST['post-title']);
        $post_description   = $mysqli->real_escape_string($_POST['post-description']);
        $post_image_path    = $_POST['post-image-path'];
    
        if ($post_title == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill post title.<br/>';
        }
    
        if ($post_description == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill post description.<br/>';
        }
    
        if (!$process_error) {
            $today_dt   = date('Y-m-d H:i:s');
            if($_FILES['post-image']['name'] !== ''){
                $old_data_sql   = "SELECT thumbnail, image FROM `knowledge` WHERE id = '$post_id'";
                $old_data_res   = $mysqli->query($old_data_sql);
                $old_data       = $old_data_res->fetch_assoc();
                $old_thumb      = $old_data['thumbnail'];
                $old_image      = $old_data['image'];

                $file = $_FILES['post-image'];
                $file_name = $file['name'];
                if (checkImageExtension($file_name)) {
                    // new photo save
                    $unique_file_name = makeUniqueImageName($file_name);
                    $upload_dir = $dir . $post_id . '/';
                    if (!file_exists($upload_dir) || !is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $destination = $upload_dir . $unique_file_name;
                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        //old photo delete
                        unlink($upload_dir . $old_image);
                        
                        // new thumb photo save
                        $thumb_upload_dir = $dir . $post_id . '/thumb/';
                        if (!file_exists($thumb_upload_dir) || !is_dir($thumb_upload_dir)) {
                            mkdir($thumb_upload_dir, 0777, true);
                        }
                        $unique_thumb_name = makeUniqueThumbName($file_name);
                        $thumb_destination = $thumb_upload_dir . $unique_thumb_name;
                        cropAndResizeImage($destination, $thumb_destination, $post_thumb_width, $post_thumb_height);
                        
                        //old thumb photo delete
                        unlink($thumb_upload_dir . $old_thumb);

                        $update_sql = "UPDATE `knowledge`
                                        SET title   = '$post_title',
                                        description = '$post_description',
                                        thumbnail = '$unique_thumb_name', 
                                        image = '$unique_file_name',
                                        updated_at = '$today_dt', 
                                        updated_by = '$user_id'
                                        WHERE id = '$post_id'";
                    };
                } else {
                    $error = true;
                    $error_message .= 'Your uploaded file type is not accepted!<br>';
                }   
            } else {
                $update_sql = "UPDATE `knowledge`
                                SET title   = '$post_title',
                                description = '$post_description',
                                updated_at = '$today_dt', 
                                updated_by = '$user_id'
                                WHERE id = '$post_id'";
            }

            $result = $mysqli->query($update_sql);
        
            if ($result) {
                $url = $admin_base_url . 'show_post.php';
                header('Refresh: 0 ; url = '.$url);
                exit();
            }
        }
    } else {
        $id         = htmlspecialchars($_GET['id']);
        $post_sql   = "SELECT id, title, description, thumbnail, image
                    FROM `knowledge`
                    WHERE id = '$id' AND deleted_at IS NULL";
        $result     = $mysqli->query($post_sql);
        $res_row    = $result->num_rows;
        if($res_row > 0) {
            $form_show          = true;
            $row                = $result->fetch_assoc();
            $id                 = $row['id'];
            $post_title         = htmlspecialchars($row['title']);
            $post_description   = htmlspecialchars($row['description']);
            $post_image         = htmlspecialchars($row['image']);
            $post_image_path    = $base_url . 'assets/post_images/' . $id . '/' . $post_image;
        }else{
            $form_show          = false;
            $error          = true;
            $process_error  = true;
            $error_message  = 'The post cannot be found.';
        }
    }

    require('../templates/cp_template_header.php');
    require('../templates/cp_template_sidebar.php');
    require('../templates/cp_template_top_nav.php');
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Manage Setting</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Setting info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <?php if($form_show) {
                        ?>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>edit_post.php" class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="post-title">Post title <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="post-title" name="post-title" value="<?php echo $post_title; ?>" class="form-control" placeholder="Enter Post Title">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="post-description">Post description <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <textarea name="post-description" id="post-description" class="form-control" placeholder="Enter Post Description" rows="12"><?php echo $post_description; ?></textarea>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Post image <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <div id="preview-image" class="overflow-hidden" style="border:1px dashed grey; border-radius: 10px; width: 300px; height: 300px;">
                                        <img src="<?php echo $post_image_path; ?>" class="w-100 h-100" style="object-fit: cover" alt="Image Preview" onclick="browseImage()"/>
                                    </div>
                                    <input class="d-none" type="file" id="post-image" name="post-image" onchange="previewImage()" value="<?php echo $company_logo; ?>" class="form-control" placeholder="Enter company logo">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <input type="hidden" name="form-sub" value="1">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="post-image-path" value="<?php echo $post_image_path;; ?>">
                                </div>
                            </div>
                        </form>
                        <?php } else {
                        ?>
                        <a href="<?php echo $admin_base_url; ?>show_post.php?id=<?php echo $id; ?>"><button class="btn btn-primary" type="reset">Back</button></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /page content -->
<?php
    require('../templates/cp_template_footer.php');
?>
<!-- Custom javascript code goes here -->
    <script>
        function browseImage(){
            $('#post-image').click();
        }

        function previewImage(){
            const fileInput = document.getElementById('post-image');
            const preview = document.getElementById('preview-image');

            let fileName = fileInput.value.split('\\').pop();
            let fileExtension = fileName.split('.').pop();
            let allow_extensions = ['jpg','jpeg','png','giff','webp', 'avif'];

            let file = event.target.files[0];

            if(allow_extensions.includes(fileExtension)){
                if(file){
                    let reader = new FileReader();
                    reader.onload = function(event) {
                    let imgSrc = event.target.result;
                    preview.innerHTML = `<img src= ${imgSrc} class="w-100 h-100" style="object-fit: cover" alt="Image Preview" onclick="browseImage()"/>`;
                    };
                    reader.readAsDataURL(file);
                    preview.style.display = "";
                }
            }else{
                $('#post-image').val('');
                preview.style.display = "";
                preview.style.width = '300px';
                preview.innerHTML = `
                <h4 class="bg-danger text-white text-center pt-2 mb-0">Your uploaded file type is not accepted!</h4>
                <label id="choose-file-label" onclick="browseImage()" style="margin-top: 30%; margin-left:30%; cursor: pointer; font-size: 20px;">Choose file</label>`;
            };
        }
    </script>
<?php
    if($process_error || $error){
?>
    <script>
        new PNotify({
            title: 'Oh No!',
            text: '<?php echo $error_message; ?>',
            type: 'error',
            styling: 'bootstrap3'
        });
    </script>
<?php
    }
?>
<?php
    require('../templates/cp_template_html_end.php');
?>