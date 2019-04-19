import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        cartItems: [],
        authenticated: localStorage.getItem('token')? true : false,
    },
    getters: {
        getCartItems: (state) => state.cartItems,
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
        emptyCart(state) {
            state.cartItems = [];
        },
        login(state) {
            localStorage.setItem('token', '1234')
            state.authenticated = true;
        },
        logout(state) {
            localStorage.removeItem('token')
            state.authenticated = false;
        },
    },
    actions: {
        async makeOrder({ commit, state }, {name, address, phone}) {
            const total = state.cartItems.reduce((acc, item) => acc + (item.price * item.qty), 0)

            const data = state.cartItems.map(
                (item) => ({
                    product_id: item.id,
                    harga_satuan: item.price,
                    quantity: item.qty,
                    is_delivered: true,
                    is_paid: false,
                })
            );

            try {
                const res = await axios.post('/api/nota', {
                    customer: name,
                    address: address,
                    phone: phone,
                    harga_total: total,
                    products: data
                },{
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json',
                    }
                });
                
                commit('emptyCart');

                return Promise.resolve(res);
            } catch (err) {
                return Promise.reject(err);
            }
        },
        async loginRequest({ commit }, {user, pass}) {
            console.log(user, pass);
            
            return new Promise((resolve, reject) => {
                if(user === "admin" && pass === "secret") {
                    setTimeout(() => {
                        commit('login');
                        resolve("logged in");
                    }, 500);
                } else {
                    setTimeout(() => {
                        reject('incorrect');
                    }, 500);
                }
            })
        },
        async logoutRequest({ commit }) {
            return new Promise(resolve => {
                commit('logout');
                resolve("logged out");
            })
        },
    }
})