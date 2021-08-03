/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/* calendar vue */

import VCalendar from 'v-calendar';

Vue.use(VCalendar, {
    componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
                // ...other defaults
  });

/* scann vue */

import VueQrcodeReader from "vue-qrcode-reader";

Vue.use(VueQrcodeReader);

/* vuex */

import Vuex from 'Vuex';
Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        label: {}
    }
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('register-component', require('./components/Register.vue').default);
Vue.component('point-component', require('./components/Point.vue').default);
Vue.component('calendar-component', require('./components/Calendar.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
