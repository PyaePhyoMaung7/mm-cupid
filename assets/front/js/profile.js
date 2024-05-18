var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.member = {};
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
                }
            }
        )
    }
});