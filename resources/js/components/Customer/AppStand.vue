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
    },
    mounted() {
        this.fetchStandDetails();
    }
}
</script>
