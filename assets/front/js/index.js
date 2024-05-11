var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.members = [];
    $scope.page = 1;
    $scope.data = 
    $scope.init = function () {
        $scope.syncMember();
    }

    $scope.loadMore = function () {
        $scope.page++;
        $scope.syncMember();
    }

    $scope.syncMember = function () {
        $http({
            method: 'POST',
            url: base_url+'api/sync_member.php',
            data: { 'page' : $scope.page },
            headers: {
              'Content-Type': 'application/json'
            }
        }).then(
            function (response) {
                if(response.data.status == "200") {
                   $scope.members = $scope.members.concat(response.data.data);
                   if(!response.data.more_member_exist){
                        $('#load-more-btn').hide();
                   }else{
                        $('#load-more-btn').show();
                   }
                }
            }
        )
    }

    $scope.showMemberProfile = function (id) {
        $("#image-content").css("z-index", 5);
        $("#member-profile").css({
            "z-index": 10,
            "background-color": "rgba(0, 0, 0, 0.5)"
        });
        $(".carousel-inner").html("");
    }

    $scope.cancelProfile = function () {
        const profile           = document.querySelector('#member-profile');
        const imageContent      = document.querySelector('#image-content');
        profile.style.zIndex = '-10';
        imageContent.style.zIndex = '10';
        profile.style.backgroundColor = "";
    }

})