<template>
    <div>
        <v-parallax
            dark
            src="/assets/main-bg.png"
            height="600"
        >
            <v-layout align-center>
                <v-flex xs4 lg3 class="pa-4">
                    <v-img
                        src="https://seeklogo.com/images/R/restaurant-chief-food-hotel-logo-9DE9D03812-seeklogo.com.png"
                        max-height="200" contain
                    ></v-img>
                </v-flex>
                <v-flex>
                    <h1 class="display-3 mb-3">PL Food Bazaar</h1>
                    <h4 class="display-1 font-weight-light">Enjoy homemade foods today!</h4>
                </v-flex>
            </v-layout>
        </v-parallax>
        <v-container grid-list-lg class="my-5">
            
            <v-divider class="my-3"></v-divider>
            
            <v-layout justify-space-between>
                <v-flex>
                    <p class="display-1 primary--text">Daftar Stand</p>
                </v-flex>
                <v-flex class="text-xs-right">
                    <v-btn color="primary" @click="loadRandomStand">
                        <v-icon left>replay</v-icon>
                        Muat lain
                    </v-btn>
                </v-flex>
            </v-layout>

            <v-layout row wrap>
                <v-flex xs12 sm6 md4 lg3 v-for="n in 5" :key="`a${n}`">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    :to="`/stand/${n}`"
                >
                    <v-img
                    src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
                    height="180"
                    ></v-img>

                    <v-card-title>
                        <span class="headline">Cafe Badilico</span>
                    </v-card-title>
                    <v-card-text class="grey--text text--darken-2 pt-0">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et magnam porro quos. Dolorum, suscipit incidunt! Iure quo consequatur vero esse reprehenderit laborum adipisci, possimus exercitationem libero suscipit corrupti sit in!
                    </v-card-text>
                </v-card>
                </v-flex>
                <v-flex xs12 sm6 md4 lg3>
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    to="/all-stand" height="100%"
                >
                    <v-layout column fill-height justify-center>
                        <v-card-text class="px-4">
                            <v-img
                                src="/assets/svg/stands.svg"
                                height="180"
                                contain
                            ></v-img>
                        </v-card-text>
                        <v-card-text class="headline primary--text font-weight-light text-xs-center">
                            Lihat Semua
                        </v-card-text>
                    </v-layout>
                </v-card>
                </v-flex>
            </v-layout>

            <v-divider class="my-3"></v-divider>
            <v-layout justify-space-between>
                <v-flex>
                    <p class="display-1 primary--text">Daftar Menu</p>
                </v-flex>
                <v-flex class="text-xs-right">
                    <v-btn color="primary" @click="loadRandomMenu">
                        <v-icon left>replay</v-icon>
                        Muat lain
                    </v-btn>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 sm6 md4 lg3 v-for="n in 6" :key="`a${n}`">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    :to="`/stand/${n}/awawawi`"
                >
                    <v-img
                    src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
                    :aspect-ratio="16/9"
                    ></v-img>

                    <v-card-text>
                        <p class="title">Kangaroo Valley Safari</p>
                        <p class="subheading">{{ $rupiahFormat(3000) }}</p>
                    </v-card-text>

                </v-card>
                </v-flex>
                <v-flex xs12 sm6 md4 lg3>
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    to="/all-menu" height="100%"
                >
                    <v-layout column fill-height justify-center>
                        <v-card-text class="px-4">
                            <v-img
                                src="/assets/svg/foods.svg"
                                height="180"
                                contain
                            ></v-img>
                        </v-card-text>
                        <v-card-text class="headline primary--text font-weight-light text-xs-center">
                            Lihat Semua
                        </v-card-text>
                    </v-layout>
                </v-card>
                </v-flex>
            </v-layout>
        </v-container>    
    </div>
</template>
<script>
export default {
    data() {
        return {
            randomStandLoading: false,
            randomMenuLoading: false,
        }
    },
    methods: {
        loadRandomStand() {
            this.randomStandLoading = true;
            setTimeout(() => {
                this.randomStandLoading = false;
            }, 500);
        },
        loadRandomMenu() {
            this.randomMenuLoading = true;
            setTimeout(() => {
                this.randomMenuLoading = false;
            }, 500);
        },
    },
}
</script>
