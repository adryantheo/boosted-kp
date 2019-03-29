<template>
    <v-container grid-list-lg class="my-3">
        <v-layout row wrap v-if="loading">
            <v-flex xs12 class="text-xs-center" v-if="loading">
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
                    <p class="headline primary--text">Semua Produk</p>
                </v-flex>
            </v-layout>
            </v-flex>
            <v-flex xs12 md6 lg4 v-for="(item, i) in products" :key="`prod-${i}`">
                <v-card>
                    <v-card-text>
                        {{ item.name }}
                    </v-card-text>
                    <v-card-text>
                        {{ item.description }}
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        </template>
    </v-container>
</template>
<script>
export default {
    data: () => ({
        loading: false,
        products: [],
    }),
    methods: {
        fetchProducts() {
            return axios.get('/api/products')
        },
        async getProducts() {
            this.loading = true;
            try {
                const res = await this.fetchProducts();
                this.products = res.data;
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
        },
    },
    mounted() {
        this.getProducts();
    }
}
</script>

