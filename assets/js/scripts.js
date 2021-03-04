'use strict';

//Плавная прокрутка страницы вверх
window.addEventListener('scroll', function() {
  const scrollHeight = Math.round(window.scrollY);
  if (scrollHeight < 300) document.querySelector('.go-top').style.opacity = '0';
  else document.getElementsByClassName('go-top')[0].style.opacity = '1';
});

function backToTop() {
  if (window.pageYOffset > 0) {
    window.scrollBy(0, -10);
    setTimeout(backToTop, 0);
  }
}
document.querySelector('.go-top').addEventListener('click', function() {
  backToTop();
});

if (document.querySelector('.hero-post')) {
  const topSwiper = new Swiper('.hero-slider', { //jshint ignore:line
    // Optional parameters
    speed: 700,
    spaceBetween: 30,
    loop: true,
    navigation: {
      prevEl: '.swiper-button-next',
      nextEl: '.swiper-button-prev',
    },
  });

  const allNum = document.querySelectorAll('.article-post').length - 2;
  const slideNumArea = document.querySelector('.swiper-num-area');
  const slideNum = document.querySelector('.swiper-slide-active');
  slideNumArea.innerHTML = slideNum.getAttribute('data-num') + ' / ' + allNum;

  topSwiper.on('slideChange', function() {
    setTimeout(function() {
      let slideNumArea = document.querySelector('.swiper-num-area');
      let slideNum = document.querySelector('.swiper-slide-active');
      slideNumArea.innerHTML = slideNum.getAttribute('data-num') + ' / ' + allNum;
    }, 10);
  });
}

if (document.querySelector('.programs-post')) {
  const progSwiper = new Swiper('.programs-slider', { //jshint ignore:line
    // Optional parameters
    speed: 700,
    spaceBetween: 30,
    loop: true,
    navigation: {
      prevEl: '.swiper-button-next',
      nextEl: '.swiper-button-prev',
    },
  });

  const progAllNum = document.querySelectorAll('.programs-article-post').length - 2;
  const progSlideNumArea = document.querySelector('.programs-slider .swiper-num-area');
  const progSlideNum = document.querySelector('.programs-slider .swiper-slide-active');
  progSlideNumArea.innerHTML = progSlideNum.getAttribute('data-num') + ' / ' + progAllNum;

  progSwiper.on('slideChange', function() {
    setTimeout(function() {
      let progSlideNumArea = document.querySelector('.programs-slider .swiper-num-area');
      let progSlideNum = document.querySelector('.programs-slider .swiper-slide-active');
      progSlideNumArea.innerHTML = progSlideNum.getAttribute('data-num') + ' / ' + progAllNum;
    }, 10);
  });
}

const menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function(event) {
  event.preventDefault();
  $('.header-nav').slideToggle(200);
});

const contactsForm = $('.contacts-form');

contactsForm.on('submit', function(event) {
  event.preventDefault();
  let formData = new FormData(this);
  formData.append('action', 'contacts_form');
  $.ajax({
    type: "POST",
    url: adminAjax.url, //jshint ignore:line
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
      console.log('Ответ сервера: ' + response);
    }
  });
});
