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
            <v-flex xs12 md6 xl4 v-for="(item, id) in stands" :key="`stand-${id}`">
                <stand-card :item="item"></stand-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import StandCard from './StandCard'

export default {
    components: {
        StandCard,
    },
    data() {
        return {
            stands: [],
        }
    },
    methods: {
        async getStands() {
            const res = await axios.get('/api/stands');
            this.stands = res.data;
        }
    },
    mounted() {
        this.getStands();
    }
}
</script>
