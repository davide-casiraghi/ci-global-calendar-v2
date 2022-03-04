require('./bootstrap');

// Load Alpine
import Alpine from 'alpinejs'

// Register alpine directives - https://alpinejs.dev/advanced/extending#via-npm

// Magic: $tooltip
Alpine.magic('tooltip', el => message => {
    let instance = tippy(el, { content: message, trigger: 'manual' })

    instance.show()

    setTimeout(() => {
        instance.hide()

        setTimeout(() => instance.destroy(), 150)
    }, 2000)
})

// Directive: x-tooltip
Alpine.directive('tooltip', (el, { expression }) => {
    tippy(el, { content: expression })
})

window.Alpine = Alpine
Alpine.start()

// Load vendor libraries
require('justifiedGallery');
require("@fancyapps/fancybox");
//require('bootstrap-datepicker'); -- substituted by flatPickr
require('select2');
require('slick-carousel');
require('livewire-sortable')
require('flatpickr')
import { Chartisan, ChartisanHooks } from '@chartisan/chartjs';

require('@popperjs/core')
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

//require('trix');

// Load my scripts related to vendor libraries
require('./vendors/tinymce');
require('./vendors/select2');
require('./vendors/slick_carousel');
require('./forms/uploadImage');
require('./forms/messages');
require('./forms/captcha');
//require("@staaky/tipped"); //imported in bootstrap.js
require('./video_embed');
require('./vendors/gallery_mansonry');
//require('./vendors/bootstrap-datepicker'); -- substituted by flatPickr
require('./vendors/flatpickr');
require('./vendors/tailwindui.com_js_components-v2');


// Helpers
require('./snippets/accordion');
require('./snippets/background_changer');
require('./snippets/event_repetition');
