<template>
    <v-app>
        <v-toolbar app dense clipped-left>
            <v-toolbar-side-icon
                @click.stop="drawer = !drawer"
            ></v-toolbar-side-icon>
        </v-toolbar>
        <v-navigation-drawer app clipped v-model="drawer">
            <v-list>
                <v-list-tile
                    v-for="(item, index) in routes"
                    router
                    :to="item.route"
                    :key="'sepatu'+index"
                    >
                    <v-list-tile-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>

                <v-divider dark class="my-3"></v-divider>
                
                <v-list-tile @click="logout">
                    <v-list-tile-action>
                        <v-icon>power_settings_new</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>
<script>
import { mapActions } from 'vuex'

export default {
    data: () => ({
        drawer: true,
        routes: [
            {
                icon: "store_mall_directory",
                title: "Sepatu",
                route: "/admin/shoes",
            },
            {
                icon: "receipt",
                title: "Transaksi",
                route: "/admin/transactions",
            },
        ],
    }),
    methods: {
        ...mapActions([
            'logoutRequest'
        ]),
        async logout() {
            try {
                await this.logoutRequest()
                this.$router.replace({path: "/login"})
            } catch (err) {
                alert(err);
            }
        },
    },
}
</script>
