<template>
    <v-container grid-list-lg>
        <v-layout row wrap v-if="loading">
            <v-flex xs12 class="text-xs-center">
                <v-progress-circular
                    :size="70"
                    :width="7"
                    color="primary"
                    indeterminate
                ></v-progress-circular>
            </v-flex>
        </v-layout>
        <div v-show="!loading">
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
                <v-flex xs12 md6 xl4 v-for="(item, i) in standProducts" :key="`am-${i}`">
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
                            <v-btn color="warning" flat round @click="editProduct(item.id)">
                                <v-icon left>create</v-icon>
                                edit
                            </v-btn>
                            <v-btn color="error" flat round @click="deleteProduct(item.id)">
                                <v-icon left>delete</v-icon>
                                delete
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
            <v-dialog
                v-model="dialogNewProduct"
                persistent max-width="600px"
            >
                <dialog-new-product @close="dialogNewProduct = false" :stand="stand" :key="dialogNewProductKey"></dialog-new-product>
            </v-dialog>
        </div>

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
        loading: false,
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
        fetchStandDetails() {
            return axios.get(`/api/stands/${this.stand}`);
        },
        async getStandDetails() {
            this.loading = true;
            try {
                const res = await this.fetchStandDetails();
                const stand = res.data[0];
                this.name = stand.name;
                this.description = stand.description;
                this.standProducts = stand.products;
            } catch (err) {
                console.log(err);
            }    
            this.loading = false;    
        },
        makeNewProduct() {
            this.dialogNewProductKey = !!this.dialogNewProductKey? 0 : 1;
            this.dialogNewProduct = true;
        },
        editProduct() {

        },
        async deleteProduct(id) {
            const willDelete = confirm("Anda yakin ingin menghapus?");
            if(willDelete) {
                try {
                    const res = await axios.delete(`/api/products/${id}`, null);
                    console.log(res.data);
                    this.getStandDetails();
                } catch (err) {
                    console.log(err);
                }
            }
        }
    },
    mounted() {
        this.getStandDetails();
    }
}
</script>
