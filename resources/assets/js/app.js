
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('books-table', require('./components/BooksTable.vue'))
Vue.component('loading-spinner', require('./components/LoadingSpinner.vue'))
Vue.component('check-availability', require('./components/CheckAvailability.vue'))

const app = new Vue({
    el: '#app',
    data: {
        search: '',
    },
    mounted() {
        this.search = document.head.querySelector('meta[name="search"]').content
    },
})
