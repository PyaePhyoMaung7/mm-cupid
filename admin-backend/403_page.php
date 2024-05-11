<?php
    session_start();
    require('../site-config/config.php');
    require('../site-config/connect.php');
    require('../site-config/include_functions.php');
    require('../site-config/check_authentication.php');
    $title = ": Access Denied";
    require('../templates/cp_template_header.php');
    require('../templates/cp_template_sidebar.php');
    require('../templates/cp_template_top_nav.php');
?>
<!-- page content -->
<div class="col-md-12 " style="height: 85vh">
    <div class="col-middle">
    <div class="text-center text-center">
        <h1 class="error-number">403</h1>
        <h3 class="my-5 font-weight-bold">Access denied</h3>
        <h6 class="text-center font-weight-bold">You must be an admin to access this page. <a href="#">Contact us?</a>
        </h6>
    </div>
    </div>
</div>
<!-- /page content -->
<?php
    require('../templates/cp_template_footer.php');
?>
<!-- Custom javascript code goes here -->
<script>
    
</script>
<?php
    require('../templates/cp_template_html_end.php');
?>