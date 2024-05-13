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
