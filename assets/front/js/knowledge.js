var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.loading      = false;
    $scope.page         = 1;
    $scope.show_more    = false;
    $scope.posts        = [];
    $scope.post         = {};
    $scope.post_index   = undefined;
    $scope.prev_btn_disabled = true;
    $scope.next_btn_disabled = true;

    $scope.init = function () {
        $scope.syncKnowledge();
    }

    $scope.syncKnowledge = function () {
        $scope.loading = true;
        $http({
            method: 'POST',
            url: base_url+'api/sync_knowledge.php',
            data: {'page' : $scope.page},
            headers: {
              'Content-Type': 'application/json'
            }
        }).then(
            function (response) {
                $scope.loading = false;
                if(response.data.status == "200") {
                    $scope.posts = $scope.posts.concat(response.data.data);
                    $scope.show_more = response.data.show_more;
                }
            }
        )
    }

    $scope.loadMore = function () {
        $scope.page++;
        $scope.syncKnowledge();
    }

    $scope.showPostDetails = function (index) {
        $scope.post = $scope.posts[index];
        $scope.post_index = index;
        
        if($scope.post_index <= 0) {
            $scope.prev_btn_disabled = true;
        }else{
            $scope.prev_btn_disabled = false;
        }

        if($scope.post_index >= $scope.posts.length - 1) {
            $scope.next_btn_disabled = true;
        }else{
            $scope.next_btn_disabled = false;
        }

        $('#knowledge-content').scrollTop(0);
        $("#knowledge-content").css("z-index", 5);
        $('#post-details').removeClass('opacity-0');
        $("#post-details").css({
            "z-index": 10,
            "background-color": "rgba(0, 0, 0, 0.5)"
        });
    }

    $scope.cancelPost = function () {
        const postDetails   = document.querySelector('#post-details');
        const knowledgeContent   = document.querySelector('#knowledge-content');
        const post          = document.getElementById('post-' + $scope.post_index);
        postDetails.classList.add('opacity-0');
        post.scrollIntoView({ behavior: 'smooth', block: 'start' });
        postDetails.style.zIndex = '-10';
        knowledgeContent.style.zIndex = '10';
        postDetails.style.backgroundColor = "";
    }

    $scope.showPrevPost = function (index) {
        if(index-1 >= 0){
            $scope.post_index = index - 1 ;
            $scope.showPostDetails($scope.post_index);
        }
    }

    $scope.showNextPost = function (index) {
       if(index+1 < $scope.posts.length){
            $scope.post_index = index + 1 ;
            $scope.showPostDetails($scope.post_index);
       }
    }
});