jQuery(document).ready(function ($) {
  // Initially hide the mega-menu and flyout-menu
  $(".mega-menu, .flyout-menu").hide();

  // Show mega menu on hover
  $(".has-megamenu")
    .mouseenter(function () {
      $(this).find(".mega-menu").stop(true, true).fadeIn(300);
    })
    .mouseleave(function () {
      var $this = $(this);
      setTimeout(function () {
        if (!$this.find(".mega-menu:hover").length) {
          $this.find(".mega-menu").stop(true, true).fadeOut(300);
        }
      }, 10);
    });

  // Show flyout menu on hover
  $(".menu-item-has-children:not(.has-megamenu)")
    .mouseenter(function () {
      $(this).find(".flyout-menu").stop(true, true).fadeIn(300);
    })
    .mouseleave(function () {
      var $this = $(this);
      setTimeout(function () {
        if (!$this.find(".flyout-menu:hover").length) {
          $this.find(".flyout-menu").stop(true, true).fadeOut(300);
        }
      }, 10);
    });

  $(".flyout-menu")
    .mouseenter(function () {
      $(this).stop(true, true).fadeIn(300);
    })
    .mouseleave(function () {
      var $this = $(this);
      setTimeout(function () {
        if (!$this.is(":hover")) {
          $this.stop(true, true).fadeOut(300);
        }
      }, 10);
    });

  $(".mega-menu")
    .mouseenter(function () {
      $(this).stop(true, true).fadeIn(300);
    })
    .mouseleave(function () {
      var $this = $(this);
      setTimeout(function () {
        if (!$this.is(":hover")) {
          $this.stop(true, true).fadeOut(300);
        }
      }, 10);
    });
});
