<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');
    
    $title          = ": Change User Password";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $form_show      = false;

    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $id             = $_POST['id'];
        $new_pass       = $_POST['new-password'];
        $confirm_pass   = $_POST['confirm-password'];

        if($new_pass == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill new password.<br/>';
        }
        if($confirm_pass == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill confirm password.<br/>';
        }
        if($new_pass != $confirm_pass) {
            $process_error  = true;
            $error          = true;
            $error_message .= 'New password and confirm password do not match.<br/>';
        }

        if(!$process_error){
            $password_enc   = generatePassword($new_pass, $sha_key);
            $today_dt       = date('Y-m-d H:i:s');
            $sql            = "UPDATE `user` SET password = '$password_enc' WHERE id = '$id'";
            $result         = $mysqli->query($sql);
            if($result) {
                $url = $admin_base_url . 'show_user.php';
                header('Refresh: 0 ; url = '.$url);
                exit();
            }
        }
    } else {
        $id = (int) $_GET['id'];
        $id = htmlspecialchars($id);
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
                <h3>Change Password</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Password info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>change_user_password.php" class="form-horizontal form-label-left" method="POST">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="new-password">New Password <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="password" id="new-password" name="new-password" class="form-control" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="confirm-password" class="col-form-label col-md-3 col-sm-3 label-align">Confirm Password <span class="required">*</label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input id="confirm-password" class="form-control" type="password" name="confirm-password" placeholder="Enter Confirm Password">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <input type="hidden" name="form-sub" value="1">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
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