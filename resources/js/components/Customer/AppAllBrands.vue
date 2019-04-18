<template>
    <v-container grid-list-lg class="my-5">
        <v-layout align-center>
            <v-btn fab dark color="primary" @click="$router.go(-1)">
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <div class="ml-4 headline font-weight-bold">
                Semua Brand
            </div>
        </v-layout>

        <v-divider class="my-4"></v-divider>
        
        <v-layout row wrap justify-center>
            <v-flex xs12 sm8 lg6>
                <v-text-field
                    solo
                    label="Cari brand"
                    clearable
                    v-model="querySearch"
                >
                    <v-icon>search</v-icon>
                </v-text-field>
            </v-flex>
        </v-layout>

        <v-layout row wrap>
            <v-flex xs12 md6 xl4 v-for="(item, id) in getFilteredBrands" :key="`brand-${id}`">
                <brand-card :item="item"></brand-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import BrandCard from './BrandCard'

export default {
    components: {
        BrandCard,
    },
    data() {
        return {
            brands: [],
            querySearch: "",
        }
    },
    computed: {
        getFilteredBrands() {
            if(!!this.querySearch) {
                return this.brands.filter((item) => {
                    const hasName = item.name.toLowerCase().replace(/ /g,'').indexOf(this.querySearch.toLowerCase()) >= 0

                    const hasDesc = item.description.toLowerCase().replace(/ /g,'').indexOf(this.querySearch.toLowerCase()) >= 0
                    
                    return (hasName || hasDesc);
                });
            } else {
                return this.brands;
            }
        },
    },
    methods: {
        async getBrands() {
            const res = await axios.get('/api/brands');
            this.brands = res.data;
        }
    },
    mounted() {
        this.getBrands();
    }
}
</script>
