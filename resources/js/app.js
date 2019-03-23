window.Vue = require('vue');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import router from './router'
import store from './store'
import axios from 'axios'
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

window.EventBus = new Vue()
window.axios = axios.create({
    timeout: 10000,
})

Vue.use(Vuetify, {
    iconfont: 'md',
    // override colors
    theme: {
        primary: "#ff5722",
    }
});

Vue.prototype.$rupiahFormat = function(value) {
    value = parseFloat(value)
    return "Rp " + value.toLocaleString(
        "de-DE", { minimumFractionDigits: 2 }
    )
}

import Cart from './helpers/Cart'

import AppRoot from './components/AppRoot'
const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        AppRoot
    }
});