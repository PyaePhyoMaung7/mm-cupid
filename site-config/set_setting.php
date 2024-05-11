<?php 
    $setting_sql        = 'SELECT company_name, company_logo FROM `setting`';
    $setting_res = $mysqli->query($setting_sql);
    if($setting_res->num_rows <= 0){
        $site_title = 'MM Cupid';
        $logo = $base_url.'assets/images/cupid.jpg';
    }else{
        $setting = $setting_res->fetch_assoc();
        $site_title = $setting['company_name'];
        $logo = $base_url.'assets/images/'. $setting['company_logo'];
    }
?>