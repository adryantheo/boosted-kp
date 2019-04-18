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
                    <p class="headline primary--text">Semua Brand</p>
                </v-flex>
                <v-flex class="text-xs-right">
                    <v-btn color="primary" @click="openBrandDialog">
                        <v-icon left>add</v-icon>
                        Brand Baru
                    </v-btn>
                </v-flex>
            </v-layout>
            </v-flex>
            <v-flex xs12 md6 xl4 v-for="(item, i) in brands" :key="`prod-${i}`">
                <v-card class="rounded" height="100%">
                    <v-img
                    :src="item.image"
                    height="180"
                    ></v-img>
                    <v-card-title>
                        <span class="headline">{{ item.name }}</span>
                    </v-card-title>
                    <v-card-text class="grey--text text--darken-2 pt-0">
                        {{ item.description }}
                    </v-card-text>
                    <v-card-text class="font-weight-bold blue--text">
                        {{ item.products.length }} PRODUK
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="indigo" flat round  :to="`/admin/brands/${item.id}`">
                            <v-icon left>info</v-icon>
                            detail
                        </v-btn>
                        <v-btn color="warning" flat round @click="editBrand(item.id)">
                            <v-icon left>create</v-icon>
                            edit
                        </v-btn>
                        <v-btn color="error" flat round @click="deleteBrand(item.id)">
                            <v-icon left>delete</v-icon>
                            delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        </template>
        <v-dialog
            v-model="dialogCreateEditBrand"
            persistent max-width="600px"
        >
            <dialog-create-edit-brand 
                :brandId="parseInt(brandId)"
                @close="closeBrand"  
                @create_success="reloadBrand" 
                :key="dialogCreateEditBrandKey">
            </dialog-create-edit-brand>
        </v-dialog>
    </v-container>
</template>
<script>
import DialogCreateEditBrand from './DialogCreateEditBrand'

export default {
    components: {
        DialogCreateEditBrand,
    },
    data: () => ({
        brandId: 0,
        loading: false,
        brands: [],
        dialogCreateEditBrand: false,
        dialogCreateEditBrandKey: 0,
    }),
    methods: {
        fetchBrands() {
            return axios.get('/api/brands')
        },
        async getBrands() {
            this.loading = true;
            try {
                const res = await this.fetchBrands();
                this.brands = res.data.reverse();
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
        },
        openBrandDialog() {
            this.dialogCreateEditBrandKey = !!this.dialogCreateEditBrandKey? 0 : 1;
            this.dialogCreateEditBrand = true;
        },
        editBrand(id) {
            this.brandId = id;
            this.openBrandDialog();
        },
        async deleteBrand(id) {
            const willDelete = confirm("Anda yakin ingin menghapus?");
            if(willDelete) {
                try {
                    const res = await axios.delete(`/api/brands/${id}`, null);
                    console.log(res.data);
                    this.getBrands();
                } catch (err) {
                    console.log(err);
                }
            }
        },
        closeBrand() {
            this.dialogCreateEditBrand = false;
            this.brandId = 0;
        },
        reloadBrand() {
            this.closeBrand();
            this.getBrands();
        }
    },
    mounted() {
        this.getBrands();
    }
}
</script>