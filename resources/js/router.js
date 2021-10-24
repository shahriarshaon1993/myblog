import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import home from './components/mainapp.vue'
const routes = [
    {
        path: '/home',
        component: home
    },
]

export default new Router({
    mode: 'history',
    routes
})
