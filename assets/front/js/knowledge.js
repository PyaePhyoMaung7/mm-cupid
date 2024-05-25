var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.loading          = false;
    $scope.page             = 1;
    $scope.members          = [];

    $scope.init = function () {
        $scope.syncMember();
    }

    $scope.syncMember = function () {
        $scope.loading = true;
        const data = $scope.is_filtered ? {'page' : $scope.page, 'partner_gender' : $scope.partner_gender, 'min_age' : $scope.min_age, 'max_age' : $scope.max_age } : {'page' : $scope.page} ;
        $http({
            method: 'POST',
            url: base_url+'api/sync_members.php',
            data: data,
            headers: {
              'Content-Type': 'application/json'
            }
        }).then(
            function (response) {
                $scope.loading = false;
                console.log(response);
                if(response.data.status == "200") {
                    $scope.members = $scope.members.concat(response.data.data);
                    $scope.show_more = response.data.show_more;
                }
            }
        )
    }
});