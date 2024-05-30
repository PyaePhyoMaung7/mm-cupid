var app = angular.module("myApp", []);

app.controller('myCtrl', function($scope, $http, $timeout, $window){
    $scope.members = [];
    $scope.member  = [];
    $scope.member_index = undefined;
    $scope.member_image_index = undefined;
    $scope.page = 1;
    $scope.loading = false;
    $scope.first_name = '';
    $scope.image_arr = [];
    $scope.all_images = [];
    $scope.show_more = true;
    $scope.is_filtered = false;
    $scope.next_btn_disabled = false;
    $scope.prev_btn_disabled = false;
    $scope.partner_gender = partner_gender;
    $scope.partner_gender_name = gender_type[$scope.partner_gender];
    $scope.min_age  = partner_min_age;
    $scope.max_age = partner_max_age;
    $scope.age_limit = '';
    $scope.min_ages = [];
    $scope.max_ages = [];

    for (let i = 18; i <= $scope.max_age; i++) {
        $scope.min_ages.push(i);
    }

    for (let i = $scope.min_age; i <= 55; i++) {
        $scope.max_ages.push(i);
    }

    $scope.init = function () {
        $scope.syncMember();
        $scope.checkedGender();
        $scope.changeAgeLimit();
    }

    $scope.loadMore = function () {
        $scope.page++;
        $scope.syncMember();
    }

    $scope.syncMember = function () {
        $('.loading').show();
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
                if(response.data.status == "200") {
                    $scope.members = $scope.members.concat(response.data.data);
                    $scope.show_more = response.data.show_more;
                    $('.loading').hide();
                }
            }
        )
    }

    $scope.updateViewCount = function (id) {
        const data = {'id' : id};
        $http({
            method: 'POST',
            url: base_url+'api/update_view_count.php',
            data: data,
            headers: {
              'Content-Type': 'application/json'
            }
        }).then(
            function (response) {
                console.log(response);
            }
        );
    };

    $scope.showMemberProfile = function (index) {
        $scope.all_images = [];
        $scope.member = $scope.members[index];

        $timeout.cancel($scope.timer);
        $scope.timer = $timeout( function () {
            $scope.updateViewCount($scope.member.id)
        }, 2000);

        $scope.member_index = index;
        
        if($scope.member_index <= 0) {
            $scope.prev_btn_disabled = true;
        }else{
            $scope.prev_btn_disabled = false;
        }

        if($scope.member_index >= $scope.members.length - 1) {
            $scope.next_btn_disabled = true;
        }else{
            $scope.next_btn_disabled = false;
        }

        if($scope.member.images.length <= 0) {
            let image = {};
            image.sort  = 1;
            image.image = $scope.member.gender == 'male' ? base_url + 'assets/default_images/default_male.jpg' : base_url + 'assets/default_images/default_female.webp';
            $scope.image_arr = [image];
        }else{
            $scope.image_arr = $scope.member.images;
        }
        $scope.first_name = $scope.member.username.split(' ')[0];

        $scope.all_images = [];
        for (let i = 0; i < $scope.image_arr.length; i++) {
            $scope.all_images.push($scope.image_arr[i].image);
        }

        $('#profile-content').scrollTop(0);
        $("#image-content").css("z-index", 5);
        $('#member-profile').removeClass('opacity-0');
        $("#member-profile").css({
            "z-index": 10,
            "background-color": "rgba(0, 0, 0, 0.5)"
        });
        $(".carousel-inner").html("");
        
    }

    $scope.showPrevProfile = function (index) {
        if(index-1 >= 0){
            $scope.member_index = index - 1 ;
            $scope.showMemberProfile($scope.member_index);
        }
    }

    $scope.showNextProfile = function (index) {
       if(index+1 < $scope.members.length){
            $scope.member_index = index + 1 ;
            $scope.showMemberProfile($scope.member_index);
       }
    }

    $scope.cancelProfile = function () {
        const profile           = document.querySelector('#member-profile');
        const imageContent      = document.querySelector('#image-content');
        const member_profile    = document.getElementById('profile-' + $scope.member_index);
        profile.classList.add('opacity-0');
        member_profile.scrollIntoView({ behavior: 'smooth', block: 'start' });
        profile.style.zIndex = '-10';
        imageContent.style.zIndex = '10';
        profile.style.backgroundColor = "";
    }

    $scope.stopImageView = function () {
        const body              = document.querySelector('body');
        const getCarousel       = document.querySelector(".carousel-inner");
        const carouselWrapper   = document.querySelector("#carousel-wrapper");

        body.classList.remove('overflow-hidden');
        body.classList.add('overflow-x-hidden');
        carouselWrapper.style.zIndex = -20;
        getCarousel.innerHTML = '';
        carouselWrapper.classList.add('opacity-0');
    }

    $scope.showCarousel = function (index, src) {
        
        const getCarousel       = document.querySelector(".carousel-inner");
        const currentPage       = document.querySelector("#current-page");
        const carouselWrapper   = document.querySelector("#carousel-wrapper");
        const profileImages     = document.querySelectorAll(".profile-image");
        const body              = document.querySelector('body');

        $scope.member_image_index = index;
        if($scope.member_image_index <= 0 ){
            $("#carousel-prev-btn").addClass('d-none');
            $("#carousel-prev-btn").prop('disabled', true);
        }else{
            $("#carousel-prev-btn").removeClass('d-none');
            $("#carousel-prev-btn").prop('disabled', false);
        }

        if($scope.member_image_index >= $scope.image_arr.length - 1 ){
            $("#carousel-next-btn").addClass('d-none');
            $("#carousel-next-btn").prop('disabled', true);
        }else{
            $("#carousel-next-btn").removeClass('d-none');
            $("#carousel-next-btn").prop('disabled', false);
        }

        carouselWrapper.style.zIndex = '20';
        carouselWrapper.classList.remove('opacity-0');
        for (let x = 0; x < profileImages.length; x++) {
            let img = document.createElement('img');
            let div = document.createElement('div');
            if (x == 0) {
                div.className = "carousel-item active";
                img.src = src;
                console.log(src);
                currentPage.innerHTML = $scope.member_image_index +1 + ' of '+ $scope.all_images.length;
            } else {
                div.className = "carousel-item";
                let indexOf = index;
                indexOf += x;
                if (indexOf >= $scope.all_images.length) {
                    indexOf = indexOf - $scope.all_images.length;
                };

                img.src = $scope.all_images[indexOf];
                console.log($scope.all_images[indexOf]);
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
        const currentPage       = document.querySelector("#current-page");
        
        if(btn == 'next') {
            if($scope.member_image_index + 1 < $scope.image_arr.length){
                $scope.member_image_index++;
                const src = $scope.all_images[$scope.member_image_index];
                $scope.showCarousel($scope.member_image_index, src);
            }
        }else{
            if($scope.member_image_index - 1 >= 0){
                $scope.member_image_index--;
                const src = $scope.all_images[$scope.member_image_index];
                $scope.showCarousel($scope.member_image_index, src);
            }
        }

        currentPage.innerHTML = $scope.member_image_index+1 + ' of '+ $scope.image_arr.length;
    }

    $scope.filterGender = function () {
        $scope.partner_gender = $("input[name='gender']:checked").val();
        $scope.partner_gender_name = gender_type[$scope.partner_gender];
        $scope.backSearchOffcanvas();
    }

    $scope.filterAge = function () {
        $scope.min_age = $('#min-age').val();
        $scope.max_age = $('#max-age').val();
        $scope.changeAgeLimit();
        $scope.backSearchOffcanvas();
    }

    $scope.changeAgeLimit = function () {
        $scope.age_limit = $scope.min_age == '' ? 'any' : $scope.min_age;
        $scope.age_limit += '-';
        $scope.age_limit += $scope.max_age == '' ? 'any' : $scope.max_age;
    }

    $scope.backSearchOffcanvas = function () {
        $('#offcanvas-search-btn').click();
    }

    $scope.checkedGender = function () {
        switch($scope.partner_gender){
            case '0':
                $('#gender-man').attr('checked',true);
                break;
            case '1':
                $('#gender-woman').attr('checked',true);
                break;
            default:
                $('#gender-every').attr('checked',true);
        }
    }

    $scope.applyFilter = function () {
        $scope.page = 1;
        $scope.is_filtered = true;
        $scope.members = [];
        $scope.syncMember();
        $scope.backSearchOffcanvas();
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

    $scope.dateRequest = function (id) {
        const data = {'id' : id};
        $('.loading').show();
        $http({
            method: 'POST',
            url: base_url+'api/invite_date.php',
            data: data,
            headers: {
              'Content-Type': 'application/json'
            }
        }).then(
            function (response) {
                console.log(response);
                if (response.data.status == '200') {
                    const point          = response.data.data.point; 
                    const success_code   = response.data.data.success;
                    $('#point').text(point);
                    $('.loading').hide();
                   new PNotify({
                        title: 'Success!',
                        width: '400px',
                        addclass: 'pnotify-center',
                        text: success_messages[success_code],
                        type: 'success',
                        styling: 'bootstrap3'
                    });

                } else {
                    const error_code = response.data.data.error;
                    $('.loading').hide();
                    new PNotify({
                        title: 'Fail!',
                        width: '400px',
                        addclass: 'pnotify-center',
                        text: error_messages[error_code],
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }

            }
        );
    }

})