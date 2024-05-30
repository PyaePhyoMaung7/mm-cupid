<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0" />
    <meta name="description" content="<?php echo $description_content; ?>">
    <meta name="keywords" content="<?php echo $keywords_content; ?>">
    <!-- <meta property="og:title" content="Aries" />
    <meta property="og:description" content="Aries is the best zodiac sign." />
    <meta property="og:image" content="http://localhost/mm-cupid/assets/post_images/2/202405260820326652d4b0a297f_aries.jpg" />
    <meta property="og:url" content="http://localhost/mm-cupid/knowledge.php" />
    <meta property="og:type" content="website" /> -->

    <title><?php echo $title; ?></title>
    <link
      href="<?php echo $base_url; ?>assets/front/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="<?php echo $base_url; ?>assets/front/css/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/front/css/custom.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/front/css/jquery-ui.css">
    <script src="<?php echo $base_url; ?>assets/front/js/jquery-3.6.0.js"></script>
    <script src="<?php echo $base_url; ?>assets/front/js/jquery-ui.js"></script>
    <script src="<?php echo $base_url; ?>assets/front/js/angular.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/front/js/error_messages.js"></script>
    <script src="<?php echo $base_url; ?>assets/front/js/success_messages.js"></script>
  
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/font-awesome/font-awesome.min.css">
    <!-- Pnotify -->
    <link href="<?php echo $base_url; ?>assets/css/pnotify/pnotify.css" rel="stylesheet">
    
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base_url; ?>assets/images/cupid.jpg">
    <style>
      .btn-outline-secondary {
        --bs-btn-hover-bg: #6c757d32;
      }
      .pnotify-center {
        right: calc(50% - 200px) !important;
      }
    </style>
    <script>
      const base_url = 'http://localhost/mm-cupid/';
      const gender_type = { 0 : 'Man' , 1 : 'Woman' , 2 : 'Everyone'};
    </script>
    
  </head>
  <body style="background-color: #e9d8ff">
  <div class="loading" style="display: none; z-index: 1060;">Loading&#8230;</div>
