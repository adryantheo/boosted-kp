import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        cartItems: [],
    },
    getters: {
        getCartItems: (state) => state.cartItems
    },
    mutations: {
        addToCart(state, item) {
            const { id, name, price, qty } = item
            
            // check if item already exists
            const inCartIdx = state.cartItems.findIndex(obj => {
                return obj.id == item.id
            });

            if(!!(inCartIdx+1)) {
                state.cartItems[inCartIdx].qty++
            } else {
                const newItem = {
                    id: id,
                    name: name,
                    price: price,
                    qty: qty,
                }

                state.cartItems.push(newItem)
            }
        },
        removeFromCart(state, item) {
            const inCartIdx = state.cartItems.findIndex(obj => {
                return obj.id == item.id
            });

            if(!!(inCartIdx+1)) {
                if( (state.cartItems[inCartIdx].qty - 1) <= 0 )
                    state.cartItems.splice(inCartIdx, 1)
                else
                    state.cartItems[inCartIdx].qty--
            }
        },
    },
    actions: {
    }
})