// When scroll down change opacity of the title
jQuery(window).scroll(function(event){
    var fromTop = (jQuery(window).scrollTop());
    var offSet = 1 - (fromTop * 0.006);
    //console.log(offSet);
    jQuery('.lifeVideo .container').css('opacity', offSet);


});


// When resize the window scale the youtube video according with window width
function resizeYoutubeVideoFrame(windowWidth){
    var windowWidth = jQuery(window).width();   // returns width of browser viewport
    var videoHeight = windowWidth/16*9;
    jQuery('.lifeVideo.youtube .t-cover__carrier iframe').width(windowWidth);
    jQuery('.lifeVideo.youtube .t-cover__carrier iframe').height(videoHeight);
    jQuery('.lifeVideo.youtube').height(videoHeight);
    //alert("Window width: "+windowWidth);
}

// Resize video - on first page loading
var windowWidth = jQuery(window).width();
resizeYoutubeVideoFrame(windowWidth);


// Resize video - when the use resize the window
jQuery(window).resize(function() {
    var windowWidth = jQuery(window).width();
    resizeYoutubeVideoFrame(windowWidth);
});


$(function () {
    if (/Mobi/i.test(navigator.userAgent) || /Android/i.test(navigator.userAgent)) {
        console.log( "mobile!" );
        $(".lifeVideo.youtube").remove();
    }
    else{
        console.log( "desktop!" );
        $(".lifeVideo.local_vertical").remove();
    }
});
