<?php
    session_start();

    $auth_role = [1];
    require('../site-config/admin_require.php');
    
    $title          = ": Edit Hobby";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $form_show      = false;
    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $id        = $_POST['id'];
        $hobby_name      = $mysqli->real_escape_string($_POST['hobby-name']);

        $same_hobby_sql  = "SELECT id, deleted_at FROM `hobbies` WHERE name = '$hobby_name' AND id != '$id'";
        $result             = $mysqli->query($same_hobby_sql);
        if($result->num_rows > 0 ){
            if($result->fetch_assoc()['deleted_at'] == null){
                $process_error  = true;
                $error          = true;
                $error_message .= 'The hobby "'. $hobby_name .'" already exists.<br/>';
            }
        }
        if($hobby_name == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill hobby name.<br/>';
        }

        if(!$process_error){
            $today_dt   = date('Y-m-d H:i:s');
            $sql        = "UPDATE `hobbies` SET name = '$hobby_name', updated_at = '$today_dt', updated_by = '$user_id' WHERE id = '$id'";
            $result     = $mysqli->query($sql);

            if($result) {
                $url = $admin_base_url . 'show_hobby.php';
                header('Refresh: 0 ; url = '.$url);
                exit();
            }
        }
    } else {
        $id             = (int) $_GET['id'];
        $id             = $mysqli->real_escape_string($id);
        $edit_sql       = "SELECT id, name FROM `hobbies` WHERE id = '$id' AND deleted_at IS NULL";
        $result         = $mysqli->query($edit_sql);
        $res_row        = $result->num_rows;
        if($res_row >= 1) {
            $form_show  = true;
            $hobby_data  = $result->fetch_assoc();
            $hobby_name  = htmlspecialchars($hobby_data['name']);
        }else{
            $form_show      = false;
            $error          = true;
            $process_error  = true;
            $error_message  = 'The hobby does not exist.';
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
                <h3>Edit Hobby</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Hobby info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <?php if($form_show) {
                        ?>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>edit_hobby.php" class="form-horizontal form-label-left" method="POST">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="hobby-name">Hobby name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="hobby-name" name="hobby-name" value="<?php echo $hobby_name; ?>" class="form-control" placeholder="Enter User Name">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <a href="<?php echo $admin_base_url; ?>show_hobby.php"><button class="btn btn-primary">Back</button></a>
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
                        <a href="<?php echo $admin_base_url; ?>edit_hobby.php?id=<?php echo $id; ?>"><button class="btn btn-primary" type="reset">Back</button></a>
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