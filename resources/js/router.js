import Vue from 'vue'
import VueRouter from 'vue-router'

import RootAdmin from './components/RootAdmin'
import RootCustomer from './components/RootCustomer'

// customer Pages
import AppBazaar from './components/Customer/AppBazaar'
import AppStand from './components/Customer/AppStand'

// Admin Pages
import AppLogin from './components/Admin/AppLogin'

Vue.use(VueRouter)

const routes = [
    { 
        path:'/', component: RootCustomer,
        children: [
            { path: '/', component: AppBazaar },
            { path: '/stand/:stand/:item?', component: AppStand, props: true },
        ]
    },
    
    { 
        path:'/login', component: RootAdmin,
        children: [
            { path: '/login', component: AppLogin },
        ],
        meta: { requiresAuth: true }
    },
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
})

export default router;