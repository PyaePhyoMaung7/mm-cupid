<?php 
    require('./site-config/config.php');
    require('./site-config/connect.php');
    require('./site-config/include_functions.php');
    $title = "Registration | MMcupid";
    $description_content = "Myanmar Dating, Online Dating, Myanmar Cupid, MMcupid, သင့်ဖူးစာရှင်ကိုရှာဖွေလိုက်ပါ";
    $keywords_content = "mmcupid | MMcupid | find love | find lover | dating | date partner | ဖူးစာရှာ | အချစ်ရှာ | ကောင်လေးရှာ | ကောင်မလေးရှာ";
    $error = false;
    $error_message = '';
    $member_id = '';
    $is_thumb = false;
    $unique_thumb_name = '';
    if(isset($_POST['form-sub']) && $_POST['form-sub'] == 1){
        $member_id          = $mysqli->real_escape_string($_POST['member-id']);
        $email_confirm_code = $mysqli->real_escape_string($_POST['email-confirm-code']);
        $today_dt           = date('Y-m-d H:i:s');
        $dir          = "./assets/uploads";
        $upload_photos      = [];
        for ($i=1; $i <= 6 ; $i++) {
            $key        = 'upload' . $i;
            $upload    = $_FILES[$key];
            $upload_name = $upload['name'];
            if($upload_name != ""){
                $upload_dir = $dir . '/' . $member_id . '/';
                if(checkImageExtension($upload_name) && getimagesize($upload['tmp_name'])){
                    $unique_upload_name = makeUniqueImageName($upload_name);
                    if(!file_exists($upload_dir) || !is_dir($upload_dir)){
                        mkdir($upload_dir, 0777, true);
                    }
                    $destination = $upload_dir . $unique_upload_name;
                    move_uploaded_file($upload['tmp_name'], $destination);
                    array_push($upload_photos, $unique_upload_name);

                    if(!$is_thumb){
                        $thumb_upload_dir = $dir . '/' . $member_id . '/thumb/';
                        if(!file_exists($thumb_upload_dir) || !is_dir($thumb_upload_dir)){
                            mkdir($thumb_upload_dir, 0777, true);
                        }
                        $unique_thumb_name = makeUniqueThumbName($upload_name);
                        $thumb_destination = $thumb_upload_dir . $unique_thumb_name;
                        cropAndResizeImage($destination, $thumb_destination, $thumb_width, $thumb_height);
                        $is_thumb = true;
                    }
                }else{
                    $error = true;
                    $error_message .= 'Invalid file type at upload ' . $i . '<br/>';
                    $error_message .= 'Only jpg, jpeg, png, gif, webp images are accepted. <br/>';
                }
            }else{
                array_push($upload_photos, "");
            }
        }

        foreach ($upload_photos as $index=>$photo) {
            if($photo != "") {
                $sort = $index+1;
                $upload_sql = "INSERT INTO `member_gallery` (member_id, name, sort, created_at, created_by, updated_at, updated_by)
                            VALUES ('$member_id','$photo','$sort', '$today_dt', '$member_id', '$today_dt', '$member_id')";
                $mysqli->query($upload_sql);  
            }
        }

        $thumbnail_sql = "UPDATE `members` SET thumbnail = '$unique_thumb_name' WHERE id = '$member_id'";

        $mysqli->query($thumbnail_sql);

        if(!$error){
            $setting_sql = "SELECT * FROM `setting`";
            $setting_res = $mysqli->query($setting_sql);
    
            if($setting_res->num_rows <= 0) {
                $company_name = "MM Cupid";
                $company_logo = "cupid.jpg";
                $company_email  = "mmcupid@gmail.com";
                $company_address = "No. 123, Banana Street, North Okkalapa";
            }else{
                $setting_row = $setting_res->fetch_assoc();
                $company_name       = htmlspecialchars($setting_row['company_name']);
                $company_logo       = htmlspecialchars($setting_row['company_logo']);
                $company_email      = htmlspecialchars($setting_row['company_email']);
                $company_address    = htmlspecialchars($setting_row['company_address']);
            }
    
            $member_sql = "SELECT email, email_confirm_code FROM `members` WHERE id = '$member_id'";
            $member_res         = $mysqli->query($member_sql);
            $member_row         = $member_res->fetch_assoc();
            $member_email       = htmlspecialchars($member_row['email']);
            $email_confirm_code = htmlspecialchars($member_row['email_confirm_code']);
    
            $logo = $base_url . 'assets/images/' . $company_logo;
            $confirm_link = $base_url . 'email-confirm?code=' . $email_confirm_code ;
    
            $to = $member_email; 
            $from = $company_email; 
            $fromName = $company_name; 
            
            $subject = $company_name . ': Email Verification.'; 
            
            $html_content = <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Activation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="container" style="width: 500px; margin: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="me-5"><h3>Please verify your email</h3></div>
                    <div class="" >
                        <img class="rounded-circle shadow" style="width: 50px;" src="{$logo}" alt="">
                    </div>
                </div>
                <div class="my-4">
                    <div class="fs-5">Please take a second to make sure we've got your email right.</div>
                    <div class="text-center" style="margin: 35px 0;">
                        <a href="{$confirm_link}"  target="_blank"><button class="btn btn-danger fw-bold fs-6 py-2"  style="width: 90%;">Confirm your email</button></a>
                    </div>
                    <div class="fs-5">Didn't sign up for <span class="text-danger fw-bold">{$company_name}</span> ?<span class="text-primary"> Let us know.</span></div>
                </div>
                <div class="mt-5 bg-body-secondary p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <img class="rounded-circle shadow" style="width: 55px;" src="{$logo}" alt="">
                        </div>
                        <div>
                            <h3 class="text-danger fw-bold">{$company_name}</h3>
                        </div>
                    </div>
                    <div class="mb-1">
                        {$company_address}
                    </div>
                    <div style="font-size: 13px;">
                        <a href="" class="text-secondary">Help Center</a> .
                        <a href="" class="text-secondary">Privacy Policy</a> .
                        <a href="" class="text-secondary">Terms & Conditions</a> 
                        <a href="" class="text-secondary d-block">Unsubscribe {$member_email} from this email</a>
                    </div>
    
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
    </html>
HTML; 
            
            // Additional headers 
            $headers = "MIME-Version: 1.0"; 
            $headers .= "Content-type:text/html;charset=UTF-8"; 
            $headers .= 'From: '.$fromName.'<'.$from.'>'; 
            
            echo $html_content;
            exit();
            // Send email 
            // if(mail($to, $subject, $message, $headers)){ 
            // echo 'Email has sent successfully.'; 
            // }else{ 
            // echo 'Email sending failed.'; 
            // }
    
        }
    }
    require('./templates/template_header.php')

