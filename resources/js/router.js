import Vue from 'vue'
import VueRouter from 'vue-router'

import RootAdmin from './components/RootAdmin'
import RootCustomer from './components/RootCustomer'

// customer Pages
import AppBazaar from './components/Customer/AppBazaar'
import AppAllProducts from './components/Customer/AppAllProducts'

// Admin Pages
import AppLogin from './components/Admin/AppLogin'
import AppDashboard from './components/Admin/AppDashboard'

import AppAdminShoes from './components/Admin/Pages/AppAdminShoes'
import AppAdminTransaction from './components/Admin/Pages/AppAdminTransaction'

Vue.use(VueRouter)

const routes = [
    { 
        path:'/', component: RootCustomer,
        children: [
            { path: '/', component: AppBazaar },
            { path: '/products', component: AppAllProducts },
        ]
    },
    
    { 
        path:'/admin', component: RootAdmin,
        children: [
            { path: '/login', component: AppLogin },
            { path: '/admin', component: AppDashboard,
                children: [
                    { path: '/admin', redirect: 'shoes' },
                    { path: 'shoes', component: AppAdminShoes },
                    { path: 'transactions', component: AppAdminTransaction },
                ],
                meta: { requiresAuth: true },
            },
        ],
    },
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
})

import store from './store'

router.beforeEach(async (to, from, next) => {
    if(to.matched.some(route => route.meta.requiresAuth)) {
        if(!store.state.authenticated) {
            next({path: '/login', replace: true})
            return
        }
    }
    
    if(to.path === "/login") {
        if(store.state.authenticated) {
            next({path: '/admin', replace: true})
            return
        }
    }

    next();
})

export default router;