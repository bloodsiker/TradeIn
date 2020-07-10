'use strict';
var owlCarousel = function() {
  $('.owl-carousel').owlCarousel({
      margin: 10,
      nav: true,
      loop: true,
      responsive: {
          0: {
              items: 1
          },
          600: {
              items: 3
          },
          1000: {
              items: 5
          }
      }
  }); 
}
var percentCount1 = $('#percentCount1').text();
var percentCount2 = $('#percentCount2').text();
var percentCount3 = $('#percentCount3').text();
$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};
$(window).on('resize scroll', function() {
    if ($('.bars').isInViewport()) {
      $('#bar1').css('width', percentCount1 );
      $('#bar2').css('width', percentCount2 );
      $('#bar3').css('width', percentCount3 );
    }
    if ($('.numbers_item').isInViewport()) {
       $('.animate_numbers').each(function() {
        var $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
            countNum: countTo
          },
          {
            duration: 2000,
            easing: 'linear',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
            }
          });
      })
    }
});
var mobileMenu = function() {
    $('.toggle_item').on('click', function(event) {
        $(this).toggleClass('open');
        $('#menu').slideToggle(400);
  });
    $('.has-submenu > a').on('click', function(e) {
        if ($(window).width() < 767) {
            e.preventDefault();
            $(this).parent().children('ul').toggleClass('open');
        }
    });
}
var toTop = function() {
    if (jQuery(window).scrollTop() > 300) {
     jQuery('.to-top').css('display' , 'inline-block');
    } else {
      jQuery('.to-top').css('display' , 'none');
    }
}
var toTopScroll = function() {
    jQuery('.to-top').on('click', function (e) {
        e.preventDefault();
        jQuery('html,body').animate({
            scrollTop: 0
        }, 1200);
    })
}
var smoothScroll = function() {
$('a[href*="#"]')
  .not('[href="#"]')
  .not('[href="#0"]')
  .not('[class="anchor"]')
  .not('[href*="#collapse"]') // for bootstrap accordion
  .click(function(event) {
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      var trigger = this;
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1200, function() {
          window.location.href = trigger.href;
        });
      }
    }
  })
}
$(window).scroll(function() { 
    toTop();
});
jQuery(document).ready(function() {
    mobileMenu();
    owlCarousel();
    toTopScroll();
    smoothScroll();
});


