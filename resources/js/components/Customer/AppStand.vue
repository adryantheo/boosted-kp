<template>
    <div>
        <v-parallax
            dark
            src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
            height="300"
        >
        </v-parallax>

        <v-container grid-list-lg class="my-3">
            <div class="headline font-weight-bold mb-1">Stand {{ stand }}</div>
            <p class="subheading">Lokasi 1</p>
            <v-divider class="my-4"></v-divider>

            <p class="subheading font-weight-bold">
                Daftar Menu
            </p>
            <v-layout row wrap>
                <v-flex xs12 md4 lg3  v-for="(item, i) in allMenus" :key="`am-${i}`">
                    <v-card class="rounded">
                        <v-img
                        :src="item.thumb"
                        aspect-ratio="1"
                        height="200"
                        ></v-img>

                        <v-card-title>
                            <div>
                                <span class="headline">{{ item.name }}</span>
                                <div class="grey--text text--darken-2">
                                    <span>{{ $rupiahFormat(item.price) }}</span>
                                </div>
                            </div>
                        </v-card-title>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" v-show="!item.qty" @click="addToCart(item)">Tambah</v-btn>
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
                                        :disabled="item.qty >= item.unit">
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>

        <v-bottom-sheet v-model="sheet" inset>
            <v-card>
                <v-card-text class="text-xs-center">
                    <v-img center
                    src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
                    :aspect-ratio="1" height="500" width="500"
                    ></v-img>
                </v-card-text>
                
                <v-card-text class="text-xs-center">
                    <v-btn large round color="primary">
                        <v-icon left>shopping_basket</v-icon>
                        tambah ke keranjang
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-bottom-sheet>
    </div>
</template>
<script>
import { mapMutations } from 'vuex'
import { mapGetters } from 'vuex'

export default {
    props: {
        stand: {
            type: String,
            required: true,
        },
        item: {
            type: String,
            required: false,
        },
    },
    data() {
        return {
            sheet: false,

            allMenus: [
                {
                    id: 1,
                    thumb: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
                    name: "Menu 1",
                    price: 10000,
                    unit: 10,
                },
                {
                    id: 2,
                    
                    thumb: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
                    name: "Menu 2",
                    price: 15000,
                    unit: 10,
                },
                {
                    id: 3,
                    thumb: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
                    name: "A",
                    price: 14000,
                    unit: 10,
                },
            ],
        }
    },
    methods: {
        ...mapMutations({
            addToCartVuex: 'addToCart',
            removeFromCartVuex: 'removeFromCart',
        }),
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
    computed: {
        ...mapGetters([
            'getCartItems'
        ]),
    },
    mounted() {
        if(!!this.item) {
            this.sheet = true
        }

        this.getCartItems.map((item) => item.qty)
        
        this.allMenus = this.allMenus.map((item) => {
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
        })
        this.allMenus.forEach(e => {
            console.log(e.name, e.qty);
        });
        
    }
}
</script>
