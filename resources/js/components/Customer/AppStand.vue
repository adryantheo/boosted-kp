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
                                        :disabled="item.qty >= item.stock"
                                        >
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>

            <v-btn color="success" @click="cek">cek</v-btn>
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
                    stock: 10,

                    // di .map aja ini
                    qty: 0,
                },
                {
                    id: 2,
                    
                    thumb: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
                    name: "Menu 2",
                    price: 15000,
                    stock: 10,
                    
                    qty: 0,
                },
                {
                    id: 3,
                    thumb: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
                    name: "A",
                    price: 14000,
                    stock: 10,
                    
                    qty: 0,
                },
            ],

            cartItems: [],
        }
    },
    methods: {
        addToCart(item) {
            item.qty++

            const { id, name, price, qty } = item
            
            const inCartIdx = this.cartItems.findIndex(obj => {
                return obj.id == item.id
            });

            if(!!(inCartIdx+1)) {
                this.cartItems[inCartIdx].qty++
            } else {
                const newItem = {
                    id: id,
                    name: name,
                    price: price,
                    qty: qty,
                }

                this.cartItems.push(newItem)
            }
            
        },
        removeFromCart(item) {
            item.qty--

            const inCartIdx = this.cartItems.findIndex(obj => {
                return obj.id == item.id
            });

            if(!!(inCartIdx+1)) {
                if( (this.cartItems[inCartIdx].qty - 1) <= 0 )
                    this.cartItems.splice(inCartIdx, 1)
                else
                    this.cartItems[inCartIdx].qty--
            }
        },
        cek() {
            if(this.cartItems.length) {
                this.cartItems.forEach(item => {
                    console.log(item.id, item.name, item.price, item.qty);
                    
                });
            } else 
                console.log("cartempty");
        }
    },
    mounted() {
        if(!!this.item) {
            this.sheet = true
        }
    }
}
</script>
