<?php
    $error = false;
?>
<div class="offcanvas offcanvas-end position-absolute right-0" style="width: 650px;" data-bs-backdrop="false" tabindex="-1" id="offcanvasUserProfileEdit" aria-labelledby="offcanvasUserProfileEdit">
    <div class="offcanvas-header position-sticky bg-white py-2 top-0 z-3 px-4 d-flex justify-content-between align-items-center fw-bold" style="font-size: 17px;">
        <div type="button" ng-click="backUserProfile()" class="fs-4 float-left" data-bs-dismiss="offcanvas" aria-label="Close" aria-label="Back"><i class="fa fa-chevron-left"></i></div>
    </div>
    <div class="offcanvas-body py-0">
        <div id="profile-offcanvas-edit">
            <form id="update-form" action="<?php echo $base_url; ?>register.php" method="POST" enctype="multipart/form-data">
                <div id="update-form-container">
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter User Name" name="username" id="username" ng-model="member.username" ng-blur="validate('username')" ng-change="checkValidation('username');"/>
                    <p class="text-danger" ng-if="username_error">{{username_error_msg}}</p>
                    
                    <!-- <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Email" name="email" id="email" ng-model="email" ng-blur="validate('email')"  ng-change="checkValidation('email');"/>
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
                    </div> -->
                    
                    
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Phone" name="phone" id="phone" ng-model="member.phone" ng-blur="validate('phone')"  ng-change="checkValidation('phone');"/>
                    <p class="text-danger" ng-if="phone_error">{{phone_error_msg}}</p>

                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Your Birthday" name="birthday" id="birthday" ng-model="member.birthday" ng-blur="validate('birthday')" ng-change="checkValidation('birthday');"/>
                    <p class="text-danger" ng-if="birthday_error">{{birthday_error_msg}}</p>

                    <select name="city" ng-model="member.city_id" id="city" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-blur="validate('city')" ng-change="checkValidation('city');">
                        <option value="" >Choose City</option>
                        <option value="{{city.id}}" ng-repeat="city in cities">{{city.name}}</option>
                    </select>
                    <p class="text-danger" ng-if="city_error">{{city_error_msg}}</p>

                    <div class="d-flex justify-content-between">
                        <select name="hfeet" ng-model="member.hfeet" id="hfeet" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:48%;" ng-blur="validate('hfeet')" ng-change="checkValidation('hfeet');">
                            <option value="" selected>feet</option>
                            <option value="4">4'</option>
                            <option value="5">5'</option>
                            <option value="6">6'</option>
                            <option value="7">7'</option>
                        </select>
                        <select name="hinches" ng-model="member.hinches" id="hinches" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:48%;" ng-blur="validate('hinches')" ng-change="checkValidation('hinches');">
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
                    
                    <textarea name="education" ng-model="member.education" id="education" cols="30" rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Your Education" ng-blur="validate('education')" ng-change="checkValidation('education')"></textarea>
                    <p class="text-danger" ng-if="education_error">{{education_error_msg}}</p>

                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Please tell us about yourself" name="about" id="about" ng-model="member.about" ng-blur="validate('about')" ng-change="checkValidation('about')"/>
                    <p class="text-danger" ng-if="about_error">{{about_error_msg}}</p>

                    <select name="religion" ng-model="member.religion" id="religion" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-blur="validate('religion')" ng-change="checkValidation('religion');">
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
                        <input class="form-check-input gender" type="radio" id="male" name="gender" ng-model="member.gender" value="0" ng-blur="validate('gender')" ng-click="validate('gender')" >
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <!-- ng-change="checkValidation('gender')" -->
                    <div class="form-check form-check-inline"> 
                        <input class="form-check-input gender" type="radio" id="female" name="gender" ng-model="member.gender" value="1" ng-blur="validate('gender')" ng-click="validate('gender')" >
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    <p class="text-danger" ng-if="gender_error">{{gender_error_msg}}</p>

                    <p class="form-check-label mt-2" for="male">Please choose your hobbies.</p>
                    <div class="row ms-0">
                        <div class="col-6 col-md-4 form-check" ng-repeat="hobby in hobbies">
                            <input class="form-check-input hobby" name="hobbies[]" id="hobby-{{hobby.id}}" type="checkbox" value="{{hobby.id}}"  ng-blur="validate('selected-hobbies')" >
                            <label class="form-check-label" for="hobby-{{hobby.id}}">{{hobby.name}}</label>
                        </div>
                    </div>
                    <p class="text-danger" ng-if="hobby_error">{{hobby_error_msg}}</p>

                    <p class="form-check-label d-block mt-2" for="male">Please choose your partner gender.</p>
                    <div class="form-check form-check-inline">
                    <!-- ng-change="checkValidation('partner-gender')" -->
                        <input class="form-check-input partner-gender" type="radio" id="partner-male" name="partner-gender" ng-model="member.partner_gender" value="0" ng-blur="validate('partner-gender')" ng-click="validate('partner-gender')" >
                        <label class="form-check-label" for="partner-male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-female" name="partner-gender" ng-model="member.partner_gender" value="1" ng-blur="validate('partner-gender')" ng-click="validate('partner-gender')" >
                        <label class="form-check-label" for="partner-female">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-both" name="partner-gender" ng-model="member.partner_gender" value="2" ng-blur="validate('partner-gender')" ng-click="validate('partner-gender')" >
                        <label class="form-check-label" for="partner-both">Both</label>
                    </div>
                    
                    <p class="text-danger" ng-if="partner_gender_error">{{partner_gender_error_msg}}</p>


                    <div class="d-flex justify-content-between">
                        <div style="width:48%;">
                            <select name="min-age" ng-model="member.partner_min_age" id="min-age" class="form-control form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2" ng-blur="validate('min-age')" ng-change="chooseMinAge(); checkValidation('min-age');">
                                <option value="" selected>Minimum Age</option>
                                <option value='{{age}}' ng-repeat="age in min_ages">{{age}}</option>
                            </select>
                            <p class="text-danger text-center" ng-if="min_age_error">{{min_age_error_msg}}</p>
                        </div>
                        
                        <div style="width:48%;">
                            <select name="max-age" ng-model="member.partner_max_age" id="max-age" class="form-control form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2"  ng-blur="validate('max-age')" ng-change="chooseMaxAge(); checkValidation('max-age');">
                                <option value="" selected>Maximum Age</option>
                                <option value='{{age}}' ng-repeat="age in max_ages">{{age}}</option>
                            </select>
                            <p class="text-danger text-center" ng-if="max_age_error">{{max_age_error_msg}}</p>
                        </div>
                    </div>
                    
                    <textarea name="work" ng-model="member.work" id="work" cols="30" rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-blur="validate('work')" ng-change="checkValidation('work');" placeholder="Enter Your Occupation"></textarea>
                    <p class="text-danger" ng-if="work_error">{{work_error_msg}}</p>
                    
                    <!-- <button type="button" ng-click="next()" disabled id="next-btn" class="btn btn-dark rounded rounded-5 btn-lg mt-4" style="width:100%;">
                        Next
                    </button> -->
                </div>

                <div>
                    <?php 
                        if($error){
                    ?>
                        <p class="bg-danger text-white">
                            <?php echo $error_message; ?>
                        </p>
                    <?php
                        }
                    ?>
                    <table class="mt-2" style="width: 100%; border-collapse: separate; border-spacing: .5em; table-layout: fixed">
                        <tr>
                            <td class="" colspan="2" rowspan="2">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" ng-click="browseFile()" style="height: 48vh;">
                                    <div id="preview1" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('1')" class="btn btn-dark p-2 rounded-3 hide position-absolute change-photo change-photo1" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" style="cursor: pointer" id="upload-icon-1" onclick="browseImage('1')"></i>
                                </div>
                            </td>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 23vh;">
                                    <div id="preview2" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('2')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo2" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('2')" style="cursor: pointer" id="upload-icon-2"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 23vh;">
                                    <div id="preview3" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('3')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo3" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('3')" style="cursor: pointer" id="upload-icon-3"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 23vh;">
                                    <div id="preview4" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('4')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo4" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('4')" style="cursor: pointer" id="upload-icon-4"></i>
                                </div>
                            </td>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 23vh;">
                                    <div id="preview5" class="d-none w-100 h-100"></div>
                                    <label for="" onclick="browseImage('5')" class="btn btn-dark p-2 rounded-3 position-absolute hide change-photo change-photo5" style="opacity: 0.8" >Change</label>
                                    <i class="fa fa-upload fs-4" onclick="browseImage('5')" style="cursor: pointer" id="upload-icon-5"></i>
                                </div>
                            </td>
                            <td class="">
                                <div class="bg-body-secondary position-relative overflow-hidden rounded-2 d-flex justify-content-center align-items-center" style="height: 23vh;">
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
                    <button type="button" ng-click="update()" id="update-btn" class="btn btn-dark rounded rounded-5 mb-4 btn-lg mt-4" style="width:100%;">
                        Update
                    </button>

                    <input type="hidden" name="form-sub" value="1">
                    <input type="hidden" id="member-id" name="member-id">
                    <input type="hidden" id="email-confirm-code" name="email-confirm-code">
                    
                </div>
                
            </form>
        </div>
    </div>
</div>