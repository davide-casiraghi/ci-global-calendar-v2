
// Create carousel
function createTestimonialCarousel(numberOfSlides){
    jQuery('.testimonialsList').not('.slick-initialized').slick({
        dots: false,
        arrows: true,
        infinite: true,
        slidesToShow: numberOfSlides,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 6000,
        pauseOnHover: true
    });
}

// Calculate number of slides to show
function calculateNumberOfSlidesToShow(){
    var carouselWidth = jQuery(".testimonialsList").width();
    var numberOfSlides = 0;
    switch (true) {
        case (carouselWidth < 767):
            numberOfSlides = 1;
            break;
        case (carouselWidth < 991):
            numberOfSlides = 2;
            break;
        case (carouselWidth < 1199):
            numberOfSlides = 3;
            break;
        case (carouselWidth > 1200):
            numberOfSlides = 3;
            break;
    }

    return numberOfSlides;
}

// Reload Carousel on browser resize (to make it responsible)
function reloadCarousel () {
    jQuery('.testimonialsList').slick('unslick');
    var numberOfSlides = calculateNumberOfSlidesToShow();
    createTestimonialCarousel(numberOfSlides);
}

// Call updateMaxHeight when browser resize event fires
jQuery(window).on("resize", reloadCarousel);



jQuery(document).ready(function () {

    // Start carousel
    if (jQuery(".testimonialsList").length) {
        setTimeout(function () {
            var numberOfSlides = calculateNumberOfSlidesToShow();
            createTestimonialCarousel(numberOfSlides);
        }, 300);
    }

});

