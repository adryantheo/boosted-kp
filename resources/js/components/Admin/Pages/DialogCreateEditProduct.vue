<template>
    <v-card>
        <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">
                {{ !!productId? 'Ubah Sepatu' : 'Sepatu Baru'}}
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
        <v-form ref="form_new_sepatu" @submit.prevent="createNewSepatu"
        v-show="!dialogLoading">
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

                <v-btn color="primary" flat @click="pickFile">
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
                    <v-flex xs12 md8>
                        <v-text-field
                            label="Nama sepatu"
                            v-model="name"
                            :rules="[rules.required]"
                            ref="name"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md2>
                        <v-text-field
                            label="Ukuran"
                            v-model.number="size"
                            :rules="[rules.required, rules.notZero]"
                            ref="name"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md2>
                        <v-select
                            :items="shoeGenders"
                            v-model="gender"
                            item-text="name"
                            item-value="key"
                            label="gender"
                        ></v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-textarea
                            label="Deskripsi sepatu"
                            v-model="description"
                            :rules="[rules.required]" 
                            rows="3"
                        ></v-textarea>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                            label="Harga"
                            v-model.number="price"
                            prefix="Rp"
                            suffix="/pcs"
                            :rules="[rules.required, rules.number, rules.notZero, rules.tooMuch]"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-text-field
                            label="Stok"
                            v-model.number="stock"
                            :rules="[rules.required, rules.number, rules.notZero, rules.tooMuch]"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>     
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" large type="submit" :loading="btnLoading">
                    <v-icon left>
                        {{ !!productId? 'save' : 'add'}}
                    </v-icon>
                    {{ !!productId? 'simpan' : 'buat produk'}}
                </v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>
<script>
export default {
    props: {
        productId: {
            type: Number,
            required: true,
        },
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
        gender: null,
        shoeGenders: [
            { key: 'M', name: "Male" },
            { key: 'F', name: "Female" },
        ],
        description: null,
        stock: null,
        price: null,

        rules: {
            required: v => !!v || 'Harus diisi',
            number: v => /^[0-9]*$/.test(v) || 'Angka tidak valid',
            notZero: v => v > 0 || 'Tidak boleh kurang dari 1',
            tooMuch: v => v < 999999 || 'Nilai terlalu besar!',
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
        async createNewSepatu() {
            if(this.$refs.form_new_sepatu.validate()) {
                this.btnLoading = true;
                const data = new FormData();
                // if(!this.productId) {
                //     data.append('_method', 'PATCH');
                // }

                data.append(`name`, this.name); 
                data.append(`price`, this.price); 
                data.append(`units`, this.stock);
                data.append(`size`, this.size);
                data.append(`gender`, this.gender);
                data.append(`description`, this.description);
                if(!!this.fileBin) {
                    data.append(`image`, this.fileBin);
                } 
                
                try {
                    if(!this.productId) {
                        const res = await axios.post('/api/products', data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                    } else {
                        const res = await axios.post(`/api/products/${this.productId}`, data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                    }
                    this.$emit('create_success');   
                } catch (err) {
                    console.log(err);
                }
            }
        }
    },
    async mounted() {
        if(!!this.productId) {
            const res = await axios.get(`/api/products/${this.productId}`);
            this.fileUrl = res.data.image;
            this.name = res.data.name;
            this.description = res.data.description;
            this.stock = res.data.units;
            this.price = res.data.price;
            this.size = res.data.size;
            this.gender = res.data.gender;
        }
        this.dialogLoading = false;
        this.$nextTick(() => this.$refs.name.focus());
    }
}
</script>
