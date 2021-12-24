$(window).on('load', function(){
    var elementBackground = $('.eventSearch .backgroundChanger');
    var elementCredits = $('.eventSearch .backgroundCredits .credits');
    var backgrounds = "";
    window.current = 0;

    /**
     * Load background image and credits.
     **/
    function loadBackgroud() {
        console.log("change");
        //console.log(backgrounds.data[0].photographer);
        //console.log(backgrounds.data[0].description);
        //console.log(backgrounds.data[0].image_url);

        elementBackground.css(
            'background-image',
            "url('"+backgrounds.data[current = ++current % backgrounds.data.length].image_url+"')"
        );
        var credits = backgrounds.data[current].description+"  © "+backgrounds.data[current].photographer;
        credits = credits.replace(/<\/?[^>]+(>|$)/g, "");
        elementCredits.html(credits);
    }

    /**
     * Get the list of images URL
     **/
    var request = $.ajax({
        url: "/backgroundImages/jsonList",
        success: function(data) {
            backgrounds = data;
        },
        error: function (error) {
            console.log('error loading background images');
            console.log(error);
        }
    });

    /**
     * Load a new background every 10 seconds
     **/
    const myFunction = () => {
        loadBackgroud();
    };
    setInterval(myFunction, 10000);

});