<template>
    <v-card>
        <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">Stand Baru</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('close')">
                <v-icon>close</v-icon>
            </v-btn>
        </v-toolbar>
        <v-card-text v-if="dialogLoading" class="text-xs-center">
            <v-progress-circular
                :size="70"
                :width="7"
                color="primary"
                indeterminate
            ></v-progress-circular>
        </v-card-text>
        <v-form ref="form_new_stand" @submit.prevent="createNewStand" v-show="!dialogLoading">
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
                <v-btn color="primary" large type="submit" :loading="btnLoading">
                    <v-icon left>
                        {{ !!standId? 'save' : 'add'}}
                    </v-icon>
                    {{ !!standId? 'simpan' : 'buat stand'}}
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
export default {
    props: {
        standId: {
            type: Number,
            required: true,
        }
    },
    data: () => ({
        dialogLoading: true,
        btnLoading: false,
        name: null,
        description: null,

        rules: {
            required: v => !!v || 'Harus diisi',
        },
    }),
    methods: {
        async createNewStand() {
            if(this.$refs.form_new_stand.validate()) {
                this.btnLoading = true;
                try {
                    if(!this.standId) {
                        const res = await axios.post('/api/stands', {
                            name: this.name,
                            description: this.description
                        })
                        alert("Stand berhasil dibuat");
                    } else {
                        const res = await axios.patch(`/api/stands/${this.standId}`, {
                            name: this.name,
                            description: this.description
                        })
                        alert("Stand berhasil diubah");
                    }
                } catch (err) {
                    console.log(err);
                }
                this.$emit('create_success');
            }
        },
    },
    async mounted() {
        if(!!this.standId) {
            const res = await axios.get(`/api/stands/${this.standId}`)
            this.name = res.data[0].name
            this.description = res.data[0].description
        }
        this.dialogLoading = false;
        this.$nextTick(() => this.$refs.name.focus());
    }
}
</script>
