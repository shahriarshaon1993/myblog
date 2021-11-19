import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import dashbord from './backend/pages/dashboard.vue'
import tags from './backend/pages/tags.vue'
import category from './backend/pages/category.vue'

// Vuex routes
import usecom from './vuex/usecom.vue'

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

    {
        path: '/usecom',
        component: usecom
    },
]

export default new Router({
    mode: 'history',
    routes
})
