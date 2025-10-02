// Open Sub Menu
$(".drp_btn").click(function () {
  $(this).siblings(".sub_menu").slideToggle();
  $(this).toggleClass('rotate');
});

// Mobile menu closing - using Bootstrap's native collapse method
$(document).on('click', '.navbar-nav .nav-link[href^="#"]', function() {
  if ($(window).width() < 992) {
    // Close menu after scroll has started using Bootstrap's method
    setTimeout(function() {
      $('#navbarSupportedContent').collapse('hide');
      // Remove active class from hamburger toggle
      $('.toggle-wrap').removeClass('active');
    }, 200);
  }
});

// Preloader JS
function preloader_fade() {
  $("#preloader").fadeOut("slow");
}

$(document).ready(function () {
  window.setTimeout("preloader_fade();", 500); //call fade in .5 seconds
});

// Number Count
let counter_find = document.querySelector('#counter');
if (typeof (counter_find) != 'undefined' && counter_find != null) {
  window.addEventListener('scroll', function () {
    var element = document.querySelector('#counter');
    var position = element.getBoundingClientRect();

    // checking whether fully visible
    if (position.top >= 0 && position.bottom <= window.innerHeight) {
      $('.counter-value').each(function () {
        var $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
          countNum: countTo
        },

          {

            duration: 2000,
            easing: 'swing',
            step: function () {
              $this.text(Math.floor(this.countNum));
            },
            complete: function () {
              $this.text(this.countNum);
              //alert('finished');
            }

          });
      });
    }

    if (position.top < window.innerHeight && position.bottom >= 0) {
      //console.log('Element is partially visible in screen');
    } else {
      //console.log('Element is not visible');
      $('.counter-value').each(function () {
        var $this = $(this),
          countTo = 0;
        $({
          countNum: $this.text()
        }).animate({
          countNum: countTo
        },

          {

            duration: 100,
            easing: 'swing',
            step: function () {
              $this.text(Math.floor(this.countNum));
            },
            complete: function () {
              $this.text(this.countNum);
              //alert('finished');
            }

          });
      });
    }
  });
}

// All Slider Js
// Go Top 
$(document).ready(function () {
  $('#Gotop').click(function () {
    let windiowTop = $(window).scrollTop();
    if (windiowTop <= 1000) {
      $('body,html').animate({ scrollTop: 0 }, 1000);
    } else if (windiowTop <= 2000 && windiowTop > 1000) {
      $('body,html').animate({ scrollTop: 0 }, 2000);
    } else {
      $('body,html').animate({ scrollTop: 0 }, 2500);

    }
  })
})

$(window).scroll(function () {
  let windiowTop = $(window).scrollTop();
  // console.log(windiowTop)
  if (windiowTop > 300) {
    $('#Gotop').fadeIn(500);
  } else {
    $('#Gotop').fadeOut(500);

  }
})

// Fix Header Js
var header_height = $('header').outerHeight();
$(window).scroll(function () {
  if ($(window).scrollTop() >= 10) {
    $("header").addClass("fix_style");
  } else {
    $("header").removeClass("fix_style");
  }
});
// Removed hide_scroll toggle that was preventing mobile scrolling
// $('.navbar-toggler').click(function () {
//   $('body').toggleClass('hide_scroll');
// })


//YOUTUBE VIDEO
$(".play-button").click(function (e) {
  var iframeEl = $("<iframe>", { src: $(this).data("url") });
  $("#youtubevideo").attr("src", $(this).data("url"));
});

$("#close-video").click(function (e) {
  $("#youtubevideo").attr("src", "");
});

$(document).on("hidden.bs.modal", "#myModal", function () {
  $("#youtubevideo").attr("src", "");
});

// Close btn on click
$(document).ready(function () {
  $(".navbar-toggler").click(function () {
    if (
      $(this)
        .children("span")
        .children(".ico_menu")
        .hasClass("icofont-navigation-menu")
    ) {
      $(this)
        .children("span")
        .children(".ico_menu")
        .removeClass("icofont-navigation-menu")
        .addClass("icofont-close");
    } else {
      $(this)
        .children("span")
        .children(".ico_menu")
        .removeClass("icofont-close")
        .addClass("icofont-navigation-menu");
    }
  });
});

