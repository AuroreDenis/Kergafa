// JavaScript Document


(function ($, Drupal, drupalSettings) {

    "use strict";

    Drupal.behaviors.swiper = {
        attach: function (context, settings) {

            //console.log(settings);
            //console.log(drupalSettings);

            var swiper = new Swiper('.view-slider-accueil.swiper-container', {
                direction: 'horizontal',
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                paginationClickable: true,
                slidesPerView: 1,
                spaceBetween: 0,
                autoplay: 7000,
                speed: 1000,
                autoHeight: false,
                loop: true
            });

            var swipeReal2 = new Swiper(".swiperReal2 .swiper-container", {
                direction: 'horizontal',
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                paginationClickable: true,
                slidesPerView: 5,
                spaceBetween: 0,
                autoplay: 7000,
                speed: 1000,
                autoHeight: false,
            });

            var swipeReal = new Swiper(".swiperReal .swiper-container", {
                direction: 'horizontal',
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                paginationClickable: true,
                slidesPerView: 1,
                spaceBetween: 0,
                autoplay: 7000,
                speed: 1000,
                autoHeight: false,
                loop: true,
                thumbs: {
                    swiper: swipeReal2
                }
            });
        }
    };

})(jQuery, Drupal, drupalSettings);