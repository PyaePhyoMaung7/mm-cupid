<?php
$error = false;
?>
<div class="offcanvas offcanvas-end position-absolute right-0" style="width: 650px;" data-bs-backdrop="false" tabindex="-1" id="offcanvasUserProfileEdit" aria-labelledby="offcanvasUserProfileEdit">
    <div class="offcanvas-header position-sticky bg-white py-2 top-0 z-3 px-4 d-flex justify-content-between align-items-center fw-bold" style="font-size: 17px;">
        <div type="button" ng-click="backUserProfile()" class="fs-4 float-left" data-bs-dismiss="offcanvas" aria-label="Close" aria-label="Back"><i class="fa fa-chevron-left"></i></div>
    </div>
    <div class="offcanvas-body py-0" id="">
        <div id="profile-offcanvas-edit">
            <form id="update-form" action="<?php echo $base_url; ?>register.php" method="POST" enctype="multipart/form-data">
                <div id="update-form-container">
                    <label for="username">Username</label>
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter User Name" name="username" id="username" ng-model="member_edit.username" ng-change="validate()"/>
                    <p class="text-danger" ng-if="username_error">{{username_error_msg}}</p>
                    
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Phone" name="phone" id="phone" ng-model="member_edit.phone" ng-change="validate()"/>
                    <p class="text-danger" ng-if="phone_error">{{phone_error_msg}}</p>

                    <label for="birthday">Birthday</label>
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Your Birthday" name="birthday" id="birthday" ng-model="member_edit.birthday" ng-change="validate()"/>
                    <p class="text-danger" ng-if="birthday_error">{{birthday_error_msg}}</p>

                    <label for="city">City</label>
                    <select name="city" ng-model="member_edit.city_id" id="city" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-change="validate()">
                        <option value="" >Choose City</option>
                        <option value="{{city.id}}" ng-repeat="city in cities">{{city.name}}</option>
                    </select>
                    <p class="text-danger" ng-if="city_error">{{city_error_msg}}</p>

                    <div class="d-flex justify-content-between">
                        <label for="hfeet" style="width: 48%">Height Feet</label>
                        <label for="hinches" style="width: 48%">Height Inches</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <select name="hfeet" ng-model="member_edit.hfeet" id="hfeet" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:48%;" ng-change="validate()">
                            <option value="" selected>feet</option>
                            <option value="4">4'</option>
                            <option value="5">5'</option>
                            <option value="6">6'</option>
                            <option value="7">7'</option>
                        </select>
                        <select name="hinches" ng-model="member_edit.hinches" id="hinches" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:48%;" ng-change="validate()">
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
                    
                    <label for="education">Education</label>
                    <textarea name="education" ng-model="member_edit.education" id="education" cols="30" rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Enter Your Education" ng-change="validate()"></textarea>
                    <p class="text-danger" ng-if="education_error">{{education_error_msg}}</p>

                    <label for="about">About Me</label>
                    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" placeholder="Please tell us about yourself" name="about" id="about" ng-model="member_edit.about" ng-change="validate()"/>
                    <p class="text-danger" ng-if="about_error">{{about_error_msg}}</p>

                    <label for="religion">Religion</label>
                    <select name="religion" ng-model="member_edit.religion" id="religion" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-change="validate()">
                        <option value="" selected>Choose your religion</option>
                        <option value="1">Christianity</option>
                        <option value="2">Islam</option>
                        <option value="3">Buddhism</option>
                        <option value="4">Hinduism</option>
                        <option value="5">Jain</option>
                        <option value="6">Shinto</option>
                        <option value="7">Atheism</option>
                        <option value="8">Others</option>
                        
                    </select>
                    <p class="text-danger" ng-if="religion_error">{{religion_error_msg}}</p>

                    <p class="mt-2">Please choose your gender.</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input gender" type="radio" id="male" name="gender" ng-model="member_edit.gender" value="0">
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <!-- ng-change="checkValidation('gender')" -->
                    <div class="form-check form-check-inline"> 
                        <input class="form-check-input gender" type="radio" id="female" name="gender" ng-model="member_edit.gender" value="1">
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    <p class="text-danger" ng-if="gender_error">{{gender_error_msg}}</p>

                    <p class="form-check-label mt-2" for="male">Please choose your hobbies.</p>
                    <div class="row ms-0">
                        <div class="col-6 col-md-4 form-check" ng-repeat="hobby in hobbies">
                            <input class="form-check-input hobby" name="hobbies[]" id="hobby-{{hobby.id}}" type="checkbox" value="{{hobby.id}}" ng-model="hobby.checked"  ng-change="validate()">
                            <label class="form-check-label" for="hobby-{{hobby.id}}">{{hobby.name}}</label>
                        </div>
                    </div>
                    <p class="text-danger" ng-if="hobby_error">{{hobby_error_msg}}</p>

                    <p class="form-check-label d-block mt-2" for="male">Please choose your partner gender.</p>
                    <div class="form-check form-check-inline">
                    <!-- ng-change="checkValidation('partner-gender')" -->
                        <input class="form-check-input partner-gender" type="radio" id="partner-male" name="partner-gender" ng-model="member_edit.partner_gender" value="0">
                        <label class="form-check-label" for="partner-male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-female" name="partner-gender" ng-model="member_edit.partner_gender" value="1">
                        <label class="form-check-label" for="partner-female">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input partner-gender" type="radio" id="partner-both" name="partner-gender" ng-model="member_edit.partner_gender" value="2">
                        <label class="form-check-label" for="partner-both">Both</label>
                    </div>
                    
                    <p class="text-danger" ng-if="partner_gender_error">{{partner_gender_error_msg}}</p>


                    <div class="d-flex justify-content-between">
                        <label for="min-age" style="width: 48%">Minimum Age</label>
                        <label for="max-age" style="width: 48%">Maximum Age</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div style="width:48%;">
                            <select name="min-age" ng-model="member_edit.partner_min_age" id="min-age" class="form-control form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2" ng-change="chooseMinAge()">
                                <option value="" selected>Minimum Age</option>
                                <option value='{{age}}' ng-repeat="age in min_ages">{{age}}</option>
                            </select>
                            <p class="text-danger text-center" ng-if="min_age_error">{{min_age_error_msg}}</p>
                        </div>
                        
                        <div style="width:48%;">
                            <select name="max-age" ng-model="member_edit.partner_max_age" id="max-age" class="form-control form-control-lg w-100 border border-1 border-black rounded rounded-4 mt-2" ng-change="chooseMaxAge()">
                                <option value="" selected>Maximum Age</option>
                                <option value='{{age}}' ng-repeat="age in max_ages">{{age}}</option>
                            </select>
                            <p class="text-danger text-center" ng-if="max_age_error">{{max_age_error_msg}}</p>
                        </div>
                    </div>

                    <label for="work">Occupation</label>
                    <textarea name="work" ng-model="member_edit.work" id="work" cols="30" rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width:100%;" ng-change="validate()" placeholder="Enter Your Occupation"></textarea>
                    <p class="text-danger" ng-if="work_error">{{work_error_msg}}</p>
                </div>

                <div>
                    <?php
                        if ($error) {
                            ?>
                        <p class="bg-danger text-white">
                            <?php echo $error_message; ?>
                        </p>
                    <?php
                        }
                    ?>
                    <button type="button" ng-click="update()" id="update-details-btn" disabled class="btn btn-dark rounded rounded-5 mb-4 btn-lg mt-4" style="width:100%;">
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

<script>
    const offcanvas_body1 = document.querySelectorAll('.offcanvas-body')[1];
    offcanvas_body1.addEventListener('scroll', function() {
    let offcanvas_header1 = document.querySelectorAll('.offcanvas-header')[1];
    if (offcanvas_body1.scrollTop > 0) {
        offcanvas_header1.classList.add('border-bottom', 'border-secondary-subtle');
    } else {
        offcanvas_header1.classList.remove('border-bottom', 'border-secondary-subtle');
    }
    });
</script>