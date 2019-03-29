<template>
    <v-card>
        <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">Stand Baru</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('close')">
                <v-icon>close</v-icon>
            </v-btn>
        </v-toolbar>

        <v-form ref="form_new_stand" @submit.prevent="createNewStand">
            <v-card-text>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field
                            label="Nama stand"
                            v-model="name"
                            :rules="[rules.required]"
                            ref="name"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-textarea
                            label="Deskripsi stand"
                            v-model="description"
                            :rules="[rules.required]"
                            rows="3"
                        ></v-textarea>
                    </v-flex>
                </v-layout>
            </v-container>     
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" large type="submit">
                    buat produk
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
export default {
    data: () => ({
        name: null,
        description: null,

        rules: {
            required: v => !!v || 'Harus diisi',
        },
    }),
    methods: {
        async createNewStand() {
            if(this.$refs.form_new_stand.validate()) {
                const res = await axios.post('/api/stands', {
                    name: this.name,
                    description: this.description
                })
                console.log(res.data);
            }
        },
    },
}
</script>
