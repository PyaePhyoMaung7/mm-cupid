<?php
    session_start();

    $auth_role = [1, 2];
    require('../site-config/admin_require.php');
    
    $title          = ": Member Details";
    $process_error  = false;
    $error          = false;
    $error_message  = '';
    $form_show      = false;
    $member_data    = '';
    $hobbies        = '';
    $member_gallery = [];
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
        $member_sql       =  "SELECT members.id AS id, username, email, phone,
                            CASE 
                                WHEN gender = 0 THEN 'male'
                                ELSE 'female'
                            END AS gender, date_of_birth, education, about, city.name as city_name, height_feet, height_inches,
                            CASE 
                                WHEN partner_gender = 0 THEN 'male'
                                ELSE 'female'
                            END AS partner_gender, partner_min_age, partner_max_age, status, last_login, point, work,
                            CASE 
                                WHEN religion = 1 THEN 'Buddhism'
                                WHEN religion = 2 THEN 'Shinto'
                                WHEN religion = 3 THEN 'Christianity'
                                WHEN religion = 4 THEN 'Muslim'
                                WHEN religion = 5 THEN 'Hinduism'
                                WHEN religion = 6 THEN 'Atheism'
                                ELSE 'Others'
                            END AS religion, view_count
                            FROM `members`
                            JOIN `city` 
                            ON members.city_id = city.id
                            WHERE members.id = '$id'";
        $member_res         = $mysqli->query($member_sql);

        $hobby_sql      =  "SELECT hobbies.id, hobbies.name FROM (SELECT hobby_id FROM `member_hobbies` WHERE member_id = '$id') AS member_hobby
                            JOIN `hobbies` ON member_hobby.hobby_id = hobbies.id";
        $hobby_res      = $mysqli->query($hobby_sql);

        while($row = $hobby_res->fetch_assoc()){
           $hobbies .= $row['name'] . ', ';
        }

        $hobbies = rtrim($hobbies, ', ');

        $gallery_sql    = "SELECT id, name FROM `member_gallery` WHERE member_id = '$id'";
        $gallery_res    = $mysqli->query($gallery_sql);

        while($row = $gallery_res->fetch_assoc()){
            array_push($member_gallery, $row['name']);
        }

        $res_row        = $member_res->num_rows;
        if($res_row >= 1) {
            $form_show      = true;
            $member_data    = $member_res->fetch_assoc();
            $member_name    = htmlspecialchars($member_data['username']);
            $email          = htmlspecialchars($member_data['email']);
            $phone          = htmlspecialchars($member_data['phone']);
            $gender         = htmlspecialchars($member_data['gender']);
            $date_of_birth  = htmlspecialchars($member_data['date_of_birth']);
            $education      = htmlspecialchars($member_data['education']);
            $about      = htmlspecialchars($member_data['about']);
            $city_name      = htmlspecialchars($member_data['city_name']);
            $height_feet    = htmlspecialchars($member_data['height_feet']);
            $height_inches  = htmlspecialchars($member_data['height_inches']);
            $partner_gender = htmlspecialchars($member_data['partner_gender']);
            $partner_min_age= htmlspecialchars($member_data['partner_min_age']);
            $parter_max_age = htmlspecialchars($member_data['partner_max_age']);
            $status         = htmlspecialchars($member_data['status']);
            $last_log_in    = htmlspecialchars($member_data['last_login']);
            $point          = htmlspecialchars($member_data['point']);
            $work           = htmlspecialchars($member_data['work']);
            $religion       = htmlspecialchars($member_data['religion']);
            $view_count     = htmlspecialchars($member_data['view_count']);
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
                <h3>Member details</h3>
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
                        <?php if($form_show) {
                        ?>
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <?php 
                                        for ($i=0; $i < count($member_gallery); $i++) { 
                                    ?>                                     
                                        <div class="col-6">
                                            <div style="border-radius: 15px; width: 150px; height: 200px;" class="shadow-sm overflow-hidden mx-1 mb-2 d-flex justify-content-center align-items-center" ng-click="browseFile()">
                                                <a class="w-100 h-100" target="_blank" href="<?php echo $base_url . 'assets/uploads/' . $id . '/' . $member_gallery[$i];?>"><img class="w-100 h-100" style="object-fit: cover" src="<?php echo $base_url . 'assets/uploads/' . $id . '/' . $member_gallery[$i];?>" alt=""></a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-8" style="font-size: 18px;">
                                <div class="py-3 pl-5 shadow" style="border-radius: 15px;">
                                    <div class="mb-2">Name :  <?php echo $member_name; ?></div>
                                    <div class="my-2">Email : <?php echo $email; ?></div>
                                    <div class="my-2">Phone : <?php echo $phone; ?></div>
                                    <div class="my-2">Gender : <?php echo $gender; ?></div>
                                    <div class="my-2">Date of Birth : <?php echo $date_of_birth; ?></div>
                                    <div class="my-2">Hobbies : <?php echo $hobbies; ?></div>
                                    <div class="my-2">Education : <?php echo $education; ?></div>
                                    <div class="my-2">About : <?php echo $about; ?></div>
                                    <div class="my-2">Height : <?php echo $height_feet . "'" . $height_inches . '"'; ?></div>
                                    <div class="my-2">Prefer partner : <?php echo $partner_gender . ' between ' . $partner_min_age . ' and ' . $parter_max_age; ?></div>
                                    <?php 
                                        if($status == 0) {
                                    ?>
                                        <div class="my-2">Status : <span class="badge badge-warning">Unverified</span></div>
                                    <?php
                                        }else if($status == 1){
                                    ?>
                                        <div class="my-2">Status : <span class="badge badge-info">Email Verified</span></div>
                                    <?php
                                        }else if($status == 2){
                                    ?>
                                        <div class="my-2">Status : <span class="badge badge-success">Admin Verified</span></div>
                                    <?php
                                        }else if($status == 3){
                                    ?>
                                        <div class="my-2">Status : <span class="badge badge-danger">Banned</span></div>
                                    <?php
                                        }
                                    ?>
                                    <div class="my-2">Last log in : <?php echo $last_log_in; ?></div>
                                    <div class="my-2">Point : <?php echo $point; ?></div>
                                    <div class="my-2">Work : <?php echo $work; ?></div>
                                    <div class="my-2">Religion : <?php echo $religion; ?></div>
                                    <div class="mt-2"><i class="fa fa-eye"></i> : <?php echo $view_count; ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                        } else {
                        ?>
                        <div class="d-flex justify-content-between align-items-center">
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