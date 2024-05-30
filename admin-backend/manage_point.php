<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');
    
    $title          = ": Manage Member Point";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $member_id      = '';
    $member_name      = '';
    $existing_point   = '';
    $added_point        = '';

    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $existing_point = $mysqli->real_escape_string($_POST['existing-point']);
        $added_point      = $mysqli->real_escape_string($_POST['added-point']);
        $member_id      = $mysqli->real_escape_string($_POST['member-id']);

        if($added_point < 0){
            $process_error = true;
            $error          = true;
            $error_message .= 'New points must be greater than or equal to zero';
        }

        if(!$process_error){
            $new_point      = $existing_point + $added_point;
            $today_dt       = date('Y-m-d H:i:s');
            $sql            = "UPDATE `members` SET point = '$new_point' WHERE id = '$member_id'";
            $result         = $mysqli->query($sql);

            if($result) {
                $url = $admin_base_url . 'show_member.php';
                header('Refresh: 0 ; url = '.$url);
                exit();
            }
        }
    }else{
        if(isset($_GET['id'])){
            $member_id = $_GET['id'];
            $member_sql     = "SELECT username, point FROM `members` WHERE id = '$member_id'";
            $result = $mysqli->query($member_sql);
            if($result->num_rows <= 0){
                $process_error = true;
                $error = true;
                $error_message .= "The member accont cannot be found.";
            }else{
                $row = $result->fetch_assoc();
                $member_name = $row['username'];
                $existing_point = $row['point'];
            }
        }else{
            $process_error = true;
            $error = true;
            $error_message .= "The member accont cannot be found.";
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
                <h3>Manage member point</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="<?php echo $admin_base_url . 'show_member.php' ; ?>"><button class="btn btn-dark">Back</button></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>manage_point.php" class="form-horizontal form-label-left" method="POST">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="member-name">Username <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="member-name" readonly name="member-name" value="<?php echo $member_name; ?>" class="form-control" placeholder="Enter User Name">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="existing-point">Existing Point <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="number" id="existing-point" name="existing-point" readonly value="<?php echo $existing_point; ?>" class="form-control" placeholder="Enter Points">
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="added-point">Add Point <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="number" id="added-point" name="added-point" value="<?php echo $added_point; ?>" class="form-control" placeholder="Enter Points">
                                </div>
                            </div>

                            <input type="hidden" name="member-id" value="<?php echo $member_id; ?>">
                        
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