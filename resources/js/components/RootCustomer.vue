<template>
    <v-app>
        <!-- <v-toolbar
            color="blue-grey"
            dark fixed app
        >
            <v-toolbar-title>PL Food Bazaar</v-toolbar-title>
        </v-toolbar> -->
        <v-content>
            <router-view></router-view>
        </v-content>
        <v-dialog
            v-model="cartDialog"
            scrollable persistent
            max-width="600px"
        >
            <v-card>
                <v-toolbar flat color="transparent">
                    <v-btn icon flat>
                        <v-icon>shopping_cart</v-icon>
                    </v-btn>
                    <div class="headline">
                        Keranjang anda
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="closeDialog">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-toolbar>

                <v-window v-model="step">
                <v-window-item :value="1">
                    <v-card-text>
                    <v-layout column>
                        <v-flex v-for="(item, i) in getCartItems" :key="`cartItemsName-${i}`" class="subheading mb-2">
                        <v-layout row wrap>
                            <v-flex xs12 class="title">
                                {{ item.name }}
                            </v-flex>
                            <v-flex xs6>
                                {{ item.qty }} x {{ $rupiahFormat(item.price) }}
                            </v-flex>
                            <v-flex xs6 class="text-xs-right font-weight-bold">
                                {{ $rupiahFormat(item.price * item.qty) }} 
                            </v-flex>
                        </v-layout>
                        </v-flex>
                        <v-flex>
                        <v-divider class="my-3"></v-divider>
                        <v-layout row wrap justify-end class="text-xs-right subheading">
                            <v-flex>
                                Subtotal
                            </v-flex>
                            <v-flex class="title primary--text">
                                {{ $rupiahFormat(getSubtotal) }}
                            </v-flex>
                        </v-layout>
                        </v-flex>
                    </v-layout>
                    </v-card-text>
                </v-window-item>

                <v-window-item :value="2">
                    <v-card-text>
                    <v-text-field
                        v-model="ordererName"
                        label="Nama anda"
                        type="text"
                        ref="orderer_name"
                    ></v-text-field>
                    </v-card-text>
                </v-window-item>
                </v-window>

                <v-card-actions>
                <v-btn
                    :disabled="step === 1"
                    large flat
                    @click="step--"
                >
                    Kembali
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="step === 2" large
                    color="success" @click="createOrder"
                    :disabled="!ordererName"
                    :loading="loading"
                >
                    Pesan
                </v-btn>
                <v-btn
                    v-else large
                    color="success"
                    outline @click="toPayment"
                >
                    Lanjut
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-fab-transition>
            <v-btn
                color="primary"
                fab dark large
                bottom right fixed
                @click="cartDialog = true"
                v-show="!!getCartItems.length"
            >
                <v-icon>shopping_cart</v-icon>
            </v-btn>
        </v-fab-transition>
    </v-app>
</template>
<script>
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'

export default {
    data: () => ({
        cartDialog: false,
        step: 1,
        ordererName: "",
        loading: false,
    }),
    computed: {
        ...mapGetters([
            'getCartItems'
        ]),
        getSubtotal() {
            const total = this.getCartItems.reduce((acc, item) => acc + (item.price * item.qty), 0)
            return total
        }
    },
    methods: {
        ...mapActions([
            'makeOrder',
        ]),
        async createOrder() {
            this.loading = true;
            try {
                const res = await this.makeOrder(this.ordererName);
                alert("Pesanan berhasil dibuat");
                
                const print = await axios.get(`/api/nota/${res.data.nota_id}`);
                console.log(print.data);

            } catch (err) {
                alert("Pesanan gagal dibuat!");
                console.log(err);
            }
            this.cartDialog = false;
            location.reload();
            // this.$htmlToPaper('printMe');
        },
        closeDialog() {
            this.cartDialog = false;
            this.step = 1;
        },
        toPayment() {
            this.step++;
            setTimeout(() => {
                this.$refs.orderer_name.focus();
            }, 300);
        },
    }
}
</script>