<?php 
    session_start();
    require('./site-config/config.php');
    require('./site-config/connect.php');
    require('./site-config/include_functions.php');
    $description_content = "Myanmar Dating, Online Dating, Myanmar Cupid, MMcupid, သင့်ဖူးစာရှင်ကိုရှာဖွေလိုက်ပါ";
    $keywords_content = "mmcupid | MMcupid | find love | find lover | dating | date partner | ဖူးစာရှာ | အချစ်ရှာ | ကောင်လေးရှာ | ကောင်မလေးရှာ";
    
    $title = "Log in | MMcupid";
    $email = '';
    $password = '';
    $error = false;
    $error_message = "";
    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1){
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT id, username, password, status, point, partner_gender, partner_min_age, partner_max_age FROM `members` WHERE email = '$email' AND deleted_at IS NULL";

        $result = $mysqli->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_id              = (int)$row['id'];
            $db_username        = htmlspecialchars($row['username']);
            $db_password        = $row['password'];
            $db_status          = (int)$row['status'];
            $db_point           = (int)$row['point'];
            $db_partner_gender  = (int)$row['partner_gender'];
            $db_partner_min_age = (int)$row['partner_min_age'];
            $db_partner_max_age = (int)$row['partner_max_age'];

            $hashed_password = generatePassword($password, $sha_key);
            if($hashed_password == $db_password){
                $status = htmlspecialchars($row['status']);
                if($status == 0){
                    $error = true;
                    $error_message = "Your account has not been activated yet. Please check your email and verfiy your email address.";
                }else if($status == 3){
                    $error = true;
                    $error_message = "Your account has been banned.";
                }else{
                    $_SESSION['uid']            = $db_id;
                    $_SESSION['uusername']      = $db_username;
                    $_SESSION['status']         = $db_status;
                    $_SESSION['upoint']         = $db_point;
                    $_SESSION['partner_gender'] = $db_partner_gender;
                    $_SESSION['partner_min_age']= $db_partner_min_age;
                    $_SESSION['partner_max_age']= $db_partner_max_age;

                    $today_dt  = date('Y-m-d H:i:s');
                    $update_last_login = "UPDATE `members` SET last_login = '$today_dt' WHERE id = '$db_id'";
                    $mysqli->query($update_last_login);

                    $url = $base_url . 'index';
                    header('Refresh: 0 ; url = '.$url);
                    exit();
                }
            }else{
                $error = true;
                $error_message = "Incorrect password. Please try again.";
            }
        }else{
            $error = true;
            $error_message = "Email cannot be found.";
        }
    
    }

    require('./templates/template_header.php')
?>

<div class="container my-5" ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
      <div class="row">
        <div class="col"></div>

        <div class="col-md-5">
            <h1 class="fw-bold text-center" style="font-size: 60px">Sign in</h1>
            <div class="py-3 text-center" style="font-size: 14px;">
                Don't have account yet? <a href="<?php echo $base_url . 'register' ?>" class="text-black">Sign up</a>
            </div>

            <form id="login-form" action="<?php echo $base_url; ?>login.php" method="POST">
                <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Email" name="email" id="email" ng-model="email" ng-blur="validate('email')"  ng-change="checkValidation();validate('email');" value="<?php echo $email; ?>"/>
                <p class="text-danger" ng-if="email_error">{{email_error_msg}}</p>
                
                <div class="position-relative">
                    <input type="password" ng-keypress="tryLogin($event)" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Password" name="password" id="password" ng-model="password" ng-blur="validate('password')"  ng-change="checkValidation();validate('password');" value="<?php echo $password; ?>" />
                    <i class="fa fa-eye-slash position-absolute top-0 end-0 mt-3 me-3 fs-5" id="password-icon" ng-mousedown="openPassword('password')" ng-mouseup="closePassword('password')"></i>
                    <p class="text-danger" ng-if="password_error">{{password_error_msg}}</p>
                </div>
                
                <button type="button" ng-click="login()" ng-disabled="process_error" id="login-btn" class="btn btn-dark rounded rounded-5 btn-lg mt-4" style="width:100%;">
                    Log in
                </button>  

                <input type="hidden" name="form-sub" value="1">
            </form>
            
            <p class="w-100 mt-4 fw-medium text-center" style="font-size: 12px; line-height:16px;">By signing up, you agree to our
            <a href="" class="text-black">Terms & Conditions</a>. Learn how we
                use your data in our
            <a href="" class="text-black">Privacy Policy</a>
            </p>
        </div>

        <div class="col"></div>
      </div>
</div>

<script src="<?php echo $base_url; ?>assets/front/js/login.js?v=20240430"></script>
<!-- PNotify -->
<script src="<?php echo $base_url; ?>assets/js/pnotify/pnotify.js"></script>

<?php 
    if($error){
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
    if(isset($_GET['msg']) && $_GET['msg'] == 1){
?>
<script>
    new PNotify({
        title: 'Welcome to ' + '<?php echo $site_title; ?>' + ' !',
        text: 'Your account has been activated successfully.</br>Please Login',
        width: '350px',
        type: 'success',
        styling: 'bootstrap3'
    });
</script>

<?php
    }
?>
<?php 
    require('./templates/template_html_end.php');
?>