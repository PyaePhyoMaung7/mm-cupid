<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');
    
    $title          = ": Create User";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $user_name      = '';
    $role           = '';

    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $user_name      = $mysqli->real_escape_string($_POST['username']);
        $password       = $_POST['password'];
        $confirm_pass   = $_POST['confirm-password'];
        $role           = $mysqli->real_escape_string($_POST['user-role']);

        $same_username_sql  = "SELECT id, deleted_at FROM `user` WHERE username = '$user_name'";
        $result             = $mysqli->query($same_username_sql);
        if($result->num_rows > 0 ){
            if($result->fetch_assoc()['deleted_at'] == null){
                $process_error  = true;
                $error          = true;
                $error_message .= 'The username "'. $user_name .'" already exists.<br/>';
            }
        }
        if($user_name == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill username.<br/>';
        }
        if($password == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill password.<br/>';
        }
        if($confirm_pass == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill confirm password.<br/>';
        }
        if($password != $confirm_pass) {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Password and confirm password do not match.<br/>';
        }
        if($role == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please select user role.<br/>';
        }

        if(!$process_error){
            $password_enc   = generatePassword($password, $sha_key);
            $today_dt       = date('Y-m-d H:i:s');
            $sql            = "INSERT INTO `user` (username, password, role, created_at, created_by, updated_at, updated_by)
                                VALUES ('$user_name','$password_enc', '$role', '$today_dt', '$user_id', '$today_dt', '$user_id')";
            $result         = $mysqli->query($sql);

            if($result) {
                $url = $admin_base_url . 'show_user.php';
                header('Refresh: 0 ; url = '.$url);
                exit();
            }
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
                <h3>Create User Account</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>User info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>create_user.php" class="form-horizontal form-label-left" method="POST">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Username <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="username" name="username" value="<?php echo $user_name; ?>" class="form-control" placeholder="Enter User Name">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="confirm-password" class="col-form-label col-md-3 col-sm-3 label-align">Confirm Password <span class="required">*</label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input id="confirm-password" class="form-control" type="password" name="confirm-password" placeholder="Enter Confirm Password">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="user-role">Role <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 ">
                                    <select id="user-role" name="user-role" class="form-control">
                                        <option value="" >Choose User Role</option>
                                        <option value="1" <?php if($role == 1) { echo 'selected'; } ?>>Admin</option>
                                        <option value="2" <?php if($role == 2) { echo 'selected'; } ?>>Customer Service</option>
                                        <option value="3" <?php if($role == 3) { echo 'selected'; } ?>>Editor</option>
                                    </select>
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
<?php
    if($process_error){
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