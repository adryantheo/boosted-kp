<template>
    <div>
        <v-parallax
            dark
            src="/assets/brands_bg.jpg"
            height="300"
        >
        </v-parallax>

        <v-container grid-list-lg class="my-3">
            <v-layout row align-center>
                <v-btn fab dark color="primary" @click="$router.go(-1)">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
                <div class="ml-4">
                    <div class="headline font-weight-bold mb-1">Brand {{ name }}</div>
                    <div class="subheading">{{ description }}</div>
                </div>
            </v-layout>
            
            <v-divider class="my-4"></v-divider>

            <p class="subheading font-weight-bold">
                Daftar Sepatu
            </p>
            <v-layout row wrap>
                <v-flex xs12 md4 lg3  v-for="(item, i) in brandProducts" :key="`am-${i}`">
                    <product-card :item="item"></product-card>
                </v-flex>
            </v-layout>
        </v-container>

    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import ProductCard from './ProductCard'

export default {
    components: {
        ProductCard,
    },
    props: {
        brand: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            name: "",
            description: "",
            brandProducts: [],
        }
    },
    computed: {
        ...mapGetters([
            'getCartItems'
        ]),
    },
    methods: {
        async fetchBrandDetails() {
            const res = await axios.get(`/api/brands/${this.brand}`);
            const brand = res.data;
            this.name = brand.name;
            this.description = brand.description;
            this.brandProducts = brand.products.map((item) => {
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
    },
    mounted() {
        this.fetchBrandDetails();
    }
}
</script>