?>
    <div class="container my-5" ng-app="myApp" ng-controller="myCtrl" ng-init="init()">
      <div class="row">
        <div class="col"></div>

        <div class="col-md-5">
            <h1 class="fw-bold text-center" style="font-size: 60px">Sign up</h1>
            <div class="py-3 text-center" style="font-size: 14px;">
                Already have an account? <a href="<?php echo $base_url . 'login'; ?>" class="text-black">Log in</a>
            </div>
            <div class="fw-medium text-center" style="font-size: 14px;">Sign up with your email or phone number</div>

            <form id="register-form" action="<?php echo $base_url; ?>register.php" method="POST" enctype="multipart/form-data">
                <div ng-if="user_info">
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter User Name" name="username" id="username" ng-model="username" ng-blur="validate('username')" ng-change="checkValidation('username');"/>
                    <p class="text-danger" ng-if="username_error">{{username_error_msg}}</p>
                    
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Email" name="email" id="email" ng-model="email" ng-blur="validate('email')"  ng-change="checkValidation('email');"/>
                    <p class="text-danger" ng-if="email_error">{{email_error_msg}}</p>
                    
                    <div class="position-relative">
                        <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Password" name="password" id="password" ng-model="password" ng-blur="validate('password')"  ng-change="checkValidation('password');"/>
                        <i class="fa fa-eye-slash position-absolute top-0 end-0 mt-3 me-3 fs-5" id="password-icon" ng-mousedown="openPassword('password')" ng-mouseup="closePassword('password')"></i>
                        <p class="text-danger" ng-if="password_error">{{password_error_msg}}</p>
                    </div>
                    
                    <div class="position-relative">
                        <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Confirm Password" name="confirm-password" id="confirm-password" ng-model="confirm_password" ng-blur="validate('confirm_password')" ng-change="checkValidation('confirm_password');"/>
                        <i class="fa fa-eye-slash position-absolute top-0 end-0 mt-3 me-3 fs-5" id="confirm-password-icon" ng-mousedown="openPassword('confirm-password')" ng-mouseup="closePassword('confirm-password')"></i>
                        <p class="text-danger" ng-if="confirm_password_error">{{confirm_password_error_msg}}</p>
                        <p class="text-danger" ng-if="passwords_unmatch_error">{{passwords_unmatch_error_msg}}</p>
                    </div>
                    
                    
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Phone" name="phone" id="phone" ng-model="phone" ng-blur="validate('phone')"  ng-change="checkValidation('phone');"/>
                    <p class="text-danger" ng-if="phone_error">{{phone_error_msg}}</p>

                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Your Birthday" name="birthday" id="birthday" ng-model="birthday" ng-blur="validate('birthday')" ng-change="checkValidation('birthday');"/>
                    <p class="text-danger" ng-if="birthday_error">{{birthday_error_msg}}</p>

                    <select name="city" ng-model="city" id="city" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-blur="validate('city')" ng-change="checkValidation('city');">
                        <option value="" selected>Choose City</option>
                        <option value="{{city.id}}" ng-repeat="city in cities">{{city.name}}</option>
                    </select>
                    <p class="text-danger" ng-if="city_error">{{city_error_msg}}</p>

                    <div class="d-flex justify-content-between">
                        <select name="hfeet" ng-model="hfeet" id="hfeet" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:48%;" ng-blur="validate('hfeet')" ng-change="checkValidation('hfeet');">
                            <option value="" selected>feet</option>
                            <option value="4">4'</option>
                            <option value="5">5'</option>
                            <option value="6">6'</option>
                            <option value="7">7'</option>
                        </select>
                        <select name="hinches" ng-model="hinches" id="hinches" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:48%;" ng-blur="validate('hinches')" ng-change="checkValidation('hinches');">
                            <option value="" selected>inches</option>
                            <option value='0'>0"</option>
                            <option value='1'>1"</option>
                            <option value='2'>2"</option>
                            <option value='3'>3"</option>
                            <option value='4'>4"</option>
                            <option value='5'>5"</option>
                            <option value='6'>6"</option>
                            <option value='7'>7"</option>
                            <option value='8'>8"</option>
                            <option value='9'>9"</option>
                            <option value='10'>10"</option>
                            <option value='11'>11"</option>
                        </select>
                    </div>
                    <p class="text-danger" ng-if="hfeet_error">{{hfeet_error_msg}}</p>
                    <p class="text-danger" ng-if="hinches_error">{{hinches_error_msg}}</p>
                    
                    <textarea name="education" ng-model="education" id="education" cols="30" rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Your Education" ng-blur="validate('education')" ng-change="checkValidation('education')"></textarea>
                    <p class="text-danger" ng-if="education_error">{{education_error_msg}}</p>

                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Please tell us about yourself" name="about" id="about" ng-model="about" ng-blur="validate('about')" ng-change="checkValidation('about')"/>
                    <p class="text-danger" ng-if="about_error">{{about_error_msg}}</p>

                    <select name="religion" ng-model="religion" id="religion" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-blur="validate('religion')" ng-change="checkValidation('religion');">
                        <option value="" selected>Choose your religion</option>
                        <option value="1">Christianity</option>
                        <option value="2">Islam</option>
                        <option value="3">Buddhistm</option>
                        <option value="4">Hinduism</option>
                        <option value="5">Jain</option>
                        <option value="6">Shinto</option>
                        <option value="7">Atheism</option>
                        <option value="8">Others</option>
                        
                    </select>
                    <p class="text-danger" ng-if="religion_error">{{religion_error_msg}}</p>


                    <p class="mt-2">Please choose your gender.</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input gender" type="radio" id="male" name="gender" ng-model="gender" value="0" ng-blur="validate('gender')" ng-click="validate('gender')" ng-change="checkValidation('gender')">
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input gender" type="radio" id="female" name="gender" ng-model="gender" value="1" ng-blur="validate('gender')" ng-click="validate('gender')" ng-change="checkValidation('gender')">
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    <p class="text-danger" ng-if="gender_error">{{gender_error_msg}}</p>

                    <p class="form-check-label mt-2" for="male">Please choose your hobbies.</p>
                    <div class="row ms-0">
                        <div class="col-md-4 form-check" ng-repeat="hobby in hobbies">
                            <input class="form-check-input hobby" name="hobbies[]" id="hobby-{{hobby.id}}" type="checkbox" value="{{hobby.id}}" ng-model="selected_hobbies"  ng-blur="validate('selected-hobbies')" ng-change="checkValidation('selected-hobbies');">
                            <label class="form-check-label" for="hobby-{{hobby.id}}">{{hobby.name}}</label>
                        </div>
                    </div>
                    <p class="text-danger" ng-if="hobby_error">{{hobby_error_msg}}</p>

                    <p class="form-check-label d-block mt-2" for="male">Please choose your partner gender.</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-male" name="partner-gender" ng-model="partner_gender" value="0" ng-blur="validate('partner-gender')" ng-click="validate('partner-gender')" ng-change="checkValidation('partner-gender')">
                        <label class="form-check-label" for="partner-male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-female" name="partner-gender" ng-model="partner_gender" value="1" ng-blur="validate('partner-gender')" ng-click="validate('partner-gender')" ng-change="checkValidation('partner-gender')">
                        <label class="form-check-label" for="partner-female">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-both" name="partner-gender" ng-model="partner_gender" value="2" ng-blur="validate('partner-gender')" ng-click="validate('partner-gender')" ng-change="checkValidation('partner-gender')">
                        <label class="form-check-label" for="partner-both">Both</label>
                    </div>
                    
                    <p class="text-danger" ng-if="partner_gender_error">{{partner_gender_error_msg}}</p>


                    <div class="d-flex justify-content-between">
                        <div style="width:48%;">
                            <select name="min-age" ng-model="min_age" id="min-age" class="form-control form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2" ng-blur="validate('min-age')" ng-change="chooseMinAge(); checkValidation('min-age');">
                                <option value="" selected>Minimum Age</option>
                                <option value='{{age}}' ng-repeat="age in min_ages">{{age}}</option>
                            </select>
                            <p class="text-danger text-center" ng-if="min_age_error">{{min_age_error_msg}}</p>
                        </div>
                        
                        <div style="width:48%;">
                            <select name="max-age" ng-model="max_age" id="max-age" class="form-control form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2"  ng-blur="validate('max-age')" ng-change="chooseMaxAge(); checkValidation('max-age');">
                                <option value="" selected>Maximum Age</option>
                                <option value='{{age}}' ng-repeat="age in max_ages">{{age}}</option>
                            </select>
                            <p class="text-danger text-center" ng-if="max_age_error">{{max_age_error_msg}}</p>
                        </div>
                    </div>
                    
                    <textarea name="work" ng-model="work" id="work" cols="30" rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-blur="validate('work')" ng-change="checkValidation('work');" placeholder="Enter Your Occupation"></textarea>
                    <p class="text-danger" ng-if="work_error">{{work_error_msg}}</p>
                    
                    <button type="button" ng-click="next()" disabled id="next-btn" class="btn btn-dark rounded rounded-5 btn-lg mt-4" style="width:100%;">
                        Next
                    </button>
                </div>

                <div ng-if="user_photo">
                    <?php 
                        if($error){
                    ?>
                        <p class="bg-danger text-white">
                            <?php echo $error_message; ?>
                        </p>
                    <?php
                        }
                    ?>
                    <table class="mt-2" style="width: 100%; margin-left: -5px;">
                        <tr>
                            <td class="" colspan="2" rowspan="2">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 mx-1 d-flex justify-content-center align-items-center" ng-click="browseFile()" style="height: 48vh; width: 23vw;  ">
                                    <div id="preview1" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('1')" class="btn btn-dark p-2 rounded-3 hide position-absolute change-photo change-photo1" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" style="cursor: pointer" id="upload-icon-1" onclick="browseImage('1')"></i>
                                </div>
                            </td>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 m-1 d-flex justify-content-center align-items-center" style="height: 23vh; width: 11vw; ">
                                    <div id="preview2" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('2')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo2" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('2')" style="cursor: pointer" id="upload-icon-2"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 m-1 d-flex justify-content-center align-items-center" style="height: 23vh; width: 11vw; ">
                                    <div id="preview3" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('3')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo3" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('3')" style="cursor: pointer" id="upload-icon-3"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 m-1 d-flex justify-content-center align-items-center" style="height: 23vh; width: 11vw; ">
                                    <div id="preview4" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('4')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo4" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('4')" style="cursor: pointer" id="upload-icon-4"></i>
                                </div>
                            </td>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 m-1 d-flex justify-content-center align-items-center" style="height: 23vh; width: 11vw; ">
                                    <div id="preview5" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('5')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo5" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('5')" style="cursor: pointer" id="upload-icon-5"></i>
                                </div>
                            </td>
                            <td class="rounded-2">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 m-1 d-flex justify-content-center align-items-center" style="height: 23vh; width: 11vw; ">
                                    <div id="preview6" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('6')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo6" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('6')" style="cursor: pointer" id="upload-icon-6"></i>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <input type="file" name="upload1" id="upload1" onchange="previewImage('1')" class="d-none">
                    <input type="file" name="upload2" id="upload2" onchange="previewImage('2')" class="d-none">
                    <input type="file" name="upload3" id="upload3" onchange="previewImage('3')" class="d-none">
                    <input type="file" name="upload4" id="upload4" onchange="previewImage('4')" class="d-none">
                    <input type="file" name="upload5" id="upload5" onchange="previewImage('5')" class="d-none">
                    <input type="file" name="upload6" id="upload6" onchange="previewImage('6')" class="d-none">
                    <button type="button" ng-click="register()" disabled id="register-btn" class="btn btn-dark rounded rounded-5 btn-lg mt-4" style="width:105%;">
                        Register
                    </button>

                    <input type="hidden" name="form-sub" value="1">
                    <input type="hidden" id="member-id" name="member-id">
                    <input type="hidden" id="email-confirm-code" name="email-confirm-code">
                    
                </div>
                
            </form>
            
            <p class="w-100 mt-4 fw-medium text-center" style="font-size: 12px; line-height:16px;">By signing up, you agree to our
            <a href="" class="text-black">Terms & Conditions</a>. Learn how we
                use your data in our
            <a href="" class="text-black">Privacy Policy</a>
            </p>
        </div>

        <div class="col"></div>
      </div>
    </div>
   
    <script>
        let today_date = new Date();
        let last_18_years_ago_date;
        if(today_date.getFullYear()%4 == 0 && today_date.getMonth() == 1 && today_date.getDate() == 29){
            last_18_years_ago_date = new Date(today_date.getFullYear() - 18, today_date.getMonth(), today_date.getDate()-1);
        }else{
            last_18_years_ago_date = new Date(today_date.getFullYear() - 18, today_date.getMonth(), today_date.getDate());
        }
        $( function() {
            $( "#birthday" ).datepicker({
                changeYear: true,
                changeMonth: true, 
                dateFormat: 'yy-mm-dd',
                maxDate: last_18_years_ago_date,
                yearRange: "-60:+0"
            });

            $("#birthday").prop('readonly', true);

        } );

        function browseImage (index) {
            $('#upload'+index).click();
        }

        function previewImage (index) {

            const fileInput = document.getElementById('upload'+index);
            const preview = document.getElementById('preview'+index);

            let fileName = fileInput.value.split('\\').pop();
            let fileExtension = fileName.split('.').pop();

            let allow_extensions = ['jpg','jpeg','png','gif','webp', 'avif'];

            let file = event.target.files[0];

            if(allow_extensions.includes(fileExtension)){
                if(file){
                    let reader = new FileReader();
                    reader.onload = function(event) {
                    let imgSrc = event.target.result;
                    preview.innerHTML = `<img src= ${imgSrc} class="" style="width: 100%; height: 100%; object-fit: cover" alt="Image Preview"/>`;
                    };
                    reader.readAsDataURL(file);
                    preview.style.display = "";
                    $('#upload-icon-'+index).hide();
                    $('.change-photo'+index).show();
                    $('#preview'+index).removeClass('d-none');
                }
            }else{
                $('#upload'+index).val('');
                $('#preview'+index).innerHTML = "";
                $('.change-photo'+index).hide();
                $('#upload-icon-'+index).show();
                $('#preview'+index).addClass('d-none');

               alert('Your uploaded file type is not accepted.');
            };

            let upload1_value = document.getElementById('upload1').value;
            let upload2_value = document.getElementById('upload2').value;
            let upload3_value = document.getElementById('upload3').value;
            let upload4_value = document.getElementById('upload4').value;
            let upload5_value = document.getElementById('upload5').value;
            let upload6_value = document.getElementById('upload6').value;

            if(upload1_value != "" || upload2_value != "" || upload3_value != "" || upload4_value != "" || upload5_value != "" || upload6_value != ""){
                $('#register-btn').prop('disabled', false);
            }else{
                $('#register-btn').prop('disabled', true);
            }
        }
    </script>

    <script src="<?php echo $base_url; ?>assets/front/js/register.js?v=20240430"></script>
    <!-- <script src="<?php echo $base_url; ?>assets/js/jquery2.2/jquery.min.js"></script> -->
    <!-- <script src="<?php echo $base_url; ?>assets/js/pnotify/pnotify.js"></script>    -->
<?php 
    require('./templates/template_html_end.php');
?>
