<template>
    <div style="width: 100%">
        <v-card>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12 md6>
                        <v-card color="blue-grey darken-3" dark>
                            <v-card-text>
                                <p class="subheading">Produk terjual</p>
                                <div class="headline">
                                    {{ getTotalSold }} item
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-card color="blue-grey darken-3" dark>
                            <v-card-text>
                                <p class="subheading">Pendapatan saat ini</p>
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
                    <td>{{ props.item.sepatu }}</td>
                    <td>{{ props.item.customer }}</td>
                    <td class="text-xs-right">{{ props.item.qty }}</td>
                    <td class="text-xs-right">{{ $rupiahFormat(props.item.price) }}</td>
                    <td class="text-xs-right">{{ $rupiahFormat(props.item.total) }}</td>
                </template>
            </v-data-table>
        </v-card>
        <div v-show="false" id="printMe">
            <div class="ma-3">
                <div class="text-xs-center">
                    <p class="headline">Laporan Riwayat Transaksi</p>
                    <p class="title">Brand {{ brandName }}</p>
                </div>
                <div>
                    <table class="orders">
                        <tr>
                            <th>Id order</th>
                            <th>Tanggal order</th>
                            <th>Sepatu</th>
                            <th>Pelanggan</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                        <template v-for="(item, i) in items">
                            <tr :key="i">
                                <td>{{ item.id }}</td>
                                <td>{{ item.date }}</td>
                                <td>{{ item.sepatu }}</td>
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
                                <td class="text-xs-right" colspan="6">Total pendapatan</td>
                                <td>{{ $rupiahFormat(getTotalEarnings) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        brandName: {
            type: String,
            required: true,
        },
        brandId: {
            type: String,
            required: true,
        },
    },
    data: () => ({
        loading: false,
        headers: [
            { text: 'ID', value: 'id', sortable: false },
            { text: 'Tgl order', value: 'date' },
            { text: 'Nama sepatu', value: 'sepatu', sortable: false  },
            { text: 'Pelanggan', value: 'customer', sortable: false },
            { text: 'Jumlah', value: 'qty' },
            { text: 'Harga', value: 'price' },
            { text: 'Total', value: 'total' },
        ],
        items: [],
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
        print() {
            this.$htmlToPaper('printMe');
        },
        fetchBrandOrders() {
            return axios.get('/api/orders', {
                params: {
                    brand: this.brandId
                }
            });
        },
        async getBrandOrders() {
            this.loading = true;
            try {
                const res = await this.fetchBrandOrders();
                let tes = res.data.filter(item => !!item.product);

                this.items = tes.map(item => ({
                    id: item.id,
                    date: item.created_at,
                    sepatu: item.product.name,
                    customer: item.nota.customer,
                    price: item.harga_satuan,
                    qty: item.quantity,
                    total: (item.quantity * item.harga_satuan)
                }));

                console.log(this.items);
                
            } catch (err) {
                console.log(err);
            }
            this.loading = false;
            EventBus.$emit('reload_orders_done');
        },
    },
    mounted() {
        this.getBrandOrders();
        EventBus.$on('reload_orders',() => {
            this.getBrandOrders();
        }); 
        EventBus.$on('print_orders',() => {
            this.$htmlToPaper('printMe');
        }); 
    },
}
</script>