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
                if(response.data.status == "200") {
                    $scope.member = response.data.data;
                    $scope.member_images = response.data.data.images;
                    $scope.showProfileImages($scope.member_images);
                }
            }
        )
    }

    $scope.showProfileImages = function (images) {
        images.forEach(image => {
            $('#preview'+image.sort).html(`<img src= ${image.image} class="" style="width: 100%; height: 100%; object-fit: cover" alt="Image Preview"/>`);
            $('#upload-icon-'+image.sort).hide();
            $('.change-photo'+image.sort).show();
            $('#preview'+image.sort).removeClass('d-none');
        });
    }
});