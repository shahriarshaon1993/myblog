require('./bootstrap');

import Vue from 'vue'
import router from './router'
import store from './store'
import common from './common'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI)
Vue.mixin(common)

Vue.component('mainapp', require('./components/backend/mainapp.vue').default)
Vue.component('dashboardHeader', require('./backend/partials/header.vue').default)
Vue.component('dashboardSidebar', require('./backend/partials/sidebar.vue').default)
Vue.component('dashboardFooter', require('./backend/partials/footer.vue').default)
const app = new Vue({
    el:'#app',
    router,
    store
})
