import Vue from 'vue'
import VueRouter from 'vue-router'

import RootAdmin from './components/RootAdmin'
import RootCustomer from './components/RootCustomer'

// customer Pages
import AppBazaar from './components/Customer/AppBazaar'
import AppAllBrands from './components/Customer/AppAllBrands'
import AppAllProducts from './components/Customer/AppAllProducts'

import AppBrand from './components/Customer/AppBrand'

// Admin Pages
import AppLogin from './components/Admin/AppLogin'
import AppDashboard from './components/Admin/AppDashboard'

import AppAdminBrand from './components/Admin/Pages/AppAdminBrand'
import AppAdminTransaction from './components/Admin/Pages/AppAdminTransaction'
import AppBrandDetails from './components/Admin/Pages/AppBrandDetails'

Vue.use(VueRouter)

const routes = [
    { 
        path:'/', component: RootCustomer,
        children: [
            { path: '/', component: AppBazaar },
            { path: '/brands', component: AppAllBrands },
            { path: '/products', component: AppAllProducts },
            { path: '/brands/:brand', component: AppBrand, props: true},
        ]
    },
    
    { 
        path:'/admin', component: RootAdmin,
        children: [
            { path: '/login', component: AppLogin },
            { path: '/admin', component: AppDashboard,
                children: [
                    { path: '/admin', redirect: 'brands' },
                    { path: 'brands', component: AppAdminBrand },
                    { path: 'brands/:brand', component: AppBrandDetails, props: true },
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