(function ($) {
  "use strict";
  //wow animation
  new WOW().init();
  //Mobile nav
  var $main_nav = $("#main-nav");
  var $toggle = $(".toggle");
  var defaultOptions = {
    disableAt: false,
    customToggle: $toggle,
    levelSpacing: 10,
    navTitle: "Niwax Menu",
    levelTitles: true,
    levelTitles: true,
    labelClose: false,
    levelTitleAsBack: true,
    levelOpen: "expand",
    closeOnClick: true,
    insertClose: true,
    closeActiveLevel: true,
    insertBack: true,
  };
  // Nav call plugin
  var Nav = $main_nav.hcOffcanvasNav(defaultOptions);
  //Sticky Header
  function updateScroll() {
    if ($(window).scrollTop() >= 80) {
      $(".navfix").addClass("sticky");
    } else {
      $(".navfix").removeClass("sticky");
    }
  }
  $(function () {
    $(window).scroll(updateScroll);
    updateScroll();
  });
  //Header mega menu
  var $nav = $("li.sbmenu");
  $nav.hover(
    function () {
      $(this).addClass("hover");
    },
    function () {
      $(this).removeClass("hover");
    }
  );
  //Video magnificPopup
  $(".video-link").magnificPopup({
    type: "iframe",
    mainClass: "mfp-fade",
    removalDelay: 160,
  });
  //Owl-Carousel - Home hero card
  var owl = $(".service-card-prb");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    margin: 20,
    nav: false,
    dots: false,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 1,
      },
      520: {
        items: 2,
      },
      768: {
        items: 3,
      },
      1200: {
        items: 3,
      },
      1400: {
        items: 3,
      },
      1600: {
        items: 3,
      },
    },
  });
  //Owl-Carousel - Home hero card
  var owl = $(".service-card-prb1");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    margin: 20,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".otherService .custom-nav",
    dots: false,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 1,
      },
      520: {
        items: 2,
      },
      768: {
        items: 3,
      },
      1200: {
        items: 4,
      },
      1400: {
        items: 4,
      },
      1600: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".testimonial-card-a");
  owl.owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 1,
      },
      1024: {
        items: 1,
      },
      1400: {
        items: 1,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".package-slider");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    dots: false,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".healthSection .custom-nav",
    margin: 25,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".package-slider1");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    dots: false,
    margin: 5,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    // navText: [
    //   '<img src="images/black-arrow-left.png" />',
    //   '<img src="images/black-arrow-right.png" />',
    // ],
    // navContainer: "#tabHealthdd1 .custom-nav",
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });

  var owl = $(".radiology-scans");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    dots: false,
    margin: 5,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    lazyLoad: true,
    // navText: [
    //   '<img src="images/black-arrow-left.png" />',
    //   '<img src="images/black-arrow-right.png" />',
    // ],
    // navContainer: ".radio-scantest-new .custom-nav",
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });

  //Owl-Carousel - Home testimonial
  var owl = $(".package-slider2");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    dots: false,
    margin: 5,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    // navText: [
    //   '<img src="images/black-arrow-left.png" />',
    //   '<img src="images/black-arrow-right.png" />',
    // ],
    // navContainer: "#tabHealthdd2 .custom-nav",    
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".package-slider3");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    dots: false,
    margin: 5,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    // navText: [
    //   '<img src="images/black-arrow-left.png" />',
    //   '<img src="images/black-arrow-right.png" />',
    // ],
    // navContainer: "#tabHealthdd3 .custom-nav",    
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  var owl = $(".package-slider4");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    dots: false,
    margin: 5,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    // navText: [
    //   '<img src="images/black-arrow-left.png" />',
    //   '<img src="images/black-arrow-right.png" />',
    // ],
    // navContainer: "#tabHealthdd4 .custom-nav",    
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  var owl = $(".package-slider5");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    dots: false,
    margin: 5,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    // navText: [
    //   '<img src="images/black-arrow-left.png" />',
    //   '<img src="images/black-arrow-right.png" />',
    // ],
    // navContainer: "#tabHealthdd5 .custom-nav",    
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".expert-slider1");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    dots: false,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".expertiseSection .tabi1 .custom-nav",
    margin: 25,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".expert-slider2");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    dots: false,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".expertiseSection .tabi2 .custom-nav",
    margin: 25,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".expert-slider3");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    dots: false,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".expertiseSection .tabi3 .custom-nav",
    margin: 25,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - Home testimonial
  var owl = $(".modernSlide");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    dots: false,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    smartSpeed: 500,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".moderSection .custom-nav",
    margin: 25,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1024: {
        items: 4,
      },
      1400: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - video testimonial
  var owl = $(".video-testimonials");
  owl.owlCarousel({
    items: 2,
    nav: false,
    dots: false,
    autoplay: false,
    autoplayTimeout: 3500,
    smartSpeed: 1500,
    margin: 20,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      1024: {
        items: 2,
      },
      1400: {
        items: 2,
      },
    },
  });
  //Owl-Carousel - Banner Slides
  var owl = $(".bannerSlide");
  owl.owlCarousel({
    items: 1,
    nav: false,
    dots: true,
    autoplay: true,
    loop: true,
    autoplayTimeout: 3500,
    smartSpeed: 1500,
    animateIn: "fadeIn", // add this
    animateOut: "fadeOut", // and this
    margin: 20,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 1,
      },
      1024: {
        items: 1,
      },
      1400: {
        items: 1,
      },
    },
  });
  //Owl-Carousel - case-study
  var owl = $(".project-screens");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    margin: 20,
    nav: false,
    dots: false,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 1,
      },
      520: {
        items: 2,
      },
      768: {
        items: 3,
      },
      1200: {
        items: 3,
      },
      1400: {
        items: 3,
      },
      1600: {
        items: 3,
      },
    },
  });
  //Owl-Carousel -portfolio slide
  var owl = $(".porto-slide");
  owl.owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    margin: 10,
    nav: false,
    dots: true,
    stagePadding: 50,
    autoplayTimeout: 350000,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 1,
        stagePadding: 0,
      },
      520: {
        items: 1,
        stagePadding: 0,
      },
      768: {
        items: 1,
        stagePadding: 0,
      },
      1200: {
        items: 1,
      },
      1400: {
        items: 1,
      },
      1600: {
        items: 1,
      },
    },
  });
  //Owl-Carousel -single slide
  var owl = $(".single-slide");
  owl.owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    margin: 10,
    nav: false,
    dots: true,
    stagePadding: 100,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 1,
        stagePadding: 0,
      },
      520: {
        items: 1,
        stagePadding: 0,
      },
      768: {
        items: 1,
        stagePadding: 0,
      },
      1200: {
        items: 1,
      },
      1400: {
        items: 1,
      },
      1600: {
        items: 1,
      },
    },
  });
  //Owl-Carousel - app page bages-slider
  var owl = $(".bages-slider");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    centre: true,
    margin: 20,
    nav: false,
    dots: false,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 2,
      },
      520: {
        items: 3,
      },
      768: {
        items: 3,
      },
      1200: {
        items: 3,
      },
      1400: {
        items: 4,
      },
      1600: {
        items: 4,
      },
    },
  });
  //Owl-Carousel - app page bages-slider
  var owl = $(".logo-weworkfor");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    margin: 10,
    nav: true,
    navText: [
      '<i class="fas fa-angle-left"></i>',
      '<i class="fas fa-angle-right"></i>',
    ],
    navContainer: ".testsbyCondition .custom-nav",
    dots: false,
    autoplayTimeout: 1800,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 3,
      },
      520: {
        items: 3,
      },
      768: {
        items: 5,
      },
      1200: {
        items: 8,
      },
      1400: {
        items: 8,
      },
      1600: {
        items: 8,
      },
    },
  });
  //Owl-Carousel - app page bages-slider
  var owl = $(".logo-weworkfor1");
  owl.owlCarousel({
    items: 4,
    loop: false,
    autoplay: true,
    margin: 10,
    nav: true,
    // navText: [
    //   '<i class="fas fa-angle-left"></i>',
    //   '<i class="fas fa-angle-right"></i>',
    // ],
    // navContainer: ".testsbyCondition-new .custom-nav",
    dots: false,
    autoplayTimeout: 1800,
    autoplayHoverPause: true,
    lazyLoad:true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 3,
      },
      520: {
        items: 3,
      },
      768: {
        items: 5,
      },
      1200: {
        items: 8,
      },
      1400: {
        items: 8,
      },
      1600: {
        items: 8,
      },
    },
  });
  //Owl-Carousel - milestones-slider
  var owl = $(".milestones");
  owl.owlCarousel({
    items: 4,
    loop: true,
    autoplay: true,
    margin: 20,
    nav: true,
    navText: [
      '<img src="images/black-arrow-left.png" />',
      '<img src="images/black-arrow-right.png" />',
    ],
    navContainer: ".milestoneslide .custom-nav",
    dots: false,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    responsive: {
      0: {
        items: 1,
      },
      520: {
        items: 1,
      },
      768: {
        items: 1,
      },
      1200: {
        items: 1,
      },
      1400: {
        items: 1,
      },
      1600: {
        items: 1,
      },
    },
  });
  //Owl-Carousel - app page bages-slider
  var owl = $(".blog-section-slider");
  owl.owlCarousel({
    items: 3,
    loop: false,
    autoplay: true,
    margin: 10,
    nav: true,
    navText: [
      '<i class="fas fa-angle-left"></i>',
      '<i class="fas fa-angle-right"></i>',
    ],
    navContainer: ".mdrc-blog-section .custom-nav",
    dots: false,
    autoplayTimeout: 1800,
    autoplayHoverPause: true,
    smartSpeed: 2000,
    lazyLoad:true,
    responsive: {
      0: {
        items: 1,
      },
      520: {
        items: 1,
      },
      768: {
        items: 3,
      },
      1200: {
        items: 3,
      },
      1400: {
        items: 3,
      },
      1600: {
        items: 3,
      },
    },
  });
  //Owl-Carousel - app page bages-slider
  var owl = $(".banner-slider");
  owl.owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    margin: 10,
    nav: false,
    // navText: [
    // '<img src="images/black-arrow-left.png" />',
    // '<img src="images/black-arrow-right.png" />'
    // ],
    navContainer: ".banner-sec .custom-nav",
    dots: true,
    autoplayHoverPause: true,
    smartSpeed: 800,
    responsive: {
      0: {
        items: 1,
      },
      520: {
        items: 1,
      },
      768: {
        items: 1,
      },
      1200: {
        items: 1,
      },
      1400: {
        items: 1,
      },
      1600: {
        items: 1,
      },
    },
  });
  //  //Owl-Carousel - Home testimonial
  var owl = $(".testimonial-card-b");
  owl.owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    dots: true,
    dotsContainer: "#testimonials-avatar",
    smartSpeed: 500,
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 1,
      },
      1024: {
        items: 1,
      },
      1400: {
        items: 1,
      },
    },
  });
  //full card portfolio
  var owl = $(".zoomowl");
  owl.owlCarousel({
    stagePadding: 200,
    loop: true,
    margin: 10,
    nav: false,
    items: 1,
    lazyLoad: true,
    responsive: {
      0: {
        items: 1,
        stagePadding: 60,
      },
      600: {
        items: 1,
        stagePadding: 100,
      },
      1000: {
        items: 1,
        stagePadding: 200,
      },
      1200: {
        items: 1,
        stagePadding: 250,
      },
      1400: {
        items: 1,
        stagePadding: 300,
      },
      1600: {
        items: 1,
        stagePadding: 350,
      },
      1800: {
        items: 1,
        stagePadding: 400,
      },
    },
  });
  //Counter Up
  $(".counter").counterUp({
    delay: 10,
    time: 2500,
  });
  //Scroll to top
  $.scrollUp({
    animation: "fade",
    scrollImg: {
      active: true,
      type: "background",
    },
  });
  //Portfolio Filter
  $(".card-list").imagesLoaded(function () {
    // init Isotope
    var $grid = $(".card-list").isotope({
      itemSelector: ".single-card-item",
      percentPosition: true,
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: ".grid-sizer",
      },
    });
    // filter items on button click
    $(".filter-menu").on("click", "li", function () {
      var filterValue = $(this).attr("data-filter");
      $grid.isotope({
        filter: filterValue,
      });
    });
  });
  //for menu active class
  $(".filter-menu li").on("click", function (event) {
    $(this).siblings(".is-checked").removeClass("is-checked");
    $(this).addClass("is-checked");
    event.preventDefault();
  });
  // background image
  $("[data-background]").each(function () {
    $(this).css(
      "background-image",
      "url(" + $(this).attr("data-background") + ")"
    );
  });
  //end of page
})(jQuery);
//Owl-Carousel - awards card
var owl = $(".niwax-review-slider");
owl.owlCarousel({
  items: 3,
  loop: false,
  center: false,
  autoplay: true,
  margin: 10,
  nav: true,
  navText: [
    '<img src="images/black-arrow-left.png" />',
    '<img src="images/black-arrow-right.png" />',
  ],
  navContainer: ".testimonials .custom-nav",
  dots: false,
  autoplayTimeout: 3500,
  autoplayHoverPause: true,
  smartSpeed: 2000,
  responsive: {
    0: {
      items: 1,
    },
    520: {
      items: 1,
    },
    768: {
      items: 2,
    },
    1200: {
      items: 2,
    },
    1400: {
      items: 3,
    },
    1600: {
      items: 3,
    },
  },
});
$(document).ready(function () {
  $(".tooltip-with-img").tooltip({
    html: true,
  });
});
// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $(".stickyBarBottom").outerHeight();
$(window).scroll(function (event) {
  didScroll = true;
});
setInterval(function () {
  if (didScroll) {
    hasScrolled();
    didScroll = false;
  }
}, 250);
function hasScrolled() {
  var st = $(this).scrollTop();
  // Make sure they scroll more than delta
  if (Math.abs(lastScrollTop - st) <= delta) return;
  // If they scrolled down and are past the navbar, add class .nav-up.
  // This is necessary so you never see what is "behind" the navbar.
  if (st > lastScrollTop && st > navbarHeight) {
    // Scroll Down
    $(".stickyBarBottom").removeClass("nav-down").addClass("nav-up");
  } else {
    // Scroll Up
    if (st + $(window).height() < $(document).height()) {
      $(".stickyBarBottom").removeClass("nav-up").addClass("nav-down");
    }
  }
  lastScrollTop = st;
}
$(".scrollTo").click(function () {
  $("html, body").animate(
    {
      scrollTop: $($(this).attr("href")).offset().top - 240,
    },
    500
  );
  return false;
});

