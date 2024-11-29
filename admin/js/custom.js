$('.navbar-nav .nav-link').on('click', function() {
    var toggle = $('.navbar-toggler').is(':visible');
    if (toggle) {
        $('.navbar-collapse').collapse('show');
    }
});