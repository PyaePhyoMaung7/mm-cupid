var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.loading          = false;
});