var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.member           = {};
    $scope.member_images    = [];
    $scope.cities           = [];
    $scope.hobbies          = [];
    $scope.selectedHobbies  = ['1','3','5'];
    $scope.loading          = false;
    $scope.min_ages         = [];
    $scope.max_ages         = [];
    
    $scope.init = function () {
        const data = {};
        $http({
            method: 'POST',
            url: base_url+'api/sync_login_member.php',
            data: data,
            headers: {
              'Content-Type': 'application/json'
            }
        }).then(
            function (response) {
                $scope.loading = false;
                console.log(response);
                if(response.data.status == "200") {
                    $scope.member = response.data.data;
                    $scope.bindImages($scope.member.images);
                    $scope.getCities();
                    $scope.getHobbies();

                    for (let i = 18; i <= $scope.member.partner_max_age; i++) {
                        $scope.min_ages.push(i);
                    }
                    
                
                    for (let i = $scope.member.partner_min_age; i <= 55; i++) {
                        $scope.max_ages.push(i);
                    }
                }
            }
        )
    }

    $scope.update = function () {
       console.log($scope.member);
    }

    $scope.bindImages = function (images) {
        images.forEach(image => {
            $('#preview'+image.sort).html(`<img src= ${image.image} class="" style="width: 100%; height: 100%; object-fit: cover" alt="Image Preview"/>`);
            $('#upload-icon-'+image.sort).hide();
            $('.change-photo'+image.sort).show();
            $('#preview'+image.sort).removeClass('d-none');
        });
    }

    $scope.bindInfo = function () {
        $scope.member.city_id += '';
        $scope.member.hfeet += '';
        $scope.member.hinches += '';

        $scope.hobbies.forEach(hobby => {
            if($scope.selectedHobbies.includes(hobby.id)) {
                $('#hobby-'+hobby.id).prop("checked",true);
            }
        })
        
        $scope.member.partner_min_age += '';
        $scope.member.partner_max_age += '';

        $scope.member.religion += '';
        $scope.member.gender += '';
        $scope.member.partner_gender += '';
    }

    $scope.backUserProfile = function () {
        $('#user-profile-btn').click();
    }

    $scope.getCities = function () {
        $http({
            method: 'GET',
            url: base_url+'api/get_cities.php',
        }).then(
            function (response) {
                $scope.cities = response.data;
            }
        )
    }

    $scope.getHobbies = function () {
        $http({
            method: 'GET',
            url: base_url+'api/get_hobbies.php',
        }).then(
            function (response) {
                $scope.hobbies = response.data;
            }
        )
    }

    $scope.chooseMinAge = function () {
        console.log($scope.min_age);
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
    }

    $scope.chooseMaxAge = function () {
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
    }
});