(function () {
  $(".toggle-wrap").on("click", function () {
    $(this).toggleClass("active");
    $("aside").animate({ width: "toggle" }, 200);
  });
})();

// INITIALIZE AOS
AOS.init();


// SideBar Show 
$('.bar').click(function () {
  $('.right_sidemenu').addClass('active');
  $('body').addClass('modal-open');
})
$('.close_rightmenu').click(function () {
  $('.right_sidemenu').removeClass('active');
  $('body').removeClass('modal-open');
})


// Menu List Flow 
$('#menu_list_flow , #salad_list_flow , #desserts_list_flow').owlCarousel({
  loop: true,
  margin: 0,
  nav: false,
  dots: false,
  center: true,
  autoplay: true,
  slideTransition: 'linear',
  autoplayTimeout: 4000,
  autoplaySpeed: 4000,
  autoWidth: true,
  responsive: {
    0: {
      items: 2
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
})


// Text Flow Reverce 
$('#text_list_flow').owlCarousel({
  loop: true,
  margin: 0,
  nav: false,
  dots: false,
  center: true,
  autoplay: true,
  rtl: true,
  slideTransition: 'linear',
  autoplayTimeout: 4000,
  autoplaySpeed: 4000,
  autoWidth: true,
  responsive: {
    0: {
      items: 2
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
})

// MenuTextSlider Slider Right 
$('.menuTextSlider').owlCarousel({
  loop: true,
  margin: 0,
  nav: false,
  dots: false,
  center: true,
  autoplay: true,
  slideTransition: 'linear',
  autoplayTimeout: 2000,
  autoplaySpeed: 2000,
  responsive: {
    0: {
      items: 1,
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
})

// Gallery Slider Right 
$('#gallery_flow_right').owlCarousel({
  loop: true,
  margin: 40,
  nav: false,
  dots: false,
  center: true,
  autoplay: true,
  lazyLoad: true,
  slideTransition: 'linear',
  autoplayTimeout: 3000,
  autoplaySpeed: 3000,
  responsive: {
    0: {
      items: 1,
      margin: 15
    },
    600: {
      items: 3,
      margin: 20
    },
    1000: {
      items: 4
    }
  }
})

// Gallery Slider left 
$('#gallery_flow_left').owlCarousel({
  loop: true,
  margin: 40,
  nav: false,
  dots: false,
  center: true,
  autoplay: true,
  slideTransition: 'linear',
  autoplayTimeout: 3000,
  autoplaySpeed: 3000,
  responsive: {
    0: {
      items: 1,
      margin: 15
    },
    600: {
      items: 3,
      margin: 20
    },
    1000: {
      items: 4
    }
  }
})

// Testimonial Slider
$('#testimonial_slider').owlCarousel({
  loop: true,
  items: 1,
  margin: 0,
  nav: true,
  dots: false,
  autoplay: true,
  autoplaySpeed: 1500,
  autoplayTimeout: 5000
})

// Banner Slider  
$('#banner_slider').owlCarousel({
  loop: true,
  items: 1,
  margin: 0,
  nav: true,
  dots: false,
  autoplay: true,
  autoplaySpeed: 1000,
  autoplayTimeout: 5000
})

// Popluar Slider 
$('#popular_dish').owlCarousel({
  loop: true,
  margin: 15,
  slideBy: 4,
  nav: true,
  autoplay: true,
  autoplaySpeed: 500,
  dots: false,
  responsive: {
    0: {
      slideBy: 1,
      items: 1
    },
    600: {
      slideBy: 2,
      items: 2
    },
    900: {
      slideBy: 3,
      items: 3
    },
    1200: {
      slideBy: 4,
      items: 4
    }
  }
})

// Team Slider 
$('#team_slider').owlCarousel({
  loop: true,
  margin: 30,
  nav: true,
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    }
  }
})