/*
  $('.scrollTo').click(function(e) {
	e.preventDefault();
	//Set Offset Distance from top to account for fixed nav
  var offset = 10;
	var target = ( '#' + $(this).data('scroll') );
	var $target = $(target);
	//Animate the scroll to, include easing lib if you want more fancypants easings
	$('html, body').stop().animate({
	    'scrollTop': $target.offset().top - 240
	}, 800, 'swing');
});
*/

//Owl-Carousel - Home new radio-scan
/* var owl = $(".radiology-scans");
owl.owlCarousel({
  items: 4,
  loop: false,
  autoplay: true,
  dots: false,
  margin: 5,
  autoplayTimeout: 6000,
  autoplayHoverPause: true,
  smartSpeed: 500,
  nav: true,
  lazyLoad:true,
  navText: [
    '<img src="images/black-arrow-left.png" />',
    '<img src="images/black-arrow-right.png" />',
  ],
  navContainer: "#tabHealthdd1 .custom-nav",
  responsive: {
    0: {
      items: 1,
    },
    768: {
      items: 3,
    },
    1024: {
      items: 4,
    },
    1400: {
      items: 4,
    },
  },
}); */
//Owl-Carousel - Home testimonial


//Lazyload For image 

/* $(function() {
  $('.lazy').lazy({
    effect: 'fadeIn',  
    effectTime: 1000,  
     
  });
}); */

//Lazyload For image 