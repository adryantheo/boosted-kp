<template>
    <v-container grid-list-lg>
        <v-layout row align-center>
            <v-btn fab dark color="primary" to="/admin/stands">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <div class="ml-4">
                <div class="headline font-weight-bold mb-1">Stand {{ name }}</div>
                <div class="subheading">{{ description }}</div>
            </div>
        </v-layout>

        <v-divider class="my-4"></v-divider>

        <v-layout row align-center>
            <div class="subheading font-weight-bold">
                Daftar Menu
            </div>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="makeNewProduct">
                <v-icon left>add</v-icon>
                menu baru
            </v-btn>
        </v-layout>
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
                </v-card>
            </v-flex>
        </v-layout>
        <v-dialog
            v-model="dialogNewProduct"
            persistent max-width="600px"
        >
            <dialog-new-product @close="dialogNewProduct = false" :key="dialogNewProductKey"></dialog-new-product>
        </v-dialog>
    </v-container>
</template>
<script>
import { mapMutations } from 'vuex'
import { mapGetters } from 'vuex'
import DialogNewProduct from './DialogNewProduct'

export default {
    components: {
        DialogNewProduct,
    },
    props: {
        stand: {
            type: String,
            required: true,
        },
    },
    data: () => ({
        name: "",
        description: "",
        standProducts: [],
        dialogNewProduct: false,
        dialogNewProductKey: 0,
    }),
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
            const stand = res.data[0];
            this.name = stand.name;
            this.description = stand.description;
            this.standProducts = stand.products;
        },
        makeNewProduct() {
            this.dialogNewProductKey = !!this.dialogNewProductKey? 0 : 1;
            this.dialogNewProduct = true;
        },
    },
    mounted() {
        this.fetchStandDetails();
    }
}
</script>
