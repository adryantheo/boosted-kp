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
            <v-layout align-center>
                <v-flex>
                    <p class="headline primary--text">Semua Transaksi</p>
                </v-flex>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="getAllOrders">
                    <v-icon left>replay</v-icon>
                    muat ulang
                </v-btn>
                <v-btn color="success" @click="printOrders">
                    <v-icon left>print</v-icon>
                    cetak
                </v-btn>
            </v-layout>
            </v-flex>
            <v-flex xs12>
                <v-card>
                    <v-container grid-list-lg>
                    <v-layout row wrap>
                        <v-flex xs12 md6>
                            <v-card color="blue-grey darken-3" dark>
                                <v-card-text>
                                    <p class="subheading">Total Produk Terjual</p>
                                    <div class="headline">
                                        {{ getTotalSold }} item
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-flex>
                        <v-flex xs12 md6>
                            <v-card color="blue-grey darken-3" dark>
                                <v-card-text>
                                    <p class="subheading">Total Pendapatan</p>
                                    <div class="headline">
                                        {{ $rupiahFormat(getTotalEarnings) }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
                    <v-data-table
                        :headers="headers"
                        :items="items"
                        disable-initial-sort
                        :loading="loading"
                        rows-per-page-text="Baris per halaman"
                    >
                        <template v-slot:items="props">
                            <td>{{ props.item.id }}</td>
                            <td>{{ props.item.date }}</td>
                            <td>{{ props.item.brand }}</td>
                            <td>{{ props.item.menu }}</td>
                            <td>{{ props.item.customer }}</td>
                            <td class="text-xs-right">{{ props.item.qty }}</td>
                            <td class="text-xs-right">{{ $rupiahFormat(props.item.price) }}</td>
                            <td class="text-xs-right">{{ $rupiahFormat(props.item.total) }}</td>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>
        </template>

        <div v-show="false" id="printMe">
            <div class="ma-3">
                <div class="text-xs-center">
                    <p class="headline">Laporan Riwayat Transaksi</p>
                    <p class="title">Seluruh Brand</p>
                </div>
                <div>
                    <table class="orders">
                        <tr>
                            <th>Id order</th>
                            <th>Tanggal order</th>
                            <th>Brand</th>
                            <th>Menu</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                        <template v-for="(item, i) in items">
                            <tr :key="i">
                                <td>{{ item.id }}</td>
                                <td>{{ item.date }}</td>
                                <td>{{ item.brand }}</td>
                                <td>{{ item.menu }}</td>
                                <td>{{ item.customer }}</td>
                                <td class="text-xs-right">{{ item.qty }}</td>
                                <td class="text-xs-right">{{ $rupiahFormat(item.price) }}</td>
                                <td class="text-xs-right">{{ $rupiahFormat(item.total) }}</td>
                            </tr>
                        </template>
                        <tfoot class="title">
                            <tr>
                                <td class="text-xs-right" colspan="6">Total produk terjual</td>
                                <td>{{ getTotalSold }} item</td>
                            </tr>
                            <tr>
                                <td class="text-xs-right" colspan="7">Total pendapatan</td>
                                <td>{{ $rupiahFormat(getTotalEarnings) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </v-container>
</template>
<script>
export default {
    data: () => ({
        loading: false,
        headers: [
            { text: 'ID', value: 'id', sortable: false },
            { text: 'Tgl order', value: 'date' },
            { text: 'Nama brand', value: 'brand'},
            { text: 'Nama menu', value: 'menu', sortable: false  },
            { text: 'Pelanggan', value: 'customer', sortable: false },
            { text: 'Jumlah', value: 'qty' },
            { text: 'Harga', value: 'price' },
            { text: 'Total', value: 'total' },
        ],
        items: [],
        dialogTransactionDetail: false,
    }),
    computed: {
        getTotalSold() {
            return this.items.reduce((acc, item) => acc + item.qty, 0);
        }, 
        getTotalEarnings() {
            return this.items.reduce((acc, item) => acc + item.total, 0);
        }, 
    },
    methods: {
        fetchAllOrders() {
            return axios.get('/api/orders-all');
        },
        async getAllOrders() {
            this.loading = true;
            try {
                const res = await this.fetchAllOrders();
                this.items = res.data.map(item => ({
                    id: item.id,
                    date: item.created_at,
                    brand: item.product.brand.name,
                    menu: item.product.name,
                    customer: item.nota.customer,
                    price: item.harga_satuan,
                    qty: item.quantity,
                    total: (item.quantity * item.harga_satuan)
                }));
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
        },
        printOrders() {
            this.$htmlToPaper('printMe');
        },
    },
    mounted() {
        this.getAllOrders();
    }
}
</script>

