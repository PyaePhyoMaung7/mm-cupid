var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $window){
    $scope.members = [];
    $scope.member  = [];
    $scope.member_ids = [];
    $scope.page = 1;
    $scope.first_name = '';
    $scope.image_arr = [];
    $scope.all_images = [];
    $scope.show_more = true;
    $scope.next_btn_disabled = false;
    $scope.prev_btn_disabled = false;
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
                    $scope.member_ids = [];
                    $scope.members.forEach(member => {
                        $scope.member_ids.push(member.id);
                    });
                    console.log($scope.member_ids);
                    $scope.show_more = response.data.show_more;
                }
            }
        )
    }

    $scope.showMemberProfile = function (id) {
        console.log(id);
        $scope.all_images = [];
        $scope.member = $scope.members.filter(member => member.id === id);
        $scope.next_member = $scope.members.filter(member => member.id === id+1);
        $scope.prev_member = $scope.members.filter(member => member.id === id-1);

        if($scope.next_member.length <= 0){
            console.log('loadmore');
            $scope.loadMore();
        }
        if($scope.prev_member.length <= 0) {
            $scope.prev_btn_disabled = true;
        }else{
            $scope.prev_btn_disabled = false;
        }

        $scope.image_arr = $scope.member[0].images;
        $scope.first_name = $scope.member[0].username.split(' ')[0];

        $scope.all_images = [];
        for (let i = 0; i < $scope.image_arr.length; i++) {
            $scope.all_images.push($scope.image_arr[i].image);
        }

        $('#profile-content').scrollTop(0);
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

    $scope.showCarousel = function (index, e) {
        const getCarousel       = document.querySelector(".carousel-inner");
        const currentPage       = document.querySelector("#current-page");
        const carouselWrapper   = document.querySelector("#carousel-wrapper");
        const profileImages     = document.querySelectorAll(".profile-image");

        let currentImageIndex = $scope.all_images.indexOf(e.target.src);

        carouselWrapper.style.zIndex = '20';
        carouselWrapper.classList.remove('opacity-0');
        for (let x = 0; x < profileImages.length; x++) {
            let img = document.createElement('img');
            let div = document.createElement('div');
            if (x == 0) {
                div.className = "carousel-item active";
                img.src = e.target.src;
                currentPage.innerHTML = currentImageIndex +1 + ' of '+ $scope.all_images.length;
            } else {
                div.className = "carousel-item";
                let image_path = e.target.src;
                let indexOf = index;
                indexOf += x;
                if (indexOf >= $scope.all_images.length) {
                    indexOf = indexOf - $scope.all_images.length;
                };
                image_path = e.target.src.replace(image_path, $scope.all_images[indexOf]);
                img.src = image_path;
            }
            img.className = "d-block vh-100 object-fit-cover w-100";
            img.alt = "profile-photo";
            img.style.width = "10%";
            div.appendChild(img);
            getCarousel.appendChild(div);
            body.classList.remove('overflow-x-hidden');
            body.classList.add('overflow-hidden');
        }
    }

    $scope.displayCurrentPage = (btn) => {
        let activeCarouselItem = document.querySelector('.carousel-item.active');
        let image = activeCarouselItem.querySelector('img');
        let imageSrc = image.getAttribute('src');
        let currentImageIndex = $scope.all_images.indexOf(imageSrc);
        btn == 'next' ? currentImageIndex++ : currentImageIndex--;
        if(currentImageIndex >= $scope.all_images.length){
            currentImageIndex = 0;
        }else if( currentImageIndex < 0 ){
            currentImageIndex = imageArr.length-1;
        }
        currentPage.innerHTML = currentImageIndex+1 + ' of '+ $scope.image_arr.length;
    }

})