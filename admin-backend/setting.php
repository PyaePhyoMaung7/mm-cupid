<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');

    $title          = ": Setting";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $point          = '';
    $company_name   = '';
    $company_logo   = '';
    $company_email  = '';
    $company_phone  = '';
    $company_address= '';
    $setting_exists = false;
    $old_logo = '';

    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $point              = $mysqli->real_escape_string($_POST['point']);
        $company_name       = $mysqli->real_escape_string($_POST['company-name']);
        $company_email      = $mysqli->real_escape_string($_POST['company-email']);
        $company_phone      = $mysqli->real_escape_string($_POST['company-phone']);
        $company_address    = $mysqli->real_escape_string($_POST['company-address']);

        $setting_exist_sql     = "SELECT id, company_logo FROM `setting`";
        $setting_exist_result  = $mysqli->query($setting_exist_sql);
        
        if($setting_exist_result->num_rows > 0){
            $setting_exists = true;
            $old_logo       = $setting_exist_result->fetch_assoc()['company_logo'];
        }
        if($point == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill point.<br/>';
        }

        if($company_name == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill company name.<br/>';
        }

        if($company_email == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill company email.<br/>';
        }else if(!filter_var($company_email, FILTER_VALIDATE_EMAIL)){
            $process_error  = true;
            $error          = true;
            $error_message .= 'The company email is not valid.<br/>';
        }

        if($company_phone == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill company phone.<br/>';
        }else if(!preg_match('/^(\+)?(\(?\d+\)?)(([\s-]+)?(\d+)){0,}$/', $company_phone)){
            $process_error  = true;
            $error          = true;
            $error_message .= 'The company phone number is invalid.<br/>';
        }

        if($company_address == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill company address.<br/>';
        }

        if($_FILES['company-logo']['name'] == "" && !$setting_exists){
            $process_error = true;
            $error = true;
            $error_message .= "Please upload a company logo.</br>";
        }

        if(!$process_error){
            if($_FILES['company-logo']['name'] == ""){
                $unique_file_name = $old_logo;
            }else{
                $file = $_FILES['company-logo'];
                $file_name = $file['name'];
                if(checkImageExtension($file_name)){
                    $unique_file_name = makeUniqueImageName($file_name);
                    $uploadDir = '../assets/images/';
                    if(!file_exists($uploadDir) || !is_dir($uploadDir)){
                        mkdir($uploadDir, 0777, true);
                    }
                    $destination = $uploadDir . $unique_file_name;
                    unlink($uploadDir . $old_logo);
                    cropAndResizeImage($file['tmp_name'], $destination, 50, 50);
                }else{
                    $error = true;
                    $error_message .= 'Your uploaded file type is not accepted!<br>';
                }
            }
            if(!$error){
                $today_dt = date('Y-m-d H:i:s');
                if($setting_exists){
                    $sql = "UPDATE `setting` SET  point = '$point', company_name = '$company_name', 
                            company_email = '$company_email', company_phone = '$company_phone', company_address = '$company_address', company_logo = '$unique_file_name', 
                            updated_at = '$today_dt', updated_by = '$user_id' ";
                }else{
                    $sql = "INSERT INTO `setting` 
                            (point, company_name, company_logo, company_email, company_phone, company_address, created_at, created_by, updated_at, updated_by)
                            VALUES ('$point', '$company_name', '$unique_file_name', '$company_email', '$company_phone', '$company_address', '$today_dt', '$user_id', '$today_dt', '$user_id')";
                }
                $result = $mysqli->query($sql);
                if($result){
                    $url= $admin_base_url.'index.php';
                    header('Refresh:0; url='.$url);
                    exit();                                      
                }
            }

        }
    } else {
        $setting_sql    = "SELECT id, point, company_name, company_logo, company_email, company_phone, company_address FROM `setting`";
        $result         = $mysqli->query($setting_sql);
        $res_row        = $result->num_rows;
        if($res_row > 0) {
            $setting_exists = true;
            $res = $result->fetch_assoc();
            $point = $res['point'];
            $company_name = $res['company_name'];
            $old_logo = $res['company_logo'];
            $company_email = $res['company_email'];
            $company_phone = $res['company_phone'];
            $company_address = $res['company_address'];
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

                        <form id="demo-form2" action="<?php $admin_base_url; ?>setting.php" class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="point">Point <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="number" id="point" name="point" value="<?php echo $point; ?>" class="form-control" placeholder="Enter points">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="company-name">Company name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="company-name" name="company-name" value="<?php echo $company_name; ?>" class="form-control" placeholder="Enter company name">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="company-email">Company email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="company-email" name="company-email" value="<?php echo $company_email; ?>" class="form-control" placeholder="Enter company email">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="company-phone">Company phone <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="company-phone" name="company-phone" value="<?php echo $company_phone; ?>" class="form-control" placeholder="Enter company phone">
                                </div>
                            </div>

                            
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="company-address">Company address <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="company-address" name="company-address" value="<?php echo $company_address; ?>" class="form-control" placeholder="Enter company address">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Company logo <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <div id="preview-image" class="overflow-hidden" style="border:1px dashed grey; border-radius: 10px; width: 300px; height: 300px;">
                                        <?php 
                                        if($setting_exists){
                                        ?>
                                            <img src="<?php echo $base_url.'assets/images/'.$old_logo ?>" class="w-100 h-100" style="object-fit: cover" alt="Image Preview" onclick="browseImage()"/>
                                        <?php 
                                        } else {
                                        ?>
                                        <label id="choose-file-label" onclick="browseImage()" style="margin-top: 30%; margin-bottom: 30%; margin-left:35%; cursor: pointer; font-size: 20px;">Choose file</label>
                                        <?php 
                                        }
                                        ?>
                                    </div>
                                    <input class="d-none" type="file" id="company-logo" name="company-logo" onchange="previewImage()" value="<?php echo $company_logo; ?>" class="form-control" placeholder="Enter company logo">
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <input type="hidden" name="form-sub" value="1">
                                </div>
                            </div>
                        </form>
   
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
            $('#company-logo').click();
        }

        function previewImage(){
            const fileInput = document.getElementById('company-logo');
            const preview = document.getElementById('preview-image');

            let fileName = fileInput.value.split('\\').pop();
            let fileExtension = fileName.split('.').pop();
            let allow_extensions = ['jpg','jpeg','png','giff','webp'];

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
                    $('#choose-file-label').hide();
                }
            }else{
                preview.style.display = "";
                preview.style.width = '300px';
                preview.innerHTML = `
                <h4 class="bg-danger text-white text-center py-2">Your uploaded file type is not accepted!</h4>
                <label id="choose-file-label" onclick="browseImage()" style="margin-top: 30%; margin-left:30%; cursor: pointer; font-size: 20px;">Choose file</label>
                `;
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