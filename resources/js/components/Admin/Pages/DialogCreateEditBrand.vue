<template>
    <v-card>
        <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">
                {{ !!brandId? 'Ubah Brand' : 'Brand Baru'}}
            </v-toolbar-title>
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
        <v-form ref="form_new_brand" @submit.prevent="createNewBrand" v-show="!dialogLoading">
            <v-card-text class="text-xs-center">
                <v-slide-y-transition>
                <v-img class="sepatu-img"
                    v-if="!!fileUrl"
                    :src="fileUrl"
                    max-height="200px"
                    contain
                ></v-img>
                </v-slide-y-transition>

                <p v-show="!!errorText" class="red--text">{{ errorText }}</p>

                <v-btn color="primary" flat @click="pickFile" v-if="!brandId">
                    Unggah Gambar
                </v-btn>
                
                <input type="file"
                    ref="file"
                    name="thumbnail"
                    @change="onFileChange($event.target.name, $event.target.files)"
                    style="display:none">

            </v-card-text>
            <v-card-text>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field
                            label="Nama brand"
                            v-model="name"
                            :rules="[rules.required]"
                            ref="name"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-textarea
                            label="Deskripsi brand"
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
                        {{ !!brandId? 'save' : 'add'}}
                    </v-icon>
                    {{ !!brandId? 'simpan' : 'buat brand'}}
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
export default {
    props: {
        brandId: {
            type: Number,
            required: true,
        }
    },
    data: () => ({
        dialogLoading: true,
        btnLoading: false,
        
        fileUrl: '',
        fileBin: '',
        errorText: '',
        maxSize: 2048,
        name: null,
        size: null,
        description: null,

        rules: {
            required: v => !!v || 'Harus diisi',
        },
    }),
    methods: {
        pickFile(){
            this.$refs.file.click();
        },
        onFileChange(fieldName, file) {
            const { maxSize } = this;
            console.log(fieldName);
            
            let imageFile = file[0]
            if (file.length > 0) {
                let size = imageFile.size / maxSize / maxSize
                if (!imageFile.type.match('image.*')) {
                    this.errorText = 'File harus berupa gambar!';
                } else if (size>1) {
                    // check whether the size is greater than the size limit
                    this.errorText = 'Ukuran file harus dibawah 1 MB!'
                } else {
                    this.errorText = '';
                    
                    this.fileUrl = URL.createObjectURL(imageFile);
                    this.fileBin = imageFile;
                    // this.copyFrom(formData);
                }
            }
        },
        async createNewBrand() {
            if(this.$refs.form_new_brand.validate()) {
                this.btnLoading = true;
                const data = new FormData();
                data.append(`name`, this.name); 
                data.append(`description`, this.description);
                if(!!this.fileBin) {
                    data.append(`image`, this.fileBin); 
                }
                try {
                    if(!this.brandId) {
                        const res = await axios.post('/api/brands', data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        alert("Brand berhasil dibuat");
                    } else {
                        const res = await axios.patch(`/api/brands/${this.brandId}`, {
                            name: this.name,
                            description: this.description
                        });
                        alert("Brand berhasil diubah");
                    }
                    this.$emit('create_success');
                } catch (err) {
                    console.log(err);
                }
            }
        },
    },
    async mounted() {
        if(!!this.brandId) {
            const res = await axios.get(`/api/brands/${this.brandId}`);
            this.name = res.data.name;
            this.description = res.data.description;
            this.fileUrl = res.data.image;
        }
        this.dialogLoading = false;
        this.$nextTick(() => this.$refs.name.focus());
    }
}
</script>
