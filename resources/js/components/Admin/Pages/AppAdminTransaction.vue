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
                    <p class="headline primary--text">Semua Transaksi</p>
                </v-flex>
            </v-layout>
            </v-flex>
            
        </v-layout>
        </template>
        <v-dialog
            v-model="dialogTransactionDetail"
            persistent max-width="600px"
        >
            <dialog-transaction-detail @close="dialogTransactionDetail = false"></dialog-transaction-detail>
        </v-dialog>
    </v-container>
</template>
<script>
import DialogTransactionDetail from './DialogTransactionDetail'

export default {
    components: {
        DialogTransactionDetail,
    },
    data: () => ({
        loading: false,
        transactions: [],
        dialogTransactionDetail: false,
    }),
    methods: {
        fetchTransactions() {
            // return axios.get('/api/transactions')
        },
        async getTransactions() {
            this.loading = true;
            try {
                const res = await this.fetchTransactions();
                this.transactions = res.data;
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
        },
    },
    mounted() {
        // this.getTransactions();
    }
}
</script>

