$(document).ready(function () {

    if ($('.textHasAccordion').length > 0 ) {
        $(".accordion .slide").each(function () {
            // Remove BR in between two accordions
            // If there is ONE <br>
            if (jQuery(this).next().is('br')) {
                //if(jQuery(this).nextAll("*:lt(2)").is('.slide')) {
                    //console.log("remove 1");
                    jQuery(this).next().remove();
                //}
            }
            // If there are TWO <br>
            if (jQuery(this).next().is('br')) {
                if (jQuery(this).nextAll("*:lt(2)").is('br')) {
                    if (jQuery(this).nextAll("*:lt(3)").is('.slide')) {
                        //console.log("remove 2");
                        jQuery(this).next().remove();
                        jQuery(this).next().remove();
                    }
                }
            }

            // If the content of an accordion start with <br> remove it
            if (jQuery(this).children('.ui-accordion-content').children(':first-child').is('br')) {
                jQuery(this).children('.ui-accordion-content').children('br:first-child').remove();
            }

            // Remove the first and last br inside the slide
            jQuery(this).find('br').first().remove();
            jQuery(this).find('br').last().remove();
        });
    }
});