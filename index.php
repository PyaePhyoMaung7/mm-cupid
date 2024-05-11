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
  <div ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
  <div id="carousel-wrapper" style="z-index: 1;" class="opacity-0 bg-black vw-100 position-fixed top-0 p-0" >
      <div role="button" id="cancel-btn" onclick="stopImageView()" style="z-index: 10; left: 3.5vw; width: 100px; height: 100px;" class="position-absolute text-secondary fw-bold fs-3 d-flex justify-content-center">
        <span id="carousel-cancel-btn">&#10005;</span>
      </div>
      <div class="carousel-indicators position-absolute top-0 mx-auto" style="height: 8%; ">
          <div class="fs-5 text-white w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0,0,0,0.5);"><span id="current-page"></span></div>
      </div>

      <div id="carousalexample" class="carousel slide mx-auto" data-bs-interval="false">
          <div class="carousel-inner mx-auto">
          </div>
          <a class="carousel-control-prev" onclick="displayCurrentPage('prev')" id="prev-btn" data-bs-target="#carousalexample" type="button" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"  aria-hidden="true"></span>
          </a>
          <a class="carousel-control-next" onclick="displayCurrentPage('next')" id="next-btn" data-bs-target="#carousalexample" type="button" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
          </a>
      </div>
    </div>
    <div id="member-profile" class="vw-100 vh-100 position-absolute top-0 left-0" style="z-index: -10; ">
      <div class="d-flex justify-content-center align-items-center w-100 h-100" id="scroll-container">
        <div class="rounded-5 overflow-hidden opacity-100 bg-secondary position-relative" style="width: 540px; height: 80vh;">
          <div class="overflow-hidden">
            
            <div id="upper-container" class="position-absolute top-0 p-4" style="width: 100%;">
              <div class="d-flex text-white justify-content-between">
                <div class="d-flex align-items-center">
                  <span class="fw-bold fs-4 me-2">Thue Thue, 18</span> <i class="fa fa-circle text-success" style="font-size: 7px;"></i>
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

            <div id="profile-scroll-bar-container" class="position-absolute rounded" style="top: 40%; right: 3%; width: 5px; height: 80px; background-color: #e0e0e0;">
              <div id="profile-scroll-bar">
                <div id="profile-scroll-bar-value" class="bg-white shadow rounded position-absolute right-0" style="width: 100%; border: 0.2px solid #bdbdbd; height: 20px; top: 0; transform: scale(1.2);"></div>
              </div>
            </div>

            <div id="lower-container" class="position-absolute bottom-0 p-4" style="width: 100%; ">
              <div class="d-flex align-items-end justify-content-between">
                <div class="round-btn btn btn-light" style="width: 35px; height: 35px;"><i class="fa fs-5 fa-chevron-left"></i></div>
                <div class="d-flex">
                  <div class="round-btn me-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-commenting fs-3"></i></div>
                  <div class="round-btn ms-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-heart fs-3"></i></div>
                </div>
                <div class="round-btn btn btn-light me-2" style="width: 35px; height: 35px;"><i class="fa fs-5 fa-chevron-right"></i></div>
              </div>
            </div>

            <div id="profile-content" class="overflow-y-auto bg-white" style="width:100%; height: 80vh; z-index: 5;">
              <div class="w-100 h-100">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIW_WVA2eMCdTfk2asrQBoV3-Yt2AoM60UKK5Zb30JCA&s" class="profile-image w-100 h-100 object-fit-cover" alt="">
              </div>
              <div class="">
                <div class="p-4">
                  <span class="text-secondary fw-bold">Why Thue's here</span>
                  <div class="tag-color p-3 mt-2 rounded-4 d-flex justify-content-start align-items-center">
                    <i class="fa fa-coffee me-2 fs-3"></i><span class="fs-4 fw-bold">Here to date</span>
                  </div>
                </div>
                <div class="p-4">
                  <div class="text-secondary fw-bold">About me</div>
                  <div class="fs-5 fw-bold mt-2">Better in person</div>
                </div>
                <div class="p-4">
                  <div class="text-secondary fw-bold">Han's info</div>
                  <div class="mt-2 row g-2">
                    <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-male"></i> 164 cm</span>
                    <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-graduation-cap"></i> Graduate </span>
                    <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-book"></i> Buddhist </span>
                    <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-briefcase"></i> Nurse </span>
                  </div>
                </div>
                <div class="mb-2">
                  <div class="w-100 h-100" style="padding-left: vw;">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLjisGy4eY5ZkfsZAmtRQ-4MstK4DapAPegcL52fG10g&s" class="profile-image w-100 h-100 object-fit-cover" alt="">
                  </div>
                </div>
                <div class="mb-2">
                  <div class="w-100 h-100" style="padding-left: vw;">
                    <img src="https://i.pinimg.com/736x/e7/e1/14/e7e114e5b52011520f05926fdd40a6d0.jpg" class="profile-image w-100 h-100 object-fit-cover" alt="">
                  </div>
                </div>

                <div class="p-4">
                  <div class="text-secondary fw-bold">Current location</div>
                  <div class="fs-5 fw-bold mt-2">Yangon</div>
                </div>
                <div class="p-4" style="margin-bottom: 70px;">
                  <div class="text-secondary fw-bold">Verification</div>
                  <div class="mt-2"><i class="fa fa-certificate fs-5 me-2 text-primary"></i><span class="fs-5 fw-bold">Thue is photo verified</span></div>
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
              <div class="col-md-4" style="height: 34vh;" ng-repeat="member in members">
                <div class="" style="height: 85%;">
                  <img ng-src="{{member.thumb}}" ng-click="showMemberProfile(member.id)" width="100%" height="100%" alt="" class="image rounded rounded-4 object-fit-cover"
                    data-toggle="modal" data-target="#exampleModal">
                </div>
                <p style="font-size: 12px; line-height: 16px; font-weight: 500" class="pt-2">
                  {{member.username}}, {{member.age}}
                </p>
              </div>
            </div>
            <div class="text-center my-3">
              <button class="btn btn-dark" id="load-more-btn" ng-click="loadMore()">... Load More ...</button>
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
  <script src="<?php echo $base_url; ?>assets/front/js/jquery-3.5.1.slim.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/front/js/popper.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/front/js/index.js?v=20240508"></script>
  <script src="<?php echo $base_url; ?>assets/front/js/app.js">></script>
<?php
    require('./templates/template_html_end.php');
?>