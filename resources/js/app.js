require('./bootstrap');

// Load vendor libraries
require('alpinejs');
require('justifiedGallery');
require("@fancyapps/fancybox");
require('bootstrap-datepicker');
require('select2');
require('slick-carousel');
require('livewire-sortable')
require('flatpickr')
//require('trix');

// Load my scripts related to vendor libraries
require('./vendors/tinymce');
require('./vendors/select2');
require('./vendors/slick_carousel');
require('./forms/uploadImage');
//require("@staaky/tipped"); //imported in bootstrap.js
require('./video_embed');
require('./vendors/gallery_mansonry');
require('./vendors/bootstrap-datepicker');
require('./vendors/staaky_tipped');
require('./vendors/flatpickr');
require('./vendors/tailwindui.com_js_components-v2');

// Helpers
require('./snippets/accordion');
require('./snippets/background_changer');
