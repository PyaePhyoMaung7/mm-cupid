<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');
    
    $title          = ": Edit User";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $form_show      = false;
    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $id        = $_POST['id'];
        $user_name      = $mysqli->real_escape_string($_POST['username']);
        $role           = $mysqli->real_escape_string($_POST['user-role']);

        $same_username_sql  = "SELECT id, deleted_at FROM `user` WHERE username = '$user_name' AND id != '$id'";
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

        if($role == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please select user role.<br/>';
        }

        if(!$process_error){
            $today_dt   = date('Y-m-d H:i:s');
            $sql        = "UPDATE `user` SET username = '$user_name', role= '$role', updated_at = '$today_dt', updated_by = '$user_id' WHERE id = '$id'";
            $result     = $mysqli->query($sql);

            if($result) {
                $url = $admin_base_url . 'show_user.php';
                header('Refresh: 0 ; url = '.$url);
                exit();
            }
        }
    } else {
        $id             = (int) $_GET['id'];
        $id             = $mysqli->real_escape_string($id);
        $edit_sql       = "SELECT id, username, role FROM `user` WHERE id = '$id' AND deleted_at IS NULL";
        $result         = $mysqli->query($edit_sql);
        $res_row        = $result->num_rows;
        if($res_row >= 1) {
            $form_show  = true;
            $user_data  = $result->fetch_assoc();
            $user_name  = htmlspecialchars($user_data['username']);
            $role       = htmlspecialchars($user_data['role']);
        }else{
            $form_show  = false;
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
                <h3>Edit User Account</h3>
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
                        <?php if($form_show) {
                        ?>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>edit_user.php" class="form-horizontal form-label-left" method="POST">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Username <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="username" name="username" value="<?php echo $user_name; ?>" class="form-control" placeholder="Enter User Name">
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
                                    <a href="<?php echo $admin_base_url; ?>show_user.php"><button class="btn btn-primary">Back</button></a>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <input type="hidden" name="form-sub" value="1">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                            </div>
                        </form>
                        <?php
                        } else {
                        ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?php echo $admin_base_url; ?>show_user.php"><button class="btn btn-primary" type="reset">Back</button></a>
                            <div class="alert alert-success alert-dismissible w-50 text-center" style="margin: 0 auto;" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Sorry!</strong> The user account is deleted or not found.
                            </div>
                        </div>
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