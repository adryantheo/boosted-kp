<template>
    <div>
        <v-parallax
            dark
            src="/assets/main-bg.png"
            height="600"
        >
            <v-layout align-center>
                <v-flex xs4 lg3 class="pa-4">
                    <v-img
                        src="https://seeklogo.com/images/R/restaurant-chief-food-hotel-logo-9DE9D03812-seeklogo.com.png"
                        max-height="200" contain
                    ></v-img>
                </v-flex>
                <v-flex>
                    <h1 class="display-3 mb-3">PL Food Bazaar</h1>
                    <h4 class="display-1 font-weight-light">Enjoy homemade foods today!</h4>
                </v-flex>
            </v-layout>
        </v-parallax>
        <v-container grid-list-lg class="my-5">
            <!-- Random Stand -->
            <v-layout justify-space-between align-center>
                <div class="headline font-weight-bold">Daftar Stand</div>
                <v-btn color="primary" @click="loadRandomStand" :loading="randomStandLoading">
                    <v-icon left>replay</v-icon>
                    Muat lain
                </v-btn>
            </v-layout>
            
            <v-divider class="my-3"></v-divider>

            <v-layout column justify-center align-center class="my-5" v-if="randomStandLoading">
                <v-flex>
                    <v-progress-circular
                        :size="70"
                        :width="7"
                        color="primary"
                        indeterminate
                    ></v-progress-circular>
                </v-flex>
                <v-flex class="title font-weight-light">
                    Memuat stand
                </v-flex>
            </v-layout>
            <v-layout row wrap justify-center v-else>
                <v-flex xs12 sm6 md4 lg3 v-for="(item, id) in stands" :key="`stand-${id}`">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    :to="`/stands/${item.id}`" height="100%"
                >
                    <v-img
                    src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
                    height="180"
                    ></v-img>

                    <v-card-title>
                        <span class="headline">{{ item.name }}</span>
                    </v-card-title>
                    <v-card-text class="grey--text text--darken-2 pt-0">
                        {{ item.description }}
                    </v-card-text>
                </v-card>
                </v-flex>
                <v-flex xs12 sm6 md4 lg6 v-show="!randomStandLoading">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    to="/stands" height="100%"
                >
                    <v-card-text style="height: 100%" class="px-4">
                    <v-layout row wrap justify-center align-center fill-height>
                        <v-flex xs12 lg6>
                        <v-img
                            src="/assets/svg/stands.svg"
                            height="180"
                            contain
                        ></v-img>
                        </v-flex>
                        <v-flex xs12 lg6>
                            <v-card-text class="display-1 font-weight-light primary--text text-xs-center text-lg-left">
                                Lihat Semua Stand!
                            </v-card-text>
                        </v-flex>
                    </v-layout>
                    </v-card-text>
                </v-card>
                </v-flex>
            </v-layout>

            <div class="my-5"></div>

            <!-- Random Menu -->
            <v-layout justify-space-between align-center>
                <div class="headline font-weight-bold">Daftar Menu</div>
                <v-btn color="primary" @click="loadRandomProduct" :loading="randomProductLoading">
                    <v-icon left>replay</v-icon>
                    Muat lain
                </v-btn>
            </v-layout>
            <v-divider class="my-3"></v-divider>
            <v-layout column justify-center align-center class="my-5" v-if="randomProductLoading">
                <v-flex>
                    <v-progress-circular
                        :size="70"
                        :width="7"
                        color="primary"
                        indeterminate
                    ></v-progress-circular>
                </v-flex>
                <v-flex class="title font-weight-light">
                    Memuat produk
                </v-flex>
            </v-layout>
            <v-layout row wrap justify-center v-else>
                <v-flex xs12 sm6 md4 lg3 v-for="(item, id) in products" :key="`produk-${id}`">
                <v-card class="rounded menu-card" height="100%">
                    <div>
                    <v-img class="menu-img"
                    :src="item.image"
                    :aspect-ratio="16/9"
                    ></v-img>

                    <v-card-text>
                        <p class="title font-weight-regular">{{ item.name }}</p>
                        <div class="subheading">{{ $rupiahFormat(item.price) }}</div>
                        <div class="subheading">Sisa {{ item.units }}</div>
                    </v-card-text>
                    </div>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" round flat v-show="!item.qty" @click="addToCart(item)">
                            <v-icon left>add_shopping_cart</v-icon>
                            tambah
                        </v-btn>
                        <div v-show="item.qty">
                            <v-layout align-center>
                                <v-flex>
                                    <v-btn icon outline color="primary" 
                                    @click="removeFromCart(item)">
                                        <v-icon>remove</v-icon>
                                    </v-btn>
                                </v-flex>
                                <v-flex class="title">
                                    {{ item.qty }}
                                </v-flex>
                                <v-flex>
                                    <v-btn icon outline color="primary" 
                                    @click="addToCart(item)" 
                                    :disabled="item.qty >= item.units">
                                        <v-icon>add</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </div>
                    </v-card-actions>
                </v-card>

                </v-flex>
                <v-flex xs12 md6 v-show="!randomProductLoading">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    to="/products" height="100%"
                >
                    <v-card-text style="height: 100%" class="px-4">
                    <v-layout row wrap justify-center align-center fill-height>
                        <v-flex xs12 lg6>
                        <v-img
                            src="/assets/svg/foods.svg"
                            height="180"
                            contain
                        ></v-img>
                        </v-flex>
                        <v-flex xs12 lg6>
                            <v-card-text class="display-1 primary--text font-weight-light text-xs-center text-lg-left">
                                Lihat Semua Menu!
                            </v-card-text>
                        </v-flex>
                    </v-layout>
                    </v-card-text>
                </v-card>
                </v-flex>
            </v-layout>
        </v-container>    
    </div>
</template>
<script>
import { mapMutations } from 'vuex'
import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            randomStandLoading: true,
            randomProductLoading: true,
            stands: [],
            products: [],
        }
    },
    computed: {
        ...mapGetters([
            'getCartItems'
        ]),
    },
    methods: {
        ...mapMutations({
            addToCartVuex: 'addToCart',
            removeFromCartVuex: 'removeFromCart',
        }),
        loadRandomStand() {
            return new Promise(async (resolve, reject) => {
                this.randomStandLoading = true;
                try {
                    const res = await axios.get('/api/stands/random');
                    this.stands = res.data;
                    
                    resolve("oke")
                } catch (err) {
                    reject(err);
                }
                this.randomStandLoading = false;
            })
        },
        loadRandomProduct() {
            return new Promise(async (resolve, reject) => {
                this.randomProductLoading = true;
                try {
                    const res = await axios.get('/api/products/random');
                    this.products = res.data.map((item) => {
                        let q = 0;
                        this.getCartItems.forEach(cartItem => {
                            if(cartItem.id === item.id) {
                                q = cartItem.qty
                            }
                        });
                        return {
                            ...item, 
                            qty: q
                        }
                    });
                    resolve("oke")
                } catch (err) {
                    reject(err);
                }
                this.randomProductLoading = false;
            })
        },
        addToCart(item) {
            // add item qty in this component
            item.qty++;
            // add item to vuex cart
            this.addToCartVuex(item);
        },
        removeFromCart(item) {
            // reduce item qty in this component
            item.qty--;
            // remove item from vuex cart
            this.removeFromCartVuex(item);
        },
    },
    async mounted() {
        Promise.all([this.loadRandomStand(), this.loadRandomProduct()]);
    },
}
</script>
