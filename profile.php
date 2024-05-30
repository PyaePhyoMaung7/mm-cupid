<?php 
    session_start();
    require('./site-config/config.php');
    require('./site-config/connect.php');
    require('./site-config/check_member_auth.php');
    require('./site-config/include_functions.php');
    $title = "Best Free Myanmar Dating Site & App - Friends, Chats, Flirt | " . $site_title;
    $description_content = "Myanmar Dating | Online Dating | Myanmar Cupid | MMcupid | သင့်ဖူးစာရှင်ကိုရှာဖွေလိုက်ပါ | Welcome Myanmar Cupid";
    $keywords_content = "myanrmar online dating, online dating, mmcupid, myanmar dating website, find love, find lover, dating, date partner, ဖူးစာရှာ, အချစ်ရှာ, ကောင်လေးရှာ, ကောင်မလေးရှာ";
    
    require('./templates/template_header.php');
?>
    <div ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
        <div class="content">
            <div class="article">
                <article class="article-container position-relative">
                    <header class="article-container-header d-flex justify-content-between">
                    <span class="article-container-title" style="font-size: 26px">
                        Profile
                    </span>
                    <div class="justify-content-center">
                        <div class="flex align-items-center" style="font-size: 20px;">
                            <a href="javascript:void(0)" title="log out"  onclick="confirmLogout('<?php echo $base_url; ?>logout')" class="me-1" style="outline: none; background: transparent; border: 1px solid transparent;" type="button" >
                                <i class="fa fa-sign-out fs-4"></i>
                            </a>
                            <i class="fa fa-cog fs-4" style="margin-right: 7px;"></i>
                            <button class="" style="outline: none; background: transparent; border: 1px solid transparent;" type="button" >
                                <i class="fa fa-user fs-4" id="user-profile-btn" data-bs-toggle="offcanvas"  data-bs-target="#offcanvasUserProfile" aria-controls="offcanvasUserProfile"></i>
                            </button> 
                           
                            <?php 
                                require('./include_files/offcanvas_profile.php');
                                require('./include_files/offcanvas_profile_edit.php');
                                require('./include_files/offcanvas_photo_verify.php'); 
                            ?>
                               
                        </div>
                    </div>
                    </header>
                    <section class="article-container-body rtf">
                    <div class="container">
                        <div class="mt-1">
                            <div class="row">
                            <div class="col-3" >
                                <div class="position-relative" style="width: 120px; height: 120px;">
                                    <div class="shadow-sm overflow-hidden w-100 h-100 rounded-circle" >
                                        <img ng-src="{{member.thumb}}" class="w-100 h-100 object-fit-cover"
                                        alt="Profile Photo">
                                    </div>
                                    <span class="fs-5 fw-bold d-flex align-items-center position-absolute z-3" style="bottom: 10px; right: -5px;"  ng-if="member.status == 4">
                                        <span class="fa-stack me-2" style="font-size: 14px;">
                                            <i class="fa fa-certificate fa-stack-2x text-primary"></i>
                                            <i class="fa fa-check fa-stack-1x text-white"></i>
                                        </span>
                                    </span> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="mt-4">{{member.username}}, {{member.age}}</h3>
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-smaller">
                                    <i class="fa fa-coffee fs-6"></i>
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
                                        <th scope="col-9" style="">Username</th>
                                        <th scope="col" style=" text-center">View</th>
                                        <th scope="col" style="">Accept</th>
                                        <th scope="col" style="">Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="(index, inviter) in inviters">
                                        <td scope="" class="col-9">
                                            <strong>{{inviter.username.split(' ')[0]}}</strong>
                                        </td> 
                                        <td class="">
                                            <div class="round-btn shadow-sm ms-3 btn btn-light" ng-click="showInviterProfile(index)" title="view date inviter" style="width: 30px; height: 30px; margin: 0 auto !important;"><i class="fa fa-eye fs-6"></i></div>
                                        </td>
                                        <td class="">
                                            <div class="round-btn shadow-sm ms-3 btn btn-light" ng-click="dateRequestAction(inviter.id, 2)" title="accept date invitation" style="width: 30px; height: 30px; margin: 0 auto !important;"><i class="fa fa-check fs-6"></i></div>
                                        </td>
                                        <td class="">
                                            <div class="round-btn shadow-sm ms-3 btn btn-light" ng-click="dateRequestAction(inviter.id, 1)" title="reject date invitation" style="width: 30px; height: 30px; margin: 0 auto !important;"><i class="fa fa-times fs-6"></i></div>
                                        </td>
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
    </div>
<?php 
    require('./templates/template_footer.php');
?>
    <script src="<?php echo $base_url; ?>assets/front/js/profile.js?v=20240516"></script>
    <script>
        let today_date = new Date();
        let last_18_years_ago_date;
        if(today_date.getFullYear()%4 == 0 && today_date.getMonth() == 1 && today_date.getDate() == 29){
            last_18_years_ago_date = new Date(today_date.getFullYear() - 18, today_date.getMonth(), today_date.getDate()-1);
        }else{
            last_18_years_ago_date = new Date(today_date.getFullYear() - 18, today_date.getMonth(), today_date.getDate());
        }
        $( "#birthday" ).datepicker({
            changeYear: true,
            changeMonth: true, 
            dateFormat: 'yy-mm-dd',
            maxDate: last_18_years_ago_date,
            yearRange: "-60:+0"
        });

        $("#birthday").prop('readonly', true);

        function confirmLogout(url){
            Swal.fire({
                title: "Log out confirmation",
                text: "Are you leaving our website? 😢",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, sign out!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                    
                }
            });
        }
    </script>
<?php
    require('./templates/template_html_end.php');
?>