
/*
    https://www.npmjs.com/package/justifiedGallery
    http://miromannino.github.io/Justified-Gallery/
    Options: http://miromannino.github.io/Justified-Gallery/options-and-events/
 */

jQuery(document).ready(function () {
    if ($('.lifeGallery').length > 0 ) {
        $(".lifeGallery").justifiedGallery({
            rowHeight: 180,
            margins: 10,
        });
    }
});