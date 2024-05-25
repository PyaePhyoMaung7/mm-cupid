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
        <div class="article">
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
  </div>
<?php
    require('./templates/template_footer.php');
?>
  <script src="<?php echo $base_url; ?>assets/front/js/knowledge.js?v=20240524"></script>
<?php
    require('./templates/template_html_end.php');
?>