/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$(document).ready(function() {
    $('.summernote').summernote({
        placeholder: 'Put your content in this area',
        tabsize: 2,
        height: 300,
        callbacks: {
            onImageUpload: function(files) {
                let editor = $(this);
                let url = editor.data('image-url');
                const file = new Blob([files[0]]);
                const formData = new FormData();
                formData.append('test', file, file.filename);
                axios.post(url,formData).then((response)=>{
                    let host = window.location.hostname;
                    let protocol = window.location.protocol;
                    let port = window.location.port;
                    url = new URL(protocol+'//'+host+':'+port+'/build/'+response.data);
                    sessionStorage.setItem('allImages',sessionStorage.getItem('allImages')+','+url.href);
                    editor.summernote('insertImage', url.href, response.data);
               });
           },

        }
    });

});

const app = new Vue({
    el: '#app',
});
