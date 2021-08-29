//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function () {
    var url = window.location;
    // Get li that contain url
    var element = $('ul a').filter(function () {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            // add active on li
            element.addClass('active');

            // add active on ul
            element = element.parent().parent().addClass('active');
        } else {
            break;
        }
    }
});
