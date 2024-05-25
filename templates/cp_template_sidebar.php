<?php
  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user_role = $_SESSION['role'];
  }else{
    $username = $_COOKIE['username'];
    $user_role = $_COOKIE['role'];
  }

  if($user_role == 1){
    $user_image = 'admin.png';
  }else if($user_role == 2){
    $user_image = 'customer_service.png';
  }else{
    $user_image = 'editor.png';
  }
?>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php $admin_base_url; ?>index.php" class="site_title">
              <span><?php echo $site_title; ?></span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?php echo $base_url; ?>assets/images/<?php echo $user_image; ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo $username; ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="<?php echo $admin_base_url; ?>index.php"><i class="fa fa-home"></i> Home</a></li>

                <?php
                if($user_role == 1){
                ?>
                <li><a><i class="fa fa-user"></i> User Management <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $admin_base_url; ?>create_user.php">Create</a></li>
                    <li><a href="<?php echo $admin_base_url; ?>show_user.php">Listing</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-building"></i> City Management <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $admin_base_url; ?>create_city.php">Create</a></li>
                    <li><a href="<?php echo $admin_base_url; ?>show_city.php">Listing</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-futbol-o"></i> Hobby Management <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $admin_base_url; ?>create_hobby.php">Create</a></li>
                    <li><a href="<?php echo $admin_base_url; ?>show_hobby.php">Listing</a></li>
                  </ul>
                </li>

                <li><a href="<?php echo $admin_base_url; ?>setting.php" ><i class="fa fa-gear"></i> Setting </a></li>
                <li><a href="<?php echo $admin_base_url; ?>show_member.php" ><i class="fa fa-users"></i> Member Mangement </a></li>
                
                <li><a><i class="fa fa-newspaper-o"></i>Knowledge Management<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo $admin_base_url; ?>create_post.php">Create</a></li>
                    <li><a href="<?php echo $admin_base_url; ?>show_post.php">Listing</a></li>
                  </ul>
                </li>
                <?php 
                }
                ?>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>