

(function ($) {
    /// Home Banner Slider slider ///
    $(".h-banner-slider").slick({
        autoplay: true,
        autoplaySpeed: 2000,
        //fade: true,
        arrows: false
    });

        /// Maternal Package-slider slider ///
        $(".maternal-package-slider").slick({
            dots: false,
            slidesToShow: 1,
            infinite: true,
            centerMode: true,
            centerPadding: "50px",
            arrows: false,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 475,
                    settings: {
                        centerPadding: "15px",
                    },
                },
    
                {
                    breakpoint: 375,
                    settings: {
                        centerPadding: "15px",
                    },
                },
            ],
        });
    

    

    /// Health Package banner slider ///
    $(".health-package-banner-slider").slick({
        dots: false,
        slidesToShow: 1,
        infinite: true,
        centerMode: true,
        centerPadding: "50px",
        arrows: false,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 475,
                settings: {
                    centerPadding: "15px",
                },
            },

            {
                breakpoint: 375,
                settings: {
                    centerPadding: "15px",
                },
            },
        ],
    });



        /// Health Package banner slider ///
        $(".testimonial-slider").slick({
            dots: false,
            slidesToShow: 1,
            infinite: true,
            centerMode: true,
            centerPadding: "50px",
            arrows: false,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 475,
                    settings: {
                        centerPadding: "20px",
                    },
                },
    
                {
                    breakpoint: 375,
                    settings: {
                        centerPadding: "15px",
                    },
                },
            ],
        });

    /// Product Slider ///
    $(".product-slider").slick({
        dots: false,
        slidesToShow: 3,
        centerMode: true,
        centerPadding: "50px",
        arrows: false,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 567,
                settings: {
                    slidesToShow: 3, centerPadding: "25px",
                },
            },
            {
                breakpoint: 475,
                settings: {
                    slidesToShow: 2, centerPadding: "25px",
                },
            },
            {
                breakpoint: 375,
                settings: {
                    slidesToShow: 1,
                    centerPadding: "120px"
                },
            }
        ],
    });

    /// Product Page Banner Slider ///
    $('.product-banner').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true
    });

    /// Product Slider ///
    $(".product-recent-slider").slick({
        dots: false,
        slidesToShow: 3,
        centerMode: true,
        centerPadding: "50px",
        arrows: false,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 567,
                settings: {
                    slidesToShow: 3, centerPadding: "25px",
                },
            },
            {
                breakpoint: 475,
                settings: {
                    slidesToShow: 2, centerPadding: "25px",
                },
            },
        ],
    });

    /// Onboarding Slider ///
    $('.onboarding-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true
    });

    /// Onboarding Slider ///

    if ($(window).width() > '767') {
        $('.recently-list-slider').slick({
            speed: 300,
            slidesToShow: 4,
            centerMode: true,
            centerPadding: "30px ",
            responsive: [
                {
                    breakpoint: 1367,
                    settings: {
                        slidesToShow: 5,
                        centerPadding: "10px ",
                    },
                },
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 5,
                        centerPadding: "20px ",
                    },
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 5,
                        centerPadding: "30px ",
                    },
                },]
        });
    }

    /// Coupon-slider ///
    if ($(window).width() > '767') {
        $('.coupon-slider').slick({
            speed: 300,
            slidesToShow: 3,
            centerMode: true,
            centerPadding: "30px ",

        });
    }
})(jQuery);




// ================== My Custom Slick slider ====================================================================

        /// About Docter slider ///
        $(".doctors-slider") .slick({
            dots: false,
            slidesToShow: 1,
            infinite: true,
            centerMode: true,
            centerPadding: "50px",
            arrows: false,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 475,
                    settings: {
                        centerPadding: "15px",
                    },
                },
    
                {
                    breakpoint: 375,
                    settings: {
                        centerPadding: "15px",
                    },
                },
            ],
        });

        /// About Portfolio slider ///
        $(".about-porfolio-slider").slick({
            dots: false,
            slidesToShow: 1,
            infinite: true,
            centerMode: true,
            centerPadding: "50px",
            arrows: false,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 475,
                    settings: {
                        centerPadding: "15px",
                    },
                },
    
                {
                    breakpoint: 375,
                    settings: {
                        centerPadding: "15px",
                    },
                },
            ],
        });

            /// About Network slider ///
        $(".about-network-slider").slick({
            dots: false,
            slidesToShow: 1,
            infinite: true,
            centerMode: true,
            centerPadding: "50px",
            arrows: false,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 475,
                    settings: {
                        centerPadding: "15px",
                    },
                },
    
                {
                    breakpoint: 375,
                    settings: {
                        centerPadding: "15px",
                    },
                },
            ],
        }); 


                    /// Health Packge slider ///
                    $(".health-pac1-slider").slick({
                        dots: false,
                        slidesToShow: 2,
                        infinite: true,
                        centerMode: true,
                        centerPadding: "50px",
                        arrows: false,
                        slidesToScroll: 2,
                        responsive: [
                            {
                                breakpoint: 475,
                                settings: {
                                    centerPadding: "20px",
                                },
                            },
                
                            {
                                breakpoint: 375,
                                settings: {
                                    centerPadding: "15px",
                                },
                            },
                        ],
                    }); 
            
                     /// Desease slider ///
                     $(".desease-slider").slick({
                        dots: false,
                        slidesToShow: 5,
                        infinite: true,
                        centerMode: true,
                        centerPadding: "20px",
                        arrows: false,
                        slidesToScroll: 5,
                        responsive: [
                            {
                                breakpoint: 475,
                                settings: {
                                    centerPadding: "20px",
                                    slidesToShow: 3,
                                },
                            },
                
                            {
                                breakpoint: 375,
                                settings: {
                                    centerPadding: "15px",
                                    slidesToShow: 3,
                                },
                            },
                        ],
                    }); 


                       /// Desease slider ///
                     $(".modern-lab-slider").slick({
                        dots: true,
                        slidesToShow: 2,
                        infinite: true,
                        centerMode: true,
                        centerPadding: "10px",
                        arrows: false,
                        slidesToScroll: 2,
                        responsive: [
                            {
                                breakpoint: 475,
                                settings: {
                                    centerPadding: "10px",
                                    slidesToShow: 2,
                                },
                            },
                
                            {
                                breakpoint: 375,
                                settings: {
                                    centerPadding: "10px",
                                    slidesToShow: 2,
                                },
                            },
                        ],
                    }); 
            


