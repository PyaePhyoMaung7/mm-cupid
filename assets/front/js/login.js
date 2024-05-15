var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http){
    $scope.process_error = true;
    $scope.email_error = false;
    $scope.email_error_message = '';

    $scope.password_error = false;
    $scope.password_error_message = '';

    $scope.emailRegex       = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    $scope.init = function () {
        $scope.email = $('#email').val();
        $scope.password = $('#password').val();
        $scope.checkValidation();
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

    $scope.checkValidation = function () {
        $scope.process_error = false;
        $scope.email = $('#email').val();
        $scope.password = $('#password').val();

        if($scope.email == ""){
            $scope.process_error = true;
        }
        if($scope.password == ""){
            $scope.process_error = true;
        }

    }

    $scope.validate = function (field) {
        let value = $('#'+field).val();
        if(value == ''){
            $scope.process_error  = true;
            switch(field){
                case 'email':
                    $scope.email_error = true;
                    $scope.email_error_msg = error_messages.A0001+ ' your email address.';
                    break;
                case 'password':
                    $scope.password_error = true;
                    $scope.password_error_msg = error_messages.A0001+ ' your password.';
                    break;
                default:
                    break;
            }   
        }else{
            switch(field){
                case 'email':
                    if(!$scope.emailRegex.test($scope.email)){
                        $scope.email_error = true;
                        $scope.email_error_msg = error_messages.A0002;
                    }else{
                        $scope.email_error = false;
                        $scope.email_error_msg = '';
                    }
                    break;
                case 'password':
                    $scope.password_error = false;
                    $scope.password_error_msg = '';
                    break;
                default:
                    break;
            }   
        }
    }

    $scope.login = function () {
        $('#login-form').submit();
    }

    $scope.tryLogin = function (event) {
        if(event.which == 13){
            $scope.login();
        }
    }

});