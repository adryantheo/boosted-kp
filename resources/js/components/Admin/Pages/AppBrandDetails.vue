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
                <v-btn fab dark color="primary" to="/admin/brands">
                    <v-icon>arrow_back</v-icon>
                </v-btn>
                <div class="ml-4">
                    <div class="headline font-weight-bold mb-1">Brand {{ name }}</div>
                    <div class="subheading">{{ description }}</div>
                </div>
            </v-layout>

            <v-divider class="my-4"></v-divider>
            <v-tabs
                icons-and-text
                v-model="activeTab" color="transparent"
                slider-color="primary"
            >
                <v-tab
                    v-for="(item, i) in tabItems"
                    :key="i" ripple
                    :href="`#tab-${i}`"
                >
                    {{ item.name }}
                    <v-icon>{{ item.icon }}</v-icon>
                </v-tab>
                <v-tab-item value="tab-0">
                <v-container grid-list-lg>
                    <v-layout row align-center class="mt-2 mb-3">
                        <div class="subheading font-weight-bold">
                            Daftar Sepatu
                        </div>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="openProductDialog">
                            <v-icon left>add</v-icon>
                            sepatu baru
                        </v-btn>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 md6 lg4 v-for="(item, i) in brandProducts" :key="`am-${i}`">
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
                    <v-dialog
                        v-model="dialogCreateEditProduct"
                        persistent max-width="600px"
                    >
                        <dialog-create-edit-product 
                            @close="closeProduct" 
                            @create_success="reloadProduct"
                            :productId="parseInt(productId)" 
                            :brand="parseInt(brand)"
                            :key="dialogCreateEditProductKey">
                        </dialog-create-edit-product>
                    </v-dialog>
                </v-container>
                </v-tab-item>
                <v-tab-item value="tab-1">
                <v-container grid-list-lg>
                    <v-layout row align-center class="mt-2 mb-3">
                        <div class="subheading font-weight-bold">
                            Riwayat Order
                        </div>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="reloadOrders" :loading="reloadLoading">
                            <v-icon left>replay</v-icon>
                            muat ulang
                        </v-btn>
                        <v-btn color="success" @click="printOrders">
                            <v-icon left>print</v-icon>
                            cetak
                        </v-btn>
                    </v-layout>
                    <v-layout row wrap>
                        <brand-order-table
                            :brandName="name"
                            :brandId="brand"
                        ></brand-order-table>
                    </v-layout>
                </v-container>
                </v-tab-item>
            </v-tabs>
        </div>
    </v-container>
</template>
<script>
import DialogCreateEditProduct from './DialogCreateEditProduct'
import BrandOrderTable from './BrandOrderTable'

export default {
    components: {
        DialogCreateEditProduct,
        BrandOrderTable,
    },
    props: {
        brand: {
            type: String,
            required: true,
        },
    },
    data: () => ({
        activeTab: null,
        tabItems: [
            {name: "Daftar Sepatu", icon: "local_dining"},
            {name: "Riwayat Order", icon: "receipt"},
        ],

        productId: 0,
        loading: false,
        reloadLoading: false,
        name: "",
        description: "",
        brandProducts: [],
        dialogCreateEditProduct: false,
        dialogCreateEditProductKey: 0,
    }),
    methods: {
        fetchBrandDetails() {
            return axios.get(`/api/brands/${this.brand}`);
        },
        async getBrandDetails() {
            this.loading = true;
            try {
                const res = await this.fetchBrandDetails();
                const brand = res.data;
                this.name = brand.name;
                this.description = brand.description;
                this.brandProducts = brand.products.reverse();
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
                    this.getBrandDetails();
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
            this.getBrandDetails();
        },
        reloadOrders() {
            this.reloadLoading = true;
            EventBus.$emit('reload_orders');
        },
        printOrders() {
            EventBus.$emit('print_orders');
        },
    },
    mounted() {
        this.getBrandDetails();
        EventBus.$on('reload_orders_done',() => {
            this.reloadLoading = false;
        })
    }
}
</script>
