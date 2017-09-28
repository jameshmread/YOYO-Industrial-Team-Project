
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('uservolume', require('./components/UserVolumePerStore.vue'));
Vue.component('sales-over-time-against-stores', require('./components/SalesOverTimeAgainstStores.vue'));
Vue.component('total', require('./components/TotalSalesPerStore.vue'));
Vue.component('reports', require('./components/UserReports.vue'));
Vue.component('colour', require('./components/ColourPicker.vue'));
Vue.component('avg-sales-over-time', require('./components/AverageSalesOverTime.vue'));
Vue.component('user-retention', require('./components/UserRetentionRate.vue'));
Vue.component('unique-users', require('./components/UniqueUsers.vue'));

const app = new Vue({
    el: '#app'
});

require('./chosen');
