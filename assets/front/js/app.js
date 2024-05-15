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
// const getProfile        = document.getElementById('profile-content');
// const getScrollBar      = document.getElementById('profile-scroll-bar-value');



// getProfile.addEventListener('scroll',function(e){
//     let percent = Math.round((getProfile.scrollTop/(getProfile.scrollHeight-getProfile.clientHeight))*100);
//     percent     = percent * 3/4;
//     getScrollBar.style.top = `${percent}%`;
// })
