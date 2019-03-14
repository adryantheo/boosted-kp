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
    </v-app>    
</template>
<script>
export default {
    data() {
        return {
            drawer: true,
        }
    }
}
</script>