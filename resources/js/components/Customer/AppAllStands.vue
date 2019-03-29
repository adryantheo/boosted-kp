<template>
    <v-container grid-list-lg class="my-5">
        <v-layout align-center>
            <v-btn fab dark color="primary" @click="$router.go(-1)">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <div class="ml-4 headline font-weight-bold">
                Semua Stand
            </div>
        </v-layout>

        <v-divider class="my-4"></v-divider>
        
        <v-layout row wrap>
            <v-flex xs12 sm6 md4 lg3 v-for="(item, id) in stands" :key="`stand-${id}`">
                <v-card class="rounded" hover
                    :ripple="{ class: 'primary--text' }"
                    :to="`/stands/${item.id}`" height="100%"
                >
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
    </v-container>
</template>
<script>
export default {
    data() {
        return {
            stands: [],
        }
    },
    methods: {
        async getStands() {
            const res = await axios.get('api/stands')
            this.stands = res.data;
        }
    },
    mounted() {
        this.getStands();
    }
}
</script>
