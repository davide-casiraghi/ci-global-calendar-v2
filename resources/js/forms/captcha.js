
$(document).ready(function () {

    // Change captcha image.
    $('#reloadCaptchaImage').on('click',function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captchaImage").html(data.captcha);
            }
        });
    });


    // Change captcha image (for Livewire components).
    window.livewire.on('reload_captcha', message => {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captchaImage").html(data.captcha);
            }
        });
    });

});