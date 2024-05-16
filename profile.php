<?php 
    session_start();
    require('./site-config/config.php');
    require('./site-config/connect.php');
    require('./site-config/check_member_auth.php');
    require('./site-config/include_functions.php');
    $title = "Profile | " . $site_title;
    $description_content = "Myanmar Dating | Online Dating | Myanmar Cupid | MMcupid | သင့်ဖူးစာရှင်ကိုရှာဖွေလိုက်ပါ | Welcome Myanmar Cupid";
    $keywords_content = "myanrmar online dating, online dating, mmcupid, myanmar dating website, find love, find lover, dating, date partner, ဖူးစာရှာ, အချစ်ရှာ, ကောင်လေးရှာ, ကောင်မလေးရှာ";
    
    require('./templates/template_header.php');
?>
    <script type="text/javascript">
      const partner_gender = "<?php echo $_SESSION['partner_gender'] ; ?>";
      const partner_min_age= "<?php echo $_SESSION['partner_min_age'] ; ?>";
      const partner_max_age= "<?php echo $_SESSION['partner_max_age'] ; ?>";
      const images         = <?php echo json_encode($_SESSION['images']) ; ?>;
      
    </script>
    <div ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
        <div class="article">
        <article class="article-container position-relative">
            <header class="article-container-header d-flex justify-content-between">
            <span class="article-container-title" style="font-size: 26px">
                Profile
            </span>
            <div class="justify-content-center">
                <div class="flex" style="font-size: 20px;">
                    <i class="fa fa-cog fs-4" style="margin-right: 7px;"></i>
                    <a class="" type="button" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasUserProfile" aria-controls="offcanvasUserProfile">
                    <i class="fa fa-user fs-4"></i>
                    </a> 
                    <div class="offcanvas offcanvas-end position-absolute right-0" style="width: 650px;" data-bs-backdrop="false" tabindex="-1" id="offcanvasUserProfile" aria-labelledby="offcanvasUserProfile">
                    <div class="offcanvas-header position-sticky bg-white py-2 top-0 z-3 px-4 d-flex justify-content-between align-items-center fw-bold" style="font-size: 17px;">
                        <div type="button" ng-click="backSearchOffcanvas()" class="fs-4 float-left" data-bs-dismiss="offcanvas" aria-label="Close" aria-label="Back"><i class="fa fa-chevron-left"></i></div>
                        <div>10 % complete</div>
                        <div>Preview</div>
                    </div>
                    <div class="offcanvas-body py-0">
                        <div id="profile-offcanvas">
                            <table id="profile-images-table" class="mb-2" style="width: 100%; border-collapse: separate;  table-layout: fixed;">
                                <tr>
                                    <td class="" colspan="2" rowspan="2">
                                        <div class="preview-container bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" ng-click="browseFile()" style="height: 60vh;">
                                            <div id="preview1" class="d-none w-100 h-100"></div>
                                            <label for="" onclick="browseImage('1')" class="btn btn-dark p-2 rounded-3 hide position-absolute change-photo change-photo1" style="opacity: 0.8" >Change</label>
                                            <i class="fa fa-upload fs-4" style="cursor: pointer" id="upload-icon-1" onclick="browseImage('1')"></i>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                                            <div id="preview2" class="d-none w-100 h-100"></div>
                                            <label for="" onclick="browseImage('2')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo2" style="opacity: 0.8" >Change</label>
                                            <i class="fa fa-upload fs-4" onclick="browseImage('2')" style="cursor: pointer" id="upload-icon-2"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">
                                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh; margin-left: 10px;">
                                            <div id="preview3" class="d-none w-100 h-100"></div>
                                            <label for="" onclick="browseImage('3')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo3" style="opacity: 0.8" >Change</label>
                                            <i class="fa fa-upload fs-4" onclick="browseImage('3')" style="cursor: pointer" id="upload-icon-3"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">
                                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                                            <div id="preview4" class="d-none w-100 h-100"></div>
                                            <label for="" onclick="browseImage('4')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo4" style="opacity: 0.8" >Change</label>
                                            <i class="fa fa-upload fs-4" onclick="browseImage('4')" style="cursor: pointer" id="upload-icon-4"></i>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                                            <div id="preview5" class="d-none w-100 h-100"></div>
                                            <label for="" onclick="browseImage('5')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo5" style="opacity: 0.8" >Change</label>
                                            <i class="fa fa-upload fs-4" onclick="browseImage('5')" style="cursor: pointer" id="upload-icon-5"></i>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 29vh;">
                                            <div id="preview6" class="d-none w-100 h-100"></div>
                                            <label for="" onclick="browseImage('6')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo6" style="opacity: 0.8" >Change</label>
                                            <i class="fa fa-upload fs-4" onclick="browseImage('6')" style="cursor: pointer" id="upload-icon-6"></i>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        
                            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                                <div>
                                    <div class="fs-5 fw-bold mb-2"><?php echo $_SESSION['uusername'] . ', ' . $_SESSION['uage'] ;?></div>
                                    <div><?php if($_SESSION['ugender'] == 0) { echo 'Male' ;} else { echo 'Female' ;}; ?>,  <?php echo $_SESSION['ucity'] ;?></div>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-right fs-5"></i>
                                </div>
                            </div>
                            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                                <div>
                                    <div class="fs-5 fw-bold mb-2">Work and Education</div>
                                    <div><?php echo $_SESSION['uwork'] . ', ' . $_SESSION['ueducation'] ;?></div>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-right fs-5"></i>
                                </div>
                            </div>
                            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                                <div>
                                    <div class="fs-5 fw-bold mb-2">Why you are here</div>
                                    <div>Here to date</div>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-right fs-5"></i>
                                </div>
                            </div>
                            <div class="p-3 d-flex justify-content-between align-items-center rounded-4 bg-body-tertiary mb-2">
                                <div>
                                    <div class="fs-5 fw-bold mb-2">About me</div>
                                    <div><?php echo $_SESSION['uabout'] ;?></div>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-right fs-5"></i>
                                </div>
                            </div>

                            <button class="btn btn-dark w-100 fs-5 rounded-pill mb-2"><i class="fa-solid fa-circle-check"></i>Update</button>
                            
                            <div class="p-3 rounded-4 bg-body-tertiary mb-2">
                                <div class="fs-5 fw-bold mb-2">Get verified</div>
                                <div class="mb-3">Verification ups your chances by showing people they can trust you</div>
                                <button class="btn btn-dark w-100 fs-5 rounded-pill"><i class="fa-solid fa-circle-check"></i> Verify By Photo</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </header>
            <section class="article-container-body rtf">
            <div class="container">
                <div class="mt-1">
                    <div class="row">
                    <div class="col-md-3">
                        <img src="<?php echo $base_url . 'assets/front/images/' ; ?>Lylia.jpg" class="img-fluid rounded-circle"
                        alt="Profile Photo">
                    </div>
                    <div class="col-md-6">
                        <h3 class="mt-4">Hninn Pwint Phyu, 20</h3>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-smaller">
                            <i class="fa fa-mug-hot icon-bigger"></i>
                        Here To Date</button>
                    </div>    
                    </div>
                </div>
                
                <div class="mt-5">
                    <div class="row">
                        <p class="">  
                            <button type="button" class="btn active" data-bs-toggle="button" aria-pressed="true"
                            style="border-radius: 20px; width: 450px; height: 70px; margin-left: 35px;">
                            <img style="width: 30px; height: 30px; margin-right: 5px;" src = "<?php echo $base_url . 'assets/front/images/' ; ?>heart.png">
                            Take Control and Personalize Your Settings
                            <img style="width: 30px; height: 30px; margin-left: 35px ;" src = "<?php echo $base_url . 'assets/front/images/' ; ?>chevron.png">
                        </button> 
                        
                        </p>
                    </div>
                </div>

                <div class="mt-1">
                    <div class="row">
                    <div class="col-md-6" style="text-align: center;">
                    <a style="font-weight: bold;"> Plans</a>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                        <a href="safty.html" style="font-weight: bold;">Safty</a>
                    </div>    
                    </div>
                </div>

                <div class="mt-1">
                    <div class="row">
                    <div class="col-md-6">
                        <img style="width: 80px; height: 70px; margin-left: 80px;" src = "<?php echo $base_url . 'assets/front/images/' ; ?>tachometer.png">
                        <div>
                        <p style="font-size: smaller; margin-left: 100px; margin-bottom: 1px;">Activity </p>
                        <span style="font-size: large; color: red; margin-left: 90px;">
                            Average</span>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <img style="width: 50px; height: 50px; margin-left: 100px; margin-top: 15px;" src = "<?php echo $base_url . 'assets/front/images/' ; ?>heart1.png">
                    <div>
                        <p style="font-size: smaller; margin-left: 105px; margin-bottom: 1px; margin-top: 10px;">Credit</p>
                        <span style="font-size: large; margin-left: 115px;">
                            50</span>
                    </div> 
                    </div>    
                    </div>
                </div>
                
                
                <div class="mt-1">
                <div class="row">
                    <div class="card w-100 mb-3" style="background-color: lightgray;">
                    <div class="card-body">
                        <h5 class="card-title" style="text-align: center;">Badoo Premium</h5>
                        <p class="card-text" style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio sed ad ipsum?</p>
                        <p class="" style="background-color: azure; border-radius: 10px;
                        width: 250px; height: 30px; margin-left: 100px; padding-left: 30px;">
                        Active until April 13,2024 </p>
                        <p style="font-size: smaller; margin-left: 100px;">*Based on top 10% of 2.7m users sample</p>
                    </div>
                    </div>

                    
                </div>
            </div>
            
                <hr>
                <div class="mt-1">
                    <table class="table">
                        <thead>
                        <tr>
                            
                            <th scope="col" style="width: 300px;">What's included?</th>
                            <th scope="col" style="width: 50px; text-align: center;"> Premium</th>
                            <th scope="col" style="width: 50px; text-align: center;">Plus</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>heart1.png">
                            See Who liked you
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>
                        
                        <tr>
                            <td scope="row">
                            <img style="width: 35px; height: 35px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>bolt.png">
                            1 Extra Show Each Week
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>

                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>crush.png">
                            1 Crush Per Day 
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>


                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>checked.png">
                            Read receipts on all your chats
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>

                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>up.png">
                            Prioritize your sent messages
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>

                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>copy1.png">
                            Never run out of likes
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>


                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>undo.png">
                            Undo accidental left swipes
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>


                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>filter.png">
                            Get unlimited filters
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>

                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>user.png">
                            Browse profiles privately
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>

                        <tr>
                            <td scope="row">
                            <img style="width: 25px; height: 25px; margin-right: 5px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>close.png">
                            Remove ads
                            </td> 
                            <td> <img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            <td><img style="width: 20px; height: 20px; margin-left: 20px;" src="<?php echo $base_url . 'assets/front/images/' ; ?>tick.png"></td>
                            
                        </tr>

                        </tbody>
                    </table>
                </div>
                
            </div>
            </section>
            <?php require('./templates/template_footer_bar.php'); ?>
        </article>
        </div>
    </div>
<?php 
    require('./templates/template_footer.php');
?>

    <script src="<?php echo $base_url; ?>assets/front/js/profile.js?v=20240516"></script>
    <script>
        images.forEach(image => {
            $('#preview'+image.sort).html(`<img src= ${image.image} class="" style="width: 100%; height: 100%; object-fit: cover" alt="Image Preview"/>`);
            $('#upload-icon-'+image.sort).hide();
            $('.change-photo'+image.sort).show();
            $('#preview'+image.sort).removeClass('d-none');
        });
    </script>
<?php
    require('./templates/template_html_end.php');
?>