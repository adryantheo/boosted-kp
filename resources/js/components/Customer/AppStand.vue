<template>
    <div>
        <v-parallax
            dark
            src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
            height="300"
        >
        </v-parallax>

        <v-container grid-list-lg class="my-3">
            <v-layout row align-center>
                <v-btn fab dark color="primary" @click="$router.go(-1)">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
                <div class="ml-4">
                    <div class="headline font-weight-bold mb-1">Stand {{ name }}</div>
                    <div class="subheading">{{ description }}</div>
                </div>
            </v-layout>
            
            <v-divider class="my-4"></v-divider>

            <p class="subheading font-weight-bold">
                Daftar Menu
            </p>
            <v-layout row wrap>
                <v-flex xs12 md4 lg3  v-for="(item, i) in standProducts" :key="`am-${i}`">
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
            </v-layout>
        </v-container>

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
    },
    data() {
        return {
            name: "",
            description: "",
            standProducts: [],
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
        async fetchStandDetails() {
            const res = await axios.get(`/api/stands/${this.stand}`);
            const stand = res.data;
            this.name = stand.name;
            this.description = stand.description;
            this.standProducts = stand.products.map((item) => {
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
    mounted() {
        this.fetchStandDetails();
    }
}
</script>
