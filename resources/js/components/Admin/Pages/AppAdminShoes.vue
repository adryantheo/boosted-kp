<template>
    <v-container grid-list-lg class="my-3">
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
        <template v-else>
        <v-layout row wrap>
            <v-flex xs12>
            <v-layout justify-space-between align-center>
                <v-flex>
                    <p class="headline primary--text">Daftar Sepatu</p>
                </v-flex>
                <v-flex class="text-xs-right">
                    <v-btn color="primary" @click="openProductDialog">
                        <v-icon left>add</v-icon>
                        Sepatu Baru
                    </v-btn>
                </v-flex>
            </v-layout>
            </v-flex>
            <v-flex xs12 md6 lg4 v-for="(item, i) in productList" :key="`am-${i}`">
                <v-card class="rounded sepatu-card" height="100%">
                    <div>
                    <v-img class="sepatu-img"
                    :src="item.image"
                    :aspect-ratio="16/9"
                    ></v-img>

                    <v-card-text>
                        <p class="title font-weight-regular">{{ item.name }} ({{ item.gender }} {{item.size}})</p>
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
        </template>
        <v-dialog
            v-model="dialogCreateEditProduct"
            persistent max-width="600px"
        >
            <dialog-create-edit-product 
                @close="closeProduct" 
                @create_success="reloadProduct"
                :productId="parseInt(productId)"
                :key="dialogCreateEditProductKey"
            ></dialog-create-edit-product>
        </v-dialog>
    </v-container>
</template>
<script>
import DialogCreateEditProduct from './DialogCreateEditProduct'

export default {
    components: {
        DialogCreateEditProduct,
    },
    data: () => ({
        productId: 0,
        loading: false,
        productList: [],
        dialogCreateEditProduct: false,
        dialogCreateEditProductKey: 0,
    }),
    methods: {
        fetchProducts() {
            return axios.get('/api/products')
        },
        async getProducts() {
            this.loading = true;
            try {
                const res = await this.fetchProducts();
                this.productList = res.data.reverse();
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
        },
        openProductDialog() {
            this.dialogCreateEditProductKey = !!this.dialogCreateEditProductKey? 0 : 1;
            this.dialogCreateEditProduct = true;
        },
        editProduct(id) {
            this.productId = id;
            this.openProductDialog();
        },
        async deleteProduct(id) {
            const willDelete = confirm("Anda yakin ingin menghapus?");
            if(willDelete) {
                try {
                    const res = await axios.delete(`/api/products/${id}`, null);
                    console.log(res.data);
                    this.getProducts();
                } catch (err) {
                    console.log(err);
                }
            }
        },
        closeProduct() {
            this.dialogCreateEditProduct = false;
            this.productId = 0;
        },
        reloadProduct() {
            this.closeProduct();
            this.getProducts();
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>