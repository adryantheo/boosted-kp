<template>
    <v-card>
        <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">Menu Baru</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('close')">
                <v-icon>close</v-icon>
            </v-btn>
        </v-toolbar>

            <v-form ref="form_new_menu" @submit.prevent="createNewMenu">
            <v-card-text class="text-xs-center">
                <v-slide-y-transition>
                <v-img class="menu-img"
                    v-if="!!fileUrl"
                    :src="fileUrl"
                    :aspect-ratio="16/9"
                    max-height="300px"
                    contain
                ></v-img>
                </v-slide-y-transition>

                <p v-show="!!errorText" class="red--text">{{ errorText }}</p>

                <v-btn color="primary" flat @click="pickFile">Ganti Gambar</v-btn>
                
                <input type="file"
                    ref="file"
                    name="thumbnail"
                    @change="onFileChange(
                        $event.target.name, $event.target.files)"
                    style="display:none">
            </v-card-text>
            <v-card-text>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field
                            label="Nama menu"
                            v-model="name"
                            :rules="[rules.required]"
                            ref="name"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                            label="Harga"
                            v-model.number="price"
                            prefix="Rp"
                            suffix="/pcs"
                            :rules="[rules.required, rules.number, rules.notZero]"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-text-field
                            label="Stok"
                            v-model.number="stock"
                            :rules="[rules.required, rules.number, rules.notZero]"
                        ></v-text-field>
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
        fileUrl: '',
        fileBin: '',
        name: null,
        price: null,
        stock: null,

        rules: {
            required: v => !!v || 'Harus diisi',
            number: v => /^[0-9]*$/.test(v) || 'Angka tidak valid',
            notZero: v => v > 0 || 'Tidak boleh 0',
            length25: v => v.length <= 25 || 'Maksimal 25 karakter'
        },

        errorText: '',
        maxSize: 2048,
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
        async createNewMenu() {
            if(this.$refs.form_new_menu.validate()) {
                const data = new FormData();
                data.append(`file`, this.fileBin); 
                data.append(`nama`, this.name); 
                data.append(`harga`, this.price); 
                data.append(`stock`, this.stock);
                
                await axios.post('/ahahah',data, {
                    
                })
            }
        }
    },
    mounted() {
        this.$nextTick(() => this.$refs.name.focus())
    }
}
</script>
