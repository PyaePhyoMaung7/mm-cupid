var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.member = {};
    $scope.member_images = [];
    $scope.loading = false;
    
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
                    $scope.bindInfo();
                }
            }
        )
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
        $scope.username = $scope.member.username;
        $scope.phone    = $scope.member.phone;
        $scope.birthday = $scope.member.birthday;
        $scope.city     = $scope.member.city_id;
        $scope.hfeet    = $scope.member.hfeet;
        $scope.hinches  = $scope.member.hinches;
        $scope.education= $scope.member.education;
        $scope.about    = $scope.member.about; 
        $scope.work = $scope.member.work;
        $scope.gender = $scope.member.gender;
        $scope.partner_gender = $scope.member.partner_gender;
        $scope.partner_min_age = $scope.member.partner_min_age;
        $scope.partner_max_age = $scope.member.partner_max_age;
        $scope.religion = $scope.member.religion;
    }

    $scope.backUserProfile = function () {
        $('#user-profile-btn').click();
    }
});