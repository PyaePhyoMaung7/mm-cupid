<?php
  session_start();
  require('../site-config/config.php');
  require('../site-config/connect.php');
  require('../site-config/include_functions.php');

  $error          = false;
  $process_error  = false;
  $error_message  = '';
  $username       = '';
  $password       = '';

  if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1){
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    if($username == ''){
      $process_error  = true;
      $error          = true;
      $error_message .= "Please fill user name.<br/>";
    }
    if($password == ''){
      $process_error  = true;
      $error          = true;
      $error_message .= "Please fill password.<br/>";
    }
    if($process_error == false){
      $sql          = "SELECT id, username, password, role, status, deleted_at FROM `user` WHERE username = '$username'";
      $result       = $mysqli->query($sql);
      $result_rows  = $result->num_rows;
      if($result_rows <= 0){
        $error          = true;
        $error_message .= "The username does not match the data from our database.<br/>";
      }else{
        $password     = generatePassword($password, $sha_key);
        $user_db      = $result->fetch_assoc();
        $db_password  = $user_db['password'];
        if($password == $db_password){
          if(isset($user_db['deleted_at'])){
            $error          = true;
            $error_message .= "You have been deleted from our database.<br/>";
          }else{
            if($user_db['status'] == 0){
              $remember = isset($_POST['remember']) ? $_POST['remember'] : 0;
              if($remember == 1){
                setcookie('id', $user_db['id'], time() + (86400 * 30), '/');
                setcookie('username', $user_db['username'], time() + (86400 * 30), '/');
                setcookie('role', $user_db['role'], time() + (86400 * 30), '/');
              }else{
                $_SESSION['id']       = $user_db['id'];
                $_SESSION['username'] = $user_db['username'];
                $_SESSION['role']     = $user_db['role'];
              }
              $url = $admin_base_url . 'index.php';
              header('Refresh: 0 ; url = '.$url);
              exit();
            }else{
              $error          = true;
              $error_message .= "You have been banned from our website.<br/>";
            }
          }
        }else{
          $error          = true;
          $error_message .= "The password does not match the data from our database.<br/>";
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $site_title; ?> : Log in</title>
    <!-- Bootstrap -->
    <link href="<?php echo $base_url; ?>assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $base_url; ?>assets/css/font-awesome/font-awesome.min.css" rel="stylesheet">
    <!-- Pnotify -->
    <link href="<?php echo $base_url; ?>assets/css/pnotify/pnotify.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo $base_url; ?>assets/css/custom.css" rel="stylesheet">
    <!-- company logo -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base_url; ?>assets/images/cupid.jpg">
  </head>

  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo $admin_base_url; ?>login.php" method="POST">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $username; ?>"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password""/>
              </div>
              <div class="text-left">
                <label for="remember"><input type="checkbox" name="remember" value="1" id="remember">&nbsp;&nbsp;&nbsp;Remember me</label>
              </div>
              <div>
                <input type="hidden" name="form-sub" value="1">
                <button type="submit" class="btn btn-default submit">Log in</button>
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br/>
                <div>
                  <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery --> 
    <script src="<?php echo $base_url; ?>assets/js/jquery2.2/jquery.min.js"></script>
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
  </body>
</html>
