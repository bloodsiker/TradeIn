'use strict';
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
    toTopScroll();
    smoothScroll();
});


