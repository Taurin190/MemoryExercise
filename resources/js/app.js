/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.config.devtools = true;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('workbook-component', require('./components/WorkbookComponent.vue').default);
Vue.component('answer-graph-component', require('./components/AnswerGraphComponent.vue').default);
Vue.component('exercise-search-component', require('./components/ExerciseSearchComponent.vue').default);
Vue.component('exercise-append-component', require('./components/ExerciseAppendComponent.vue').default);
Vue.component('study-history-graph-component', require('./components/StudyHistoryGraphComponent.vue').default);
Vue.component('label-search-component', require('./components/LabelSearchComponent.vue').default);
Vue.component('label-list-component', require('./components/LabelListComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
});
