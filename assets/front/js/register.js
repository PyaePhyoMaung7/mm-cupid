var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http){
    $scope.username         = "";
    $scope.email            = "";
    $scope.password         = "";
    $scope.confirm_password = "";
    $scope.phone            = "";
    $scope.birthday         = "";
    $scope.city             = "";
    $scope.hfeet            = "";
    $scope.hinches          = "";
    $scope.gender           = "";
    $scope.education        = "";
    $scope.about            = "";
    $scope.selected_hobbies = [];
    $scope.partner_gender   = "";
    $scope.min_age          = "";
    $scope.max_age          = "";
    $scope.religion         = "";
    $scope.work             = "";
    $scope.data             = {};
    $scope.process_error    = false;
    $scope.user_info        = true;
    $scope.user_photo       = false;
    $scope.emailRegex       = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    $scope.passwordRegex    = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]*$/;
    $scope.dateRegex        = /^\d{4}-\d{2}-\d{2}$/;
    $scope.min_ages         = [];
    $scope.max_ages         = [];

    for (let i = 18; i <= 55; i++) {
        $scope.min_ages.push(i);
    }

    $scope.max_ages = [...$scope.min_ages];

    $scope.init = function () {
       $http.get(base_url+'api/get_cities.php')
       .then(
            function (response) {
                if(response.status == '200'){
                    $scope.cities = response.data;
                }
            }
        )

        $http.get(base_url+'api/get_hobbies.php')
        .then(
            function (response) {
                if(response.status == '200'){
                    $scope.hobbies = response.data;
                }
            }
        )

    }

    $scope.openPassword = function (field) {
        $('#'+field).prop('type','text');
        $('#'+field+'-icon').removeClass('fa-eye-slash');
        $('#'+field+'-icon').addClass('fa-eye');
    }

    $scope.closePassword = function (field) {
        $('#'+field).prop('type','password');
        $('#'+field+'-icon').removeClass('fa-eye');
        $('#'+field+'-icon').addClass('fa-eye-slash');
        
    }

    $scope.chooseMinAge = function () {
        $scope.min_age = $('#min-age').val();
        $scope.max_ages = [];
        if($scope.min_age == ''){
            for (let i = 18; i <= 55; i++) {
                $scope.max_ages.push(i);
            }
        }else{
            for (let i = $scope.min_age; i <= 55; i++) {
                $scope.max_ages.push(i);
            }
        }

        $scope.validate('min-age');
    }

    $scope.chooseMaxAge = function () {
        $scope.max_age = $('#max-age').val();
        $scope.min_ages = [];
        if($scope.max_age == ""){
            for (let i = 18; i <= 55; i++) {
                $scope.min_ages.push(i);
            }
        }else{
            for (let i = 18; i <= $scope.max_age; i++) {
                $scope.min_ages.push(i);
            }
        }

        $scope.validate('max-age');
    }
    
    $scope.formSubmit = function () {
        $('#register-form').submit();
    }
    
    $scope.checkValidation = function (field) {
        $scope.username = $('#username').val();
        $scope.email = $('#email').val();
        $scope.password = $('#password').val();
        $scope.confirm_password = $('#confirm-password').val();
        $scope.phone = $('#phone').val();
        $scope.birthday = $('#birthday').val();
        $scope.city = $('#city').val();
        $scope.hfeet = $('#hfeet').val();
        $scope.hinches = $('#hinches').val();
        $scope.gender = $('.gender:checked').val();
        
        $scope.education = $('#education').val();
        $scope.about = $('#about').val();
        $scope.selected_hobbies = [];
        $(".hobby:checked").each(function(){
            $scope.selected_hobbies.push($(this).val());
        });
        $scope.partner_gender = $('.partner-gender:checked').val();
        $scope.min_age = $('#min-age').val();
        $scope.max_age = $('#max-age').val();
        $scope.religion = $('#religion').val();
        $scope.work = $('#work').val();
        
        $scope.process_error = false;
        if($scope.username == ""){
            $scope.process_error = true;
        }
        if($scope.email == ""){
            $scope.process_error = true;
        }
        if($scope.password == ""){
            $scope.process_error = true;
        }
        if($scope.confirm_password == ""){
            $scope.process_error = true;
        }
        if($scope.password !== '' && $scope.confirm_password !== '' && $scope.password !== $scope.confirm_password){
            $scope.process_error = true;
        }
        if($scope.phone == ""){
            $scope.process_error = true;
        }
        if($scope.birthday == "" || !$scope.dateRegex.test($scope.birthday)){
            $scope.process_error = true;
        }
        if($scope.city == ""){
            $scope.process_error = true;
        }
        if($scope.hfeet == ""){
            $scope.process_error = true;
        }
        if($scope.hinches == ""){
            $scope.process_error = true;
        }
        if($scope.gender == ""){
            $scope.process_error = true;
        }
        if($scope.education == ""){
            $scope.process_error = true;
        }
        if($scope.about == ""){
            $scope.process_error = true;
        }

        if($scope.selected_hobbies.length == 0){
            $scope.process_error = true;
        }

        if($scope.partner_gender == ""){
            $scope.process_error = true;
        }

        if($scope.min_age == ""){
            $scope.process_error = true;
        }

        if($scope.max_age == ""){
            $scope.process_error = true;
        }

        if($scope.religion == ""){
            $scope.process_error = true;
        }

        if($scope.work == ""){
            $scope.process_error = true;
        }

        $scope.validate(field);
        
    }

    $scope.next = function () {
        $scope.data = {};
        let data = {};
        data.username       = $scope.username;
        data.email          = $scope.email;
        data.password       = $scope.password;
        data.phone          = $scope.phone;
        data.birthday       = $scope.birthday;
        data.city           = $scope.city;
        data.hfeet          = $scope.hfeet;
        data.hinches        = $scope.hinches;
        data.education      = $scope.education;
        data.about          = $scope.about;
        data.gender         = $scope.gender;
        data.hobbies        = $scope.selected_hobbies;
        data.partner_gender = $scope.partner_gender;
        data.min_age        = $scope.min_age;
        data.max_age        = $scope.max_age;
        data.religion       = $scope.religion;
        data.work           = $scope.work;

        $scope.data         = data;
       
        if($scope.email_exist){
            $scope.process_error = true;
            $('#email').get(0).scrollIntoView();
        }else{
            $scope.user_info    = false;
            $scope.user_photo   = true;
        }
    }

    $scope.register = function () {
        $http({
            method: 'POST',
            url: base_url+'api/register.php',
            data: $scope.data,
            headers: {
              'Content-Type': 'application/json'
            }
          }).then(
            function (response) {
                if(response.data.status == "200"){
                    $scope.member_id = response.data.member_id;
                    $('#member-id').val($scope.member_id);
                    $('#email-confirm-code').val(response.data.email_confirm_code);
                    $('#register-form').submit();
                }
            }
        )
    }

    $scope.validate = function (field) {
        let value = $('#'+field).val();
        if(value == ''){
            $scope.process_error  = true;
            switch(field){
                case 'username':
                    $scope.username_error = true;
                    $scope.username_error_msg = error_messages.A0001+ ' your user name.';
                    break;
                case 'email':
                    $scope.email_error = true;
                    $scope.email_error_msg = error_messages.A0001+ ' your email address.';
                    break;
                case 'password':
                    $scope.password_error = true;
                    $scope.password_error_msg = error_messages.A0001+ ' your password.';
                    break;
                case 'confirm_password':
                    $scope.confirm_password_error = true;
                    $scope.confirm_password_error_msg = error_messages.A0001+ ' your confirm password.';
                    break;
                case 'phone':
                    $scope.phone_error = true;
                    $scope.phone_error_msg = error_messages.A0001+ ' your phone number.';
                    break;
                case 'birthday':
                    $scope.birthday_error = true;
                    $scope.birthday_error_msg = error_messages.A0003+ ' your birthday.';
                    break;
                case 'city':
                    $scope.city_error = true;
                    $scope.city_error_msg = error_messages.A0003+ ' your city.';
                    break;
                case 'hfeet':
                    $scope.hfeet_error = true;
                    $scope.hfeet_error_msg = error_messages.A0003+ ' your height (feet).';
                    break;
                case 'hinches':
                    $scope.hinches_error = true;
                    $scope.hinches_error_msg = error_messages.A0003+ ' your height (inches).';
                    break;
                case 'education':
                    $scope.education_error = true;
                    $scope.education_error_msg = error_messages.A0001+ ' your education level.';
                    break;
                case 'about':
                    $scope.about_error = true;
                    $scope.about_error_msg = error_messages.A0001+ ' something about yourself.';
                    break;
                case 'gender':
                    $scope.gender_error = true;
                    $scope.gender_error_msg = error_messages.A0003+ ' your gender.';
                    break;
                case 'partner-gender':
                    $scope.partner_gender_error = true;
                    $scope.partner_gender_error_msg = error_messages.A0003+ ' your partner gender.';
                    break;
                case 'min-age':
                    $scope.min_age_error = true;
                    $scope.min_age_error_msg = error_messages.A0003+ ' minimum age.';
                    break;
                case 'max-age':
                    $scope.max_age_error = true;
                    $scope.max_age_error_msg = error_messages.A0003+ ' maximum age.';
                    break;
                case 'religion':
                    $scope.religion_error = true;
                    $scope.religion_error_msg = error_messages.A0003+ ' your religion.';
                    break;
                case 'work':
                    $scope.work_error = true;
                    $scope.work_error_msg = error_messages.A0001+ ' your occupation.';
                    break;
                default:
                    break;
            }
        }else{
            switch(field){
                case 'username':
                    $scope.username_error = false;
                    $scope.username_error_msg = '';
                    break;
                case 'email':
                    if(!$scope.emailRegex.test($scope.email)){
                        $scope.process_error  = true;
                        $scope.email_error = true;
                        $scope.email_error_msg = error_messages.A0002;
                    }else{
                        $http.get(base_url+`api/check_email.php?email=${$scope.email}`)
                        .then(
                                function (response) {
                                    if(response.status == '200'){
                                        $scope.email_exist = response.data.email_exist;
                                        if($scope.email_exist){
                                        $scope.process_error  = true;
                                        $scope.email_error = true;
                                        $scope.email_error_msg = error_messages.A0008;
                                        $('#next-btn').prop('disabled',true);
                                        }else{
                                            $scope.email_error = false;
                                            $scope.email_error_msg = '';
                                        }
                                    }
                                }
                            )
                    }
                    
                    break;
                case 'password':
                    if($scope.password.length < 6 ){
                        $scope.process_error  = true;
                        $scope.password_error = true;
                        $scope.password_error_msg = error_messages.A0006;
                    }else if(!$scope.passwordRegex.test($scope.password)){
                        $scope.process_error  = true;
                        $scope.password_error = true;
                        $scope.password_error_msg = error_messages.A0007;
                    }else{
                        $scope.password_error = false;
                        $scope.password_error_msg = '';
                        if($scope.confirm_password != ""){
                            if($scope.password != $scope.confirm_password){
                                $scope.process_error  = true;
                                $scope.confirm_password_error = true;
                                $scope.confirm_password_error_msg = error_messages.A0005;
                            }else{
                                $scope.confirm_password_error = false;
                                $scope.confirm_password_error_msg = '';
                            }
                        }
                    }
                    break;
                case 'confirm_password':
                    let password = $('#password').val();
                    let confirm_password = $('#confirm-password').val();
                    if(password != confirm_password){
                        $scope.process_error  = true;
                        $scope.confirm_password_error = true;
                        $scope.confirm_password_error_msg = error_messages.A0005;
                    }else{
                        $scope.confirm_password_error = false;
                        $scope.confirm_password_error_msg = '';
                    }
                    break;
                case 'phone':
                    $scope.phone_error = false;
                    $scope.phone_error_msg = '';
                    break;
                case 'birthday':
                    let birth_date = new Date($('#birthday').val());
                    let today_date = new Date();
                    let ageDifference = today_date.getFullYear() - birth_date.getFullYear();
                    let monthsDifference = today_date.getMonth() - birth_date.getMonth();
                    if (monthsDifference < 0 || (monthsDifference === 0 && today_date.getDate() < birth_date.getDate())) {
                        ageDifference--;
                    }

                    if (ageDifference >= 18) {
                        $scope.birthday_error = false;
                        $scope.birthday_error_msg = '';
                    } else {
                        $scope.birthday_error = true;
                        $scope.birthday_error_msg = 'You must be at least 18 years old.';
                    }
                    break;
                case 'city':
                    $scope.city_error = false;
                    $scope.city_error_msg = '';
                    break;
                case 'hfeet':
                    $scope.hfeet_error = false;
                    $scope.hfeet_error_msg = '';
                    break;
                case 'hinches':
                    $scope.hinches_error = false;
                    $scope.hinches_error_msg = '';
                    break;
                case 'education':
                    $scope.education_error = false;
                    $scope.education_error_msg = '';
                    break;
                case 'about':
                    $scope.about_error = false;
                    $scope.about_error_msg = '';
                    break;
                case 'gender':
                    $scope.gender_error = false;
                    $scope.gender_error_msg = '';
                    break;
                case 'partner-gender':
                    $scope.partner_gender_error = false;
                    $scope.partner_gender_error_msg = '';
                    break;
                case 'selected-hobbies':
                    $scope.selected_hobbies = [];
                    $("input:checkbox[name='hobbies[]']:checked").each(function(){
                        $scope.selected_hobbies.push($(this).val());
                    });
                    if($scope.selected_hobbies.length <= 0){
                        $scope.process_error  = true;
                        $scope.hobby_error  = true;
                        $scope.hobby_error_msg = error_messages.A0003+ ' at least one hobby.';
                    }else{
                        $scope.hobby_error  = false;
                        $scope.hobby_error_msg = '';
                    }
                    break;
                case 'min-age':
                    $scope.min_age_error = false;
                    $scope.min_age_error_msg = '';
                    break;
                case 'max-age':
                    $scope.max_age_error = false;
                    $scope.max_age_error_msg = '';
                    break;
                case 'partner-gender':
                    $scope.partner_gender_error = false;
                    $scope.partner_gender_error_msg = '';
                    break;
                case 'religion':
                    $scope.religion_error = false;
                    $scope.religion_error_msg = '';
                    break;
                case 'work':
                    $scope.work_error = false;
                    $scope.work_error_msg = '';
                    break;
                default:
                    break;
            }
        }
        
        if($scope.process_error){
            $('#next-btn').prop('disabled',true);
        }else{
            $('#next-btn').prop('disabled',false);
        }
    }
})
    
