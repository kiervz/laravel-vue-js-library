/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import User from './Helpers/User';
window.User = User;

import Exception from './Helpers/Exception';
window.Exception = Exception;

window.EventBus = new Vue();

// Sweet Alert
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

window.Toast = Toast

// Vue Progress bar
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

//Import v-from
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//vue html to paper 
import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes',
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ]
}

Vue.use(VueHtmlToPaper, options);

// Advanced-Laravel-Vue-Paginate
import 'advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css'
Vue.component('advanced-laravel-vue-paginate', require('advanced-laravel-vue-paginate').default);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app-home', require('./components/AppHome.vue').default);

import router from './Router/router_.js'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
