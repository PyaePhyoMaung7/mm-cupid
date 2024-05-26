<?php
session_start();
require('./site-config/config.php');
require('./site-config/connect.php');
require('./site-config/check_member_auth.php');
require('./site-config/include_functions.php');
$title = "Home | " . $site_title;
$description_content = "Myanmar Dating | Online Dating | Myanmar Cupid | MMcupid | သင့်ဖူးစာရှင်ကိုရှာဖွေလိုက်ပါ | Welcome Myanmar Cupid";
$keywords_content = "myanrmar online dating, online dating, mmcupid, myanmar dating website, find love, find lover, dating, date partner, ဖူးစာရှာ, အချစ်ရှာ, ကောင်လေးရှာ, ကောင်မလေးရှာ";

require ('./templates/template_header.php')
?>
<div ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
    <div class="loading" ng-if="loading">Loading&#8230;</div>
    <div class="content">
        <div id="post-details" class="vw-100 vh-100 position-absolute top-0 left-0 opacity-0" style="z-index: -10; ">
            <div class="d-flex justify-content-center align-items-center w-100 h-100" id="scroll-container">
            <div class="rounded-5 overflow-hidden opacity-100 bg-secondary position-relative" style="width: 630px; height: 80vh;">
                <div class="overflow-hidden">

                <!-- upper-container -->
                <div  class="position-absolute top-0 p-4" style="width: 100%;">
                    <div class="d-flex justify-content-end align-items-center">
                        <span id="post-cancel-btn" ng-click="cancelPost()" class="fs-4 fw-bold me-3" style="cursor: pointer;">&#10005;</span>
                    </div>
                    </div>
                </div>

                <div id="post-scroll-bar-container" class="position-absolute rounded shadow-lg" style="top: 40%; right: 3%; width: 5px; height: 80px; background-color: #e0e0e0;">
                    <div id="post-scroll-bar">
                    <div id="post-scroll-bar-value" class="bg-white shadow rounded position-absolute right-0" style="width: 100%; border: 0.2px solid #bdbdbd; height: 20px; top: 0; transform: scale(1.2);"></div>
                    </div>
                </div>

                <div id="lower-container" class="position-absolute bottom-0 p-4" style="width: 100%; ">
                    <div class="d-flex align-items-end justify-content-between">
                    <button class="round-btn btn btn-light" ng-disabled="prev_btn_disabled" id="prev-profile-btn" ng-click="showPrevPost(post_index)" style="width: 35px; height: 35px;"><i class="fa fs-5 fa-chevron-left"></i></button>
                    <div class="d-flex">
                        <div class="round-btn me-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-commenting fs-3"></i></div>
                        <div class="round-btn ms-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-heart fs-3"></i></div>
                    </div>
                    <button class="round-btn btn btn-light me-2" ng-disabled="next_btn_disabled" id="next-profile-btn" ng-click="showNextPost(post_index)" style="width: 35px; height: 35px;"><i class="fa fs-5 fa-chevron-right"></i></button>
                    </div>
                </div>

                <div id="post-content" class="overflow-y-auto bg-white" style="width:100%; height: 80vh; z-index: 5;">
                    <div class="w-100" style="height: 70%;">
                        <img ng-src="{{post.image}}" class="profile-image w-100 h-100 object-fit-cover" alt="">
                    </div>
                    <div class="p-3" style="margin-bottom: 70px;">
                        <h3 class="fw-bold my-2">{{post.title}}</h3>
                        <p class="text-secondary fs-5">{{post.description}}</p>
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
                    <div class="container" id="knowledge-content" style="z-index: 10; min-height: 500px;">
                        <div class="row g-3 my-2">
                            <div class="col-6" id="post-{{index}}" ng-repeat="(index, post) in posts">
                                <div class="card rounded-4 overflow-hidden shadow-sm" style="cursor: pointer" ng-click="showPostDetails(index)" >
                                    <img ng-src="{{post.thumb}}" alt="" class="image card-img-top" >
                                    <div class="card-body">
                                        <h5 class="card-title">{{post.title}}</h5>
                                        <p style="font-size: 12px; line-height: 16px; font-weight: 500" class="pt-2">
                                            {{ post.description.substring(0, 100)+ ' ...' }}
                                        </p>
                                    </div>
                                </div>
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
  <script src="<?php echo $base_url; ?>assets/front/js/knowledge.js?v=20240524"></script>
  <script>
    const getPost       = document.getElementById('post-content');
    const getScrollBar  = document.getElementById('post-scroll-bar-value');
  
    getPost.addEventListener('scroll',function(e){
        let percent = Math.round((getPost.scrollTop/(getPost.scrollHeight-getPost.clientHeight))*100);
        percent     = percent * 3/4;
        getScrollBar.style.top = `${percent}%`;
    })
    </script>
<?php
    require('./templates/template_html_end.php');
?>