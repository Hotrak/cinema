/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');


import Vuex from 'vuex'
window.Vue.use(Vuex);
import storeData from "./store/index"
const store = new Vuex.Store(
    storeData
);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('list-component', require('./components/ListComponent.vue').default);
Vue.component('list-item-component', require('./components/ListItemComponent.vue').default);

Vue.component('slider-component', require('./components/SliderComponent.vue').default);
Vue.component('slider-item-component', require('./components/SliderItemComponent.vue').default);
Vue.component('carousel-component', require('./components/CarouselComponent.vue').default);

Vue.component('new-slider-component', require('./components/NewSliderComponent.vue').default);
Vue.component('film-component', require('./components/FilmComponent.vue').default);

Vue.component('session-component', require('./components/SessionComponent').default);
Vue.component('schedule-form-component', require('./components/ScheduleFormComponent').default);
Vue.component('trailer-component', require('./components/TrailerComponent').default);

Vue.component('session-panel-component', require('./components/SessionPanelComponent').default);
Vue.component('auth-component', require('./components/AuthComponent').default);
Vue.component('film-edit-component', require('./components/FilmEditComponent').default);

Vue.component('errors-component', require('./components/ErrorsComponent').default);
Vue.component('comment-component', require('./components/CommentComponent').default);

Vue.component('order-component', require('./components/OrdersComponent').default);
Vue.component('about-order-component', require('./components/AboutOrderComponent').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
