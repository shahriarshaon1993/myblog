import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import dashbord from './components/backend/pages/dashboard.vue'
import tags from './components/backend/pages/tags.vue'
const routes = [
    // admin dashboard route
    {
        path: '/dashboard',
        component: dashbord
    },

    {
        path: '/tags',
        component: tags
    },
]

export default new Router({
    mode: 'history',
    routes
})
