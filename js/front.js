$(document).ready(function () {
  "use strict";

  // ------------------------------------------------------- //
  // Search Box
  // ------------------------------------------------------ //
  $("#search").on("click", function (e) {
    e.preventDefault();
    $(".search-box").fadeIn();
  });
  $(".dismiss").on("click", function () {
    $(".search-box").fadeOut();
  });

  // ------------------------------------------------------- //
  // Card Close
  // ------------------------------------------------------ //
  $(".card-close a.remove").on("click", function (e) {
    e.preventDefault();
    $(this).parents(".card").fadeOut();
  });

  // ------------------------------------------------------- //
  // Tooltips init
  // ------------------------------------------------------ //

  $('[data-toggle="tooltip"]').tooltip();

  // ------------------------------------------------------- //
  // Adding fade effect to dropdowns
  // ------------------------------------------------------ //
  $(".dropdown").on("show.bs.dropdown", function () {
    $(this).find(".dropdown-menu").first().stop(true, true).fadeIn();
  });
  $(".dropdown").on("hide.bs.dropdown", function () {
    $(this).find(".dropdown-menu").first().stop(true, true).fadeOut();
  });

  // ------------------------------------------------------- //
  // Sidebar Functionality
  // ------------------------------------------------------ //
  $("#toggle-btn").on("click", function (e) {
    e.preventDefault();
    $(this).toggleClass("active");

    $(".side-navbar").toggleClass("shrinked");
    $(".content-inner").toggleClass("active");
    $(document).trigger("sidebarChanged");

    if ($(window).outerWidth() > 1183) {
      if ($("#toggle-btn").hasClass("active")) {
        $(".navbar-header .brand-small").hide();
        $(".navbar-header .brand-big").show();
      } else {
        $(".navbar-header .brand-small").show();
        $(".navbar-header .brand-big").hide();
      }
    }

    if ($(window).outerWidth() < 1183) {
      $(".navbar-header .brand-small").show();
    }
  });

  // ------------------------------------------------------- //
  // Universal Form Validation
  // ------------------------------------------------------ //

  $(".form-validate").each(function () {
    $(this).validate({
      errorElement: "div",
      errorClass: "is-invalid",
      validClass: "is-valid",
      ignore:
        ":hidden:not(.summernote, .checkbox-template, .form-control-custom),.note-editable.card-block",
      errorPlacement: function (error, element) {
        // Add the `invalid-feedback` class to the error element
        error.addClass("invalid-feedback");
        console.log(element);
        if (element.prop("type") === "checkbox") {
          error.insertAfter(element.siblings("label"));
        } else {
          error.insertAfter(element);
        }
      },
    });
  });

  // ------------------------------------------------------- //
  // Material Inputs
  // ------------------------------------------------------ //

  var materialInputs = $("input.input-material");

  // activate labels for prefilled values
  materialInputs
    .filter(function () {
      return $(this).val() !== "";
    })
    .siblings(".label-material")
    .addClass("active");

  // move label on focus
  materialInputs.on("focus", function () {
    $(this).siblings(".label-material").addClass("active");
  });

  // remove/keep label on blur
  materialInputs.on("blur", function () {
    $(this).siblings(".label-material").removeClass("active");

    if ($(this).val() !== "") {
      $(this).siblings(".label-material").addClass("active");
    } else {
      $(this).siblings(".label-material").removeClass("active");
    }
  });

  // ------------------------------------------------------- //
  // Footer
  // ------------------------------------------------------ //

  var contentInner = $(".content-inner");

  $(document).on("sidebarChanged", function () {
    adjustFooter();
  });

  $(window).on("resize", function () {
    adjustFooter();
  });

  function adjustFooter() {
    var footerBlockHeight = $(".main-footer").outerHeight();
    contentInner.css("padding-bottom", footerBlockHeight + "px");
  }

  // ------------------------------------------------------- //
  // External links to new window
  // ------------------------------------------------------ //
  $(".external").on("click", function (e) {
    e.preventDefault();
    window.open($(this).attr("href"));
  });

  // ------------------------------------------------------ //
  // For demo purposes, can be deleted
  // ------------------------------------------------------ //

  var stylesheet = $("link#theme-stylesheet");
  $("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
  var alternateColour = $("link#new-stylesheet");

  if ($.cookie("theme_csspath")) {
    alternateColour.attr("href", $.cookie("theme_csspath"));
  }

  $("#colour").change(function () {
    if ($(this).val() !== "") {
      var theme_csspath = "css/style." + $(this).val() + ".css";

      alternateColour.attr("href", theme_csspath);

      $.cookie("theme_csspath", theme_csspath, {
        expires: 365,
        path: document.URL.substr(0, document.URL.lastIndexOf("/")),
      });
    }

    return false;
  });
});

$(function () {
  $(".shop-detail-carousel").owlCarousel({
    items: 1,
    thumbs: true,
    nav: false,
    dots: false,
    loop: true,
    autoplay: true,
    thumbsPrerendered: true,
  });

  $("#main-slider").owlCarousel({
    items: 1,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayHoverPause: true,
    dotsSpeed: 400,
  });

  $("#get-inspired").owlCarousel({
    items: 1,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayHoverPause: true,
    dotsSpeed: 400,
  });

  $(".product-slider").owlCarousel({
    items: 1,
    dots: true,
    nav: false,
    responsive: {
      480: {
        items: 1,
      },
      765: {
        items: 2,
      },
      991: {
        items: 3,
      },
      1200: {
        items: 5,
      },
    },
  });

  // productDetailGallery(4000);
  utils();

  // ------------------------------------------------------ //
  // For demo purposes, can be deleted
  // ------------------------------------------------------ //

  var stylesheet = $("link#theme-stylesheet");
  $("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
  var alternateColour = $("link#new-stylesheet");

  if ($.cookie("theme_csspath")) {
    alternateColour.attr("href", $.cookie("theme_csspath"));
  }

  $("#colour").change(function () {
    if ($(this).val() !== "") {
      var theme_csspath = "css/style." + $(this).val() + ".css";

      alternateColour.attr("href", theme_csspath);

      $.cookie("theme_csspath", theme_csspath, {
        expires: 365,
        path: document.URL.substr(0, document.URL.lastIndexOf("/")),
      });
    }

    return false;
  });
});

$(window).on("load", function () {
  $(this).alignElementsSameHeight();
});

$(window).resize(function () {
  setTimeout(function () {
    $(this).alignElementsSameHeight();
  }, 150);
});

/* product detail gallery */

// function productDetailGallery(confDetailSwitch) {
//     $('.thumb:first').addClass('active');
//     timer = setInterval(autoSwitch, confDetailSwitch);
//     $(".thumb").click(function(e) {
//
// 	switchImage($(this));
// 	clearInterval(timer);
// 	timer = setInterval(autoSwitch, confDetailSwitch);
// 	e.preventDefault();
//     }
//     );
//     $('#mainImage').hover(function() {
// 	clearInterval(timer);
//     }, function() {
// 	timer = setInterval(autoSwitch, confDetailSwitch);
//     });
//
//     function autoSwitch() {
// 	var nextThumb = $('.thumb.active').closest('div').next('div').find('.thumb');
// 	if (nextThumb.length == 0) {
// 	    nextThumb = $('.thumb:first');
// 	}
// 	switchImage(nextThumb);
//     }
//
//     function switchImage(thumb) {
//
// 	$('.thumb').removeClass('active');
// 	var bigUrl = thumb.attr('href');
// 	thumb.addClass('active');
// 	$('#mainImage img').attr('src', bigUrl);
//     }
// }

function utils() {
  /* click on the box activates the radio */

  $("#checkout").on(
    "click",
    ".box.shipping-method, .box.payment-method",
    function (e) {
      var radio = $(this).find(":radio");
      radio.prop("checked", true);
    }
  );
  /* click on the box activates the link in it */

  $(".box.clickable").on("click", function (e) {
    window.location = $(this).find("a").attr("href");
  });
  /* external links in new window*/

  $(".external").on("click", function (e) {
    e.preventDefault();
    window.open($(this).attr("href"));
  });
  /* animated scrolling */

  $(".scroll-to, .scroll-to-top").click(function (event) {
    var full_url = this.href;
    var parts = full_url.split("#");
    if (parts.length > 1) {
      scrollTo(full_url);
      event.preventDefault();
    }
  });

  function scrollTo(full_url) {
    var parts = full_url.split("#");
    var trgt = parts[1];
    var target_offset = $("#" + trgt).offset();
    var target_top = target_offset.top - 100;
    if (target_top < 0) {
      target_top = 0;
    }

    $("html, body").animate(
      {
        scrollTop: target_top,
      },
      1000
    );
  }
}

$.fn.alignElementsSameHeight = function () {
  $(".same-height-row").each(function () {
    var maxHeight = 0;

    var children = $(this).find(".same-height");

    children.height("auto");

    if ($(document).width() > 768) {
      children.each(function () {
        if ($(this).innerHeight() > maxHeight) {
          maxHeight = $(this).innerHeight();
        }
      });

      children.innerHeight(maxHeight);
    }

    maxHeight = 0;
    children = $(this).find(".same-height-always");

    children.height("auto");

    children.each(function () {
      if ($(this).innerHeight() > maxHeight) {
        maxHeight = $(this).innerHeight();
      }
    });

    children.innerHeight(maxHeight);
  });
};
