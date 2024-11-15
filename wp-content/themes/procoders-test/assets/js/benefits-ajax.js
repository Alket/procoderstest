jQuery(document).ready(function ($) {
  $(".load-more").on("click", function (e) {
    e.preventDefault();

    let button = $(this);
    let category = button.data("category");
    let offset = button.data("offset");

    $.ajax({
      url: benefits_ajax_obj.ajax_url,
      type: "POST",
      data: {
        action: "procoders_load_more_benefits_posts",
        category: category,
        offset: offset,
      },
      success: function (response) {
        if (response) {
          button.before(response);
          button.data("offset", offset + 3);

          if (response.includes("No posts found")) {
            button.remove();
          }
        } else {
          button.remove();
        }
      },
    });
  });

  /* Tabs */
  $("ul.tabs-nav li:first-child").addClass("current");
  $(".tabs-content .tab-content:first-child").addClass("current");

  $("ul.tabs-nav li").on("click", function () {
    var tab_id = $(this).attr("data-tab");

    $("ul.tabs-nav li").removeClass("current");
    $(".tabs-content .tab-content").removeClass("current");

    $(this).addClass("current");
    $("#tab-" + tab_id).addClass("current");
  });
});
