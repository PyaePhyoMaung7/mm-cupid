<?php
    session_start();

    $auth_role = [1,2];
    require('../site-config/admin_require.php');
    
    $title          = ": Create Knowledge Post";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $post_title     = '';

    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1) {
        $post_title      = $mysqli->real_escape_string($_POST['title']);

        if($city_name == '') {
            $process_error  = true;
            $error          = true;
            $error_message .= 'Please fill post title.<br/>';
        }

        $city_check_sql  = "SELECT id FROM `city` WHERE name = '$city_name'";
        $result             = $mysqli->query($city_check_sql);
        if($result->num_rows > 0 ){
            $process_error  = true;
            $error          = true;
            $error_message .= 'The city "'. $city_name .'" already exists.<br/>';
        }

        if(!$process_error){
            $today_dt       = date('Y-m-d H:i:s');
            $sql            = "INSERT INTO `city` (name, created_at, created_by, updated_at, updated_by)
                                VALUES ('$city_name','$today_dt', '$user_id', '$today_dt', '$user_id')";
            $result         = $mysqli->query($sql);

            if($result) {
                $url = $admin_base_url . 'show_city.php';
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
                <h3>Create Knowledge Post</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Post info</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="demo-form2" action="<?php $admin_base_url; ?>create_city.php" class="form-horizontal form-label-left" method="POST">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="post-title">Title<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="post-title" name="title" value="<?php echo $post_title; ?>" class="form-control" placeholder="Enter Post Title">
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