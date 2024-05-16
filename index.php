<?php 
    session_start();
    require('./site-config/config.php');
    require('./site-config/connect.php');
    require('./site-config/check_member_auth.php');
    require('./site-config/include_functions.php');
    $title = "Nearby | " . $site_title;
    $description_content = "Myanmar Dating | Online Dating | Myanmar Cupid | MMcupid | သင့်ဖူးစာရှင်ကိုရှာဖွေလိုက်ပါ | Welcome Myanmar Cupid";
    $keywords_content = "myanrmar online dating, online dating, mmcupid, myanmar dating website, find love, find lover, dating, date partner, ဖူးစာရှာ, အချစ်ရှာ, ကောင်လေးရှာ, ကောင်မလေးရှာ";
    
    require('./templates/template_header.php')
?>
    <script>
      const partner_gender = "<?php echo $_SESSION['partner_gender'] ; ?>";
      const partner_min_age= "<?php echo $_SESSION['partner_min_age'] ; ?>";
      const partner_max_age= "<?php echo $_SESSION['partner_max_age'] ; ?>";
    </script>
  <div ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
    <div class="loading" ng-if="loading">Loading&#8230;</div>
    <div class="content">
      <div id="carousel-wrapper" style="z-index: 1;" class="opacity-0 bg-black vw-100 position-fixed top-0 p-0" >
        <div role="button" id="cancel-btn" ng-click="stopImageView()" style="z-index: 10; left: 3.5vw; width: 100px; height: 100px;" class="position-absolute text-secondary fw-bold fs-3 d-flex justify-content-center">
          <span id="carousel-cancel-btn">&#10005;</span>
        </div>
        <div class="carousel-indicators position-absolute top-0 mx-auto" style="height: 8%; ">
            <div class="fs-5 text-white w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0,0,0,0.5);"><span id="current-page"></span></div>
        </div>

        <div id="carousalexample" class="carousel slide mx-auto" data-bs-interval="false">
            <div class="carousel-inner mx-auto">
            </div>
            <a class="carousel-control-prev" ng-click="displayCurrentPage('prev')" id="carousel-prev-btn" data-bs-target="#carousalexample" type="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"  aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" ng-click="displayCurrentPage('next')" id="carousel-next-btn" data-bs-target="#carousalexample" type="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
      </div>
      <div id="member-profile" class="vw-100 vh-100 position-absolute top-0 left-0 opacity-0" style="z-index: -10; ">
        <div class="d-flex justify-content-center align-items-center w-100 h-100" id="scroll-container">
          <div class="rounded-5 overflow-hidden opacity-100 bg-secondary position-relative" style="width: 540px; height: 80vh;">
            <div class="overflow-hidden">
              
              <div id="upper-container" class="position-absolute top-0 p-4" style="width: 100%;">
                <div class="d-flex text-white justify-content-between">
                  <div class="d-flex align-items-center">
                    <span class="fw-bold fs-4 me-2" >{{member.username}}, {{member.age}}</span> <i class="fa fa-circle text-success" style="font-size: 7px;"></i>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    
                    <button class="btn border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class="fa fa-ellipsis-h text-light fs-3 me-3"></i></button>

                    <div style="width: 540px; height: 260px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                      <div class="offcanvas-header">
                        <button type="button" class="btn-close fs-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                      </div>
                      <div class="offcanvas-body small fs-6 fw-semibold">
                        <div class="mb-4" style="cursor: pointer;">Add To Favorites</div>
                        <div class="text-danger mb-4" style="cursor: pointer;">Block</div>
                        <div class="text-danger" style="cursor: pointer;">Block And Report</div>
                      </div>
                    </div>
                    
                    <span id="profile-cancel-btn" ng-click="cancelProfile()" class="fs-4 fw-bold" style="cursor: pointer;">&#10005;</span>
                  </div>
                </div>
              </div>

              <div id="profile-scroll-bar-container" class="position-absolute rounded shadow-lg" style="top: 40%; right: 3%; width: 5px; height: 80px; background-color: #e0e0e0;">
                <div id="profile-scroll-bar">
                  <div id="profile-scroll-bar-value" class="bg-white shadow rounded position-absolute right-0" style="width: 100%; border: 0.2px solid #bdbdbd; height: 20px; top: 0; transform: scale(1.2);"></div>
                </div>
              </div>

              <div id="lower-container" class="position-absolute bottom-0 p-4" style="width: 100%; ">
                <div class="d-flex align-items-end justify-content-between">
                  <button class="round-btn btn btn-light" ng-disabled="prev_btn_disabled" id="prev-profile-btn" ng-click="showPrevProfile(member_index)" style="width: 35px; height: 35px;"><i class="fa fs-5 fa-chevron-left"></i></button>
                  <div class="d-flex">
                    <div class="round-btn me-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-commenting fs-3"></i></div>
                    <div class="round-btn ms-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-heart fs-3"></i></div>
                  </div>
                  <button class="round-btn btn btn-light me-2" ng-disabled="next_btn_disabled" id="next-profile-btn" ng-click="showNextProfile(member_index)" style="width: 35px; height: 35px;"><i class="fa fs-5 fa-chevron-right"></i></button>
                </div>
              </div>

              <div id="profile-content" class="overflow-y-auto bg-white" style="width:100%; height: 80vh; z-index: 5;">
                <div class="w-100 h-100">
                  <img ng-src="{{image_arr[0].image}}" ng-click="showCarousel(0, image_arr[0].image, $event)" class="profile-image w-100 h-100 object-fit-cover" alt="">
                </div>
                <div class="">
                  <div class="p-4">
                    <span class="text-secondary fw-bold">Why {{first_name}}'s here</span>
                    <div class="tag-color p-3 mt-2 rounded-4 d-flex justify-content-start align-items-center">
                      <i class="fa fa-coffee me-2 fs-3"></i><span class="fs-4 fw-bold">Here to date</span>
                    </div>
                  </div>
                  <div class="p-4">
                    <div class="text-secondary fw-bold">About me</div>
                    <div class="fs-5 fw-bold mt-2" > {{ member.about}}</div>
                  </div>
                  
                  <div class="p-4">
                    <div class="text-secondary fw-bold">Han's info</div>
                    <div class="mt-2 row g-2">
                      <span class="col-auto tag-color rounded-pill p-2 mx-1" ><i class="fa fa-male"></i>&nbsp;{{member.height}}</span>
                      <span class="col-auto tag-color rounded-pill p-2 mx-1" ><i class="fa fa-graduation-cap"></i>&nbsp;{{member.education}} </span>
                      <span class="col-auto tag-color rounded-pill p-2 mx-1" ><i class="fa fa-book"></i>&nbsp;{{member.religion}}</span>
                      <span class="col-auto tag-color rounded-pill p-2 mx-1" ><i class="fa fa-briefcase">&nbsp;</i> {{member.work}} </span>
                    </div>
                  </div>
                  
                  <div class="mb-2" ng-repeat="(index, image) in image_arr" ng-if="image.sort != 1">
                    <div class="w-100 h-100" style="padding-left: vw;">
                      <img ng-src="{{image.image}}" ng-click="showCarousel(index, image.image, $event)" class="profile-image w-100 h-100 mb-1 object-fit-cover" alt="">
                    </div>
                  </div>

                  <div class="p-4">
                    <div class="text-secondary fw-bold">Current location</div>
                    <div class="fs-5 fw-bold mt-2" >{{member.city}}</div>
                  </div>
                  <div class="p-4" style="margin-bottom: 70px;">
                    <div class="text-secondary fw-bold">Verification</div>
                    <div class="mt-2">
                      <span class="fs-5 fw-bold" ng-if="member.status == 0"><i class="fa fa-certificate fs-5 me-2 text-danger"></i> {{first_name}} is unverified</span>
                      <span class="fs-5 fw-bold" ng-if="member.status == 1"><i class="fa fa-certificate fs-5 me-2 text-primary"></i> {{first_name}} is email verified</span>
                      <span class="fs-5 fw-bold" ng-if="member.status == 2"><i class="fa fa-certificate fs-5 me-2 text-success"></i> {{first_name}} is admin verified</span>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="article" >
        <article class="article-container">
          <?php require('./templates/template_header_bar.php'); ?>

          <section class="article-container-body rtf">
            <div class="container" id="image-content" style="z-index: 10; min-height: 500px;">
              <div class="row my-2">
                <div class="col-6 col-sm-4 mb-2 member-profiles" style="height: 36vh;" id="profile-{{index}}" ng-repeat="(index, member) in members">
                  <div class="" style="height: 85%;">
                    <img ng-src="{{member.thumb}}" ng-click="showMemberProfile(index)" width="100%" height="100%" alt="" class="image rounded rounded-4 object-fit-cover"
                      data-toggle="modal" data-target="#exampleModal">
                  </div>
                  <p style="font-size: 12px; line-height: 16px; font-weight: 500" class="pt-2">
                    {{member.username}}, {{member.age}}
                  </p>
                </div>
              </div>
              <div class="text-center my-3" ng-if="show_more">
                <button class="btn btn-dark" id="load-more-btn" ng-click="loadMore()">... Show More ...</button>
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
  <script src="<?php echo $base_url; ?>assets/front/js/jquery-3.5.1.slim.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/front/js/popper.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/front/js/index.js?v=20240508"></script>
  <!-- <script src="<?php echo $base_url; ?>assets/front/js/app.js">></script> -->
  <script>
    
  const getProfile        = document.getElementById('profile-content');
  const getScrollBar      = document.getElementById('profile-scroll-bar-value');

  getProfile.addEventListener('scroll',function(e){
      let percent = Math.round((getProfile.scrollTop/(getProfile.scrollHeight-getProfile.clientHeight))*100);
      percent     = percent * 3/4;
      getScrollBar.style.top = `${percent}%`;
  })
  </script>
<?php
    require('./templates/template_html_end.php');
?>