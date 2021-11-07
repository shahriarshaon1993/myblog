require('./bootstrap');

import Vue from 'vue'
import router from './router'

Vue.component('mainapp', require('./components/backend/mainapp.vue').default)
Vue.component('dashboardHeader', require('./components/backend/partials/header.vue').default)
Vue.component('dashboardSidebar', require('./components/backend/partials/sidebar.vue').default)
Vue.component('dashboardFooter', require('./components/backend/partials/footer.vue').default)
const app = new Vue({
    router
}).$mount('#app')
