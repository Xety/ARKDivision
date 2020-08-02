require('./bootstrap');
require('./vue');

$(document).ready(function () {
    "use strict";

    $("body").tooltip({
        selector: "[data-toggle=tooltip]"
    });

    $('[data-toggle="popover"]').popover();

    /**
     * ScrollUp.
     */
    $.scrollUp({
        scrollName: "scrollUp",
        scrollDistance: 300,
        scrollFrom: "top",
        scrollSpeed: 1000,
        easingType: "easeInOutCubic",
        animation: "fade",
        animationInSpeed: 200,
        animationOutSpeed: 200,
        scrollText: '<i class="fa fa-chevron-up"></i>',
        scrollTitle: " ",
        scrollImg: 0,
        activeOverlay: 0,
        zIndex: 1001
    });
});

/*app = {

    init: function() {
        alert('test');
    }

};
module.exports = app;*/