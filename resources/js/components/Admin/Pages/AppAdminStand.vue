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
                    <p class="headline primary--text">Semua Stand</p>
                </v-flex>
                <v-flex class="text-xs-right">
                    <v-btn color="primary" @click="makeNewStand">
                        <v-icon left>add</v-icon>
                        Stand Baru
                    </v-btn>
                </v-flex>
            </v-layout>
            </v-flex>
            <v-flex xs12 md6 lg4 v-for="(item, i) in stands" :key="`prod-${i}`">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    :to="`/admin/stands/${item.id}`" height="100%">
                    <v-img
                    src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
                    height="180"
                    ></v-img>

                    <v-card-title>
                        <span class="headline">{{ item.name }}</span>
                    </v-card-title>
                    <v-card-text class="grey--text text--darken-2 pt-0">
                        {{ item.description }}
                    </v-card-text>
                    <v-card-text class="font-weight-bold blue--text">
                        {{ item.products.length }} MENU
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        </template>
        <v-dialog
            v-model="dialogNewStand"
            persistent max-width="600px"
        >
            <dialog-new-stand @close="dialogNewStand = false"  @create_success="reloadStand" :key="dialogNewStandKey"></dialog-new-stand>
        </v-dialog>
    </v-container>
</template>
<script>
import DialogNewStand from './DialogNewStand'

export default {
    components: {
        DialogNewStand,
    },
    data: () => ({
        loading: false,
        stands: [],
        dialogNewStand: false,
        dialogNewStandKey: 0,
    }),
    methods: {
        fetchProducts() {
            return axios.get('/api/stands')
        },
        async getProducts() {
            this.loading = true;
            try {
                const res = await this.fetchProducts();
                this.stands = res.data;
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
        },
        makeNewStand() {
            this.dialogNewStandKey = !!this.dialogNewStandKey? 0 : 1;
            this.dialogNewStand = true;
        },
        reloadStand() {
            this.dialogNewStand = false;
            this.getProducts()
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>