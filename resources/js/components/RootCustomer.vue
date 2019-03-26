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
                <v-toolbar flat dark color="primary">
                    <v-btn icon flat>
                        <v-icon>shopping_cart</v-icon>
                    </v-btn>
                    <div class="headline">
                        Keranjang anda
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="cartDialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-toolbar>
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
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn large color="green" dark>
                        <v-icon>attach_money</v-icon>
                        pesan
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

export default {
    data() {
        return {
            cartDialog: false,
        }
    },
    computed: {
        ...mapGetters([
            'getCartItems'
        ]),
        getSubtotal() {
            const total = this.getCartItems.reduce((acc, item) => acc + (item.price * item.qty), 0)
            return total
        }
    },
}
</script>