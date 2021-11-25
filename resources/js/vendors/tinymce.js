
require('tinymce');
require('tinymce/themes/silver');

require('tinymce/icons/default');

require('tinymce/plugins/advlist');
require('tinymce/plugins/autolink');
require('tinymce/plugins/lists');
require('tinymce/plugins/link');
require('tinymce/plugins/image');
require('tinymce/plugins/charmap');
require('tinymce/plugins/print');
require('tinymce/plugins/preview');
require('tinymce/plugins/hr');
require('tinymce/plugins/anchor');
require('tinymce/plugins/pagebreak');
require('tinymce/plugins/searchreplace');
require('tinymce/plugins/wordcount');
require('tinymce/plugins/visualblocks');
require('tinymce/plugins/visualchars');
require('tinymce/plugins/code');
require('tinymce/plugins/fullscreen');
require('tinymce/plugins/insertdatetime');
require('tinymce/plugins/media');
require('tinymce/plugins/nonbreaking');
require('tinymce/plugins/save');
require('tinymce/plugins/table');
require('tinymce/plugins/contextmenu');
require('tinymce/plugins/directionality');
require('tinymce/plugins/template');
require('tinymce/plugins/paste');
require('tinymce/plugins/textcolor');
require('tinymce/plugins/colorpicker');
require('tinymce/plugins/textpattern');
require('tinymce/plugins/imagetools');

/**
 * Configuration
 **/

var editor_config = {
    selector: '.textarea_tinymce',

    // Remove Html tags from paste text
    paste_as_text: true, //!important

    // Allow link target blank
    extended_valid_elements: 'a[href|target]',

    /*plugins : 'advlist autolink link image lists charmap print preview spellchecker media table',*/
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "template paste textcolor colorpicker textpattern imagetools"
    ],
    theme: 'silver',
    height: 400,

    toolbar: 'code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media blockquote | hr',
    /*toolbar: 'bold | bullist  link ', */

    menubar: false,
    path_absolute : "/",
    relative_urls: false,

    image_class_list: [
        { title: 'Left', value: '' },
        { title: 'Right', value: 'float-left w-full md:w-6/12 md:float-right' }
    ],

    // Add styles to align right the image in the editor
    content_style: "body img.md\\:float-right{ float: right; }" +
                    "body img.md\\:w-6\\/12{ width: 50%; }",

    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/tinymce_upload');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }


    //forced_root_block : false, // force to add <br> instead of <p> - Better not to enable it - Warning: Not using p elements as the root block will impair the functionality of the editor. - https://www.tiny.cloud/docs/configure/content-filtering/#exampleusingforced_root_block

// do not delete the commented lines of tinymce! .. this is a file browser that can be useful for articles

/*file_browser_callback : function(field_name, url, type, win) {
    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
    if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
    } else {
        cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
    });
} */
}

tinymce.init(editor_config);
