<template>
    <div>
        <v-parallax
            dark
            src="/assets/main-bg.png"
            height="700"
        >
            <v-layout align-center justify-center>
                <v-img
                    src="/assets/svg/logo.svg"
                    max-height="700" contain
                    position="center center"
                ></v-img>
            </v-layout>
        </v-parallax>
        <v-container grid-list-lg class="my-5">
            <!-- Random Brand -->
            <v-layout justify-space-between align-center>
                <div class="headline font-weight-bold">Daftar Brand</div>
                <v-btn color="primary" @click="loadRandomBrand" :loading="randomBrandLoading">
                    <v-icon left>replay</v-icon>
                    Muat lain
                </v-btn>
            </v-layout>
            
            <v-divider class="my-3"></v-divider>

            <v-layout column justify-center align-center class="my-5" v-if="randomBrandLoading">
                <v-flex>
                    <v-progress-circular
                        :size="70"
                        :width="7"
                        color="primary"
                        indeterminate
                    ></v-progress-circular>
                </v-flex>
                <v-flex class="title font-weight-light">
                    Memuat brand
                </v-flex>
            </v-layout>
            <v-layout row wrap justify-center v-else>
                <v-flex xs12 md6 lg4 v-for="(item, id) in brands" :key="`brand-${id}`">
                    <brand-card :item="item"></brand-card>
                </v-flex>
                <v-flex xs12 v-show="!randomBrandLoading">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    to="/brands" height="100%"
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
                                Lihat Semua Brand!
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
                <v-flex xs12 md6 lg4 v-for="(item, id) in products" :key="`produk-${id}`">
                    <product-card :item="item"></product-card>
                </v-flex>
                <v-flex xs12 v-show="!randomProductLoading">
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
import { mapGetters } from 'vuex'
import ProductCard from './ProductCard'
import BrandCard from './BrandCard'

export default {
    components: {
        ProductCard,
        BrandCard,
    },
    data() {
        return {
            randomBrandLoading: true,
            randomProductLoading: true,
            brands: [],
            products: [],
        }
    },
    computed: {
        ...mapGetters([
            'getCartItems'
        ]),
    },
    methods: {
        loadRandomBrand() {
            return new Promise(async (resolve, reject) => {
                this.randomBrandLoading = true;
                try {
                    const res = await axios.get('/api/brands/random');
                    this.brands = res.data;
                    
                    resolve("oke")
                } catch (err) {
                    reject(err);
                }
                this.randomBrandLoading = false;
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
    },
    async mounted() {
        Promise.all([this.loadRandomBrand(), this.loadRandomProduct()]);
    },
}
</script>
