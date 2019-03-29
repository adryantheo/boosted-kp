import Vue from 'vue'
import VueRouter from 'vue-router'

import RootAdmin from './components/RootAdmin'
import RootCustomer from './components/RootCustomer'

// customer Pages
import AppBazaar from './components/Customer/AppBazaar'
import AppAllStands from './components/Customer/AppAllStands'
import AppAllProducts from './components/Customer/AppAllProducts'

import AppStand from './components/Customer/AppStand'

// Admin Pages
import AppLogin from './components/Admin/AppLogin'
import AppDashboard from './components/Admin/AppDashboard'

import AppAdminStand from './components/Admin/Pages/AppAdminStand'
import AppAdminProduct from './components/Admin/Pages/AppAdminProduct'
import AppAdminTransaction from './components/Admin/Pages/AppAdminTransaction'
import AppStandDetails from './components/Admin/Pages/AppStandDetails'

Vue.use(VueRouter)

const routes = [
    { 
        path:'/', component: RootCustomer,
        children: [
            { path: '/', component: AppBazaar },
            { path: '/stands', component: AppAllStands },
            { path: '/products', component: AppAllProducts },
            { path: '/stands/:stand', component: AppStand, props: true},
        ]
    },
    
    { 
        path:'/admin', component: RootAdmin,
        children: [
            { path: '/login', component: AppLogin },
            { path: '/admin', component: AppDashboard,
                children: [
                    { path: '/admin', redirect: 'stands' },
                    { path: 'stands', component: AppAdminStand },
                    { path: 'stands/:stand', component: AppStandDetails, props: true },
                    { path: 'products', component: AppAdminProduct },
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

export default router;