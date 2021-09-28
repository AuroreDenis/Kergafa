(function ($) {
    Drupal.behaviors.fonctions = {
        attach: function (context, settings) {

            $(context).find('body').once('load').each(function (index, element) {

                //Click catégories actus
                $('.theme-actu .cb input').unbind('click').on('click', function (e) {
                    var data_categ = $(this).parent().attr('data-categorie');

                    if ($(this).parent().hasClass('cb-tous') && $(this).parent().hasClass('active')) {
                        $(this).parent().removeClass('active');
                    } else if ($(this).parent().hasClass('cb-tous') && !$(this).parent().hasClass('active')) {
                        $('.theme-actu input').prop('checked', 'checked');
                        $('.actu-page').show();
                        $('.theme-actu .cb').addClass('active');
                    } else {
                        if ($(this).parent().hasClass('active')) {
                            $('.theme-actu .cb.cb-tous').removeClass('active');
                            $('.theme-actu .cb.cb-tous input').prop('checked', false);
                            $('.actu-page.' + data_categ).hide();
                            $(this).parent().removeClass('active');
                        } else {
                            if (!$('.theme-actu .cb.cb-tous').hasClass('active') && $('.theme-actu .cb.active').length === 3) {
                                $('.actu-page').show();
                                $('.theme-actu input').prop('checked', 'checked');
                                $('.theme-actu input').prop('checked', 'checked');
                            }
                            $('.actu-page.' + data_categ).show();
                            $(this).parent().addClass('active');
                        }
                        e.stopPropagation();
                    }

                });

                var didScroll;
                var lastScrollTop = 0;
                var delta = 5;
                var navbarHeight = $('header').outerHeight();

                setInterval(function () {
                    if (didScroll) {
                        hasScrolled();
                        didScroll = false;
                    }
                }, 250);

                function hasScrolled() {
                    var st = $(this).scrollTop();

                    if (Math.abs(lastScrollTop - st) <= delta)
                        return;
                    if (st > lastScrollTop && st > navbarHeight) {
                        $('header').removeClass('nav-down').addClass('nav-up');
                    } else {
                        if (st + $(window).height() < $(document).height()) {
                            $('header').removeClass('nav-up').addClass('nav-down');
                        }
                    }

                    lastScrollTop = st;
                }

                $(window).scroll(function (e) {

                    didScroll = true;

                    if ($(this).scrollTop() >= "200") {
                        if (!$("header").hasClass("sticky-desktop")) {
                            $("header").addClass("sticky-desktop");
                        }
                        if (!$("body").hasClass("padding-topped")) {
                            $("body").addClass("padding-topped");
                        }

                    } else {
                        $("header").removeClass("sticky-desktop");
                        $("body").removeClass("padding-topped");
                    }

                    if ($(this).scrollTop() >= "201") {
                        if (!$("header").hasClass("open")) {
                            $("header").addClass("open");
                        }
                    } else {
                        $("header").removeClass("open");
                    }


                });

                $(document).ready(function () {
                    //Sticky Desktop
                    if ($(this).scrollTop() >= "125") {
                        if (!$("header").hasClass("sticky-desktop")) {
                            $("header").addClass("sticky-desktop");
                        }
                        if (!$("body").hasClass("padding-topped")) {
                            $("body").addClass("padding-topped");
                        }

                    } else {
                        $("header").removeClass("sticky-desktop");
                        $("body").removeClass("padding-topped");
                    }

                    if ($(this).scrollTop() >= "126") {
                        if (!$("header").hasClass("open")) {
                            $("header").addClass("open");
                        }
                    } else {
                        $("header").removeClass("open");
                    }
                });

                //Initialisation Animate On Scroll
//                AOS.init();

                //Smooth scroll sur les ancres
                $('.js-scrollTo').on('click', function () {
                    var page = $(this).attr('href');
                    var speed = 750;
                    $('html, body').animate({scrollTop: $(page).offset().top}, speed);
                    return false;
                });

                /* Focus formulaire material design */
                $('#block-contactblock input, #block-contactblock select, #block-contactblock textarea').focus(function () {
                    $(this).parent().addClass('hasText');
                });

                // blur event..
                $('#block-contactblock input, #block-contactblock select, #block-contactblock textarea').blur(function () {
                    if ($(this).val() === '') {
                        $(this).parent().removeClass('hasText');
                    }
                });

                //Map OSM Footer
                if ($('#blockMap').length) {

                    var myMap = L.map('blockMap', {
                        center: [47.6614765, -2.8627722],
                        zoom: 13,
                        scrollWheelZoom: false
                    });

                    var markerPinPoint = L.icon({
                        iconUrl: "/themes/theme_dupliquer_theme/images/svg/marker-map.svg",
                        iconSize: [29, 40],
                        iconAnchor: [35, 78],
                        popupAnchor: [-20, -80]
                    });

                    var popup_content = '<div class="info-bulle">'
                    popup_content += '<div class="titre">' + 'Grouplive' + '</div>';
                    popup_content += '<div class="adresse">' + '4, route de Pliant' + '</div>';
                    popup_content += '<div class="cp-ville">' + '56880' + ' ' + 'Ploeren' + '</div>';
                    popup_content += '<div class="telephone">' + '02 97 63 24 64' + '</div>';
                    popup_content += '</div>';

                    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        maxZoom: 17,
                        scrollWheelZoom: false,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(myMap);
                    var marker = L.marker([47.6614765, -2.8627722], {icon: markerPinPoint}).addTo(myMap);
                    marker.bindPopup(popup_content);
                }

                //Fancybox custom
                if ($('[data-fancybox]').length > 0) {
                    $('[data-fancybox]').fancybox({
                        loop: false,
                        thumbs: {
                            showOnStart: true
                        },
                        titleShow: true
                    });
                }

                //ACCORDEON
                $('.para-item-accordeon .titre-elem').click(function () {
                    if ($(this).next().css('overflow') === 'hidden') {
                        $(this).addClass('active');
                        $(this).next().addClass('active');
                    } else {
                        $(this).removeClass('active');
                        $(this).next().removeClass('active');
                    }
                });

                tarteaucitron.init({
                    "privacyUrl": "", /* Privacy policy url */

                    "hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
                    "cookieName": "tarteaucitron", /* Cookie name */

                    "orientation": "bottom", /* Banner position (top - bottom) */

                    "showAlertSmall": false, /* Show the small banner on bottom right */
                    "cookieslist": false, /* Show the cookie list */

                    "showIcon": false, /* Show cookie icon to manage cookies */
                    "iconPosition": "BottomRight", /* BottomRight, BottomLeft, TopRight and TopLeft */

                    "adblocker": false, /* Show a Warning if an adblocker is detected */

                    "DenyAllCta": false, /* Show the deny all button */
                    "AcceptAllCta": true, /* Show the accept all button when highPrivacy on */
                    "highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */

                    "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

                    "removeCredit": true, /* Remove credit link */
                    "moreInfoLink": true, /* Show more info link */

                    "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
                    "useExternalJs": false, /* If false, the tarteaucitron.js file will be loaded */

                    //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */

                    "readmoreLink": "", /* Change the default readmore link */

                    "mandatory": true, /* Show a message about mandatory cookies */
                });

                if (settings.code_analytics_ga) {
                    tarteaucitron.user.gajsUa = settings.code_analytics_ga;
                    tarteaucitron.user.gajsMore = function () { /* add here your optionnal _ga.push() */
                    };
                    (tarteaucitron.job = tarteaucitron.job || []).push('gajs');
                }

                if (settings.code_analytics_gtag) {
                    tarteaucitron.user.gtagUa = settings.code_analytics_gtag;
                    tarteaucitron.user.gtagMore = function () { /* add here your optionnal gtag() */
                    };
                    (tarteaucitron.job = tarteaucitron.job || []).push('gtag');
                }

                if (settings.code_pixel_fb) {
                    tarteaucitron.user.facebookpixelId = settings.code_pixel_fb;
                    tarteaucitron.user.facebookpixelMore = function () { /* add here your optionnal facebook pixel function */
                    };
                    (tarteaucitron.job = tarteaucitron.job || []).push('facebookpixel');
                }

            });

        }

    };
})(jQuery);