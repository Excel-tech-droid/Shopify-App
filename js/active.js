$(document).ready(function (e) {
  $("li.actives").removeClass("actives");
  $('.nav-item a[href="' + location.pathname.split("/")[2] + '"]').addClass(
    "actives"
  );
});

// $('navbar-nav li a[href="/' + location.pathname.split("/")[2] + '"]').addClass(
//   "active"
// );
