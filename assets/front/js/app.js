const getCarousel       = document.querySelector(".carousel-inner");
const getImages         = document.querySelectorAll(".image");
const profileImages     = document.querySelectorAll(".profile-image");
const imageArr          = ["image1.webp", "image2.webp","image3.webp"];
const carouselWrapper   = document.querySelector("#carousel-wrapper");
const imageContent      = document.querySelector('#image-content');
const profile           = document.querySelector('#member-profile');
const currentPage       = document.querySelector("#current-page");
const body              = document.querySelector('body');
const footer            = document.querySelector('footer');
const getProfile        = document.getElementById('profile-content');
const getScrollBar      = document.getElementById('profile-scroll-bar-value');

getImages.forEach((element, index) => {
    element.addEventListener('click', function (e) {
        imageContent.style.zIndex = '5';
        getCarousel.innerHTML = '';
        profile.style.zIndex = '10';
    })
});

profileImages.forEach((element,index) => {
    element.addEventListener('click', function (e) {
    carouselWrapper.style.zIndex = '20';
    carouselWrapper.classList.remove('opacity-0');
    for (let x = 0; x < profileImages.length; x++) {
        let img = document.createElement('img');
        let div = document.createElement('div');
        if (x == 0) {
            div.className = "carousel-item active";
            img.src = e.target.src;
            currentPage.innerHTML = index+1 + ' of '+ imageArr.length;
        } else {
            div.className = "carousel-item";
            let filePathArr = e.target.src.split("/");
            let fileName = filePathArr[filePathArr.length - 1];
            let indexOf = index;
            indexOf += x;
            if (indexOf >= imageArr.length) {
                indexOf = indexOf - imageArr.length;
            };
            filePathArr = e.target.src.replace(fileName, imageArr[indexOf]);
            img.src = filePathArr;

        }
        img.className = "d-block vh-100 object-fit-cover w-100";
        img.alt = "profile-photo";
        img.style.width = "10%";
        div.appendChild(img);
        getCarousel.appendChild(div);
        body.classList.remove('overflow-x-hidden');
        body.classList.add('overflow-hidden');
        }
    })
})

let displayCurrentPage = (btn) => {
    let activeCarouselItem = document.querySelector('.carousel-item.active');
    let image = activeCarouselItem.querySelector('img');
    let imageSrc = image.getAttribute('src');
    let imageSrcArray = imageSrc.split('/');
    let imageName = imageSrcArray[imageSrcArray.length-1];
    let currentImageIndex = imageArr.indexOf(imageName);
    
    btn == 'next' ? currentImageIndex++ : currentImageIndex--;
    if(currentImageIndex >= imageArr.length){
        currentImageIndex = 0;
    }else if( currentImageIndex < 0 ){
        currentImageIndex = imageArr.length-1;
    }
    currentPage.innerHTML = currentImageIndex+1 + ' of '+ imageArr.length;
}

let stopImageView = () => {
    body.classList.remove('overflow-hidden');
    body.classList.add('overflow-x-hidden');
    carouselWrapper.style.zIndex = -20;
    getCarousel.innerHTML = '';
    carouselWrapper.classList.add('opacity-0');
}

let cancelProfile = () => {
    profile.style.zIndex = '-10';
    imageContent.style.zIndex = '10';
    profile.style.backgroundColor = "";
}

getProfile.addEventListener('scroll',function(e){
    let percent = Math.round((getProfile.scrollTop/(getProfile.scrollHeight-getProfile.clientHeight))*100);
    percent     = percent * 3/4;
    getScrollBar.style.top = `${percent}%`;
})
