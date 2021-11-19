import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import dashbord from './backend/pages/dashboard.vue'
import tags from './backend/pages/tags.vue'
import category from './backend/pages/category.vue'
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

    {
        path: '/categories',
        component: category
    },
]

export default new Router({
    mode: 'history',
    routes
})
