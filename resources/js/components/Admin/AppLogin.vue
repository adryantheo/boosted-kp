<template>
    <v-app>
        <v-content>
            <v-container grid-list-lg fill-height>
                <v-layout row wrap justify-center align-center>
                    <v-flex xs12 md9 style="max-width: 600px">
                        <v-card elevation-10>
                        <v-form ref="login_form" @submit.prevent="login">
                            <v-card-text>
                                <v-text-field
                                    label="Username"
                                    v-model="username"
                                    type="text"
                                    :rules="[v => !!v || 'Harus diisi']"
                                ></v-text-field>
                                <v-text-field
                                    label="Password"
                                    v-model="password"
                                    type="password"
                                    :rules="[v => !!v || 'Harus diisi']"
                                ></v-text-field>
                            </v-card-text>
                            <v-card-text class="text-xs-center">
                                <v-btn color="primary" 
                                    :loading="loading"
                                    outline round large type="submit"
                                >
                                    Login
                                </v-btn>
                            </v-card-text>
                        </v-form>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>
<script>
import { mapActions } from 'vuex'

export default {
    data: () => ({
        username: null,
        password: null,
        loading: false,
    }),
    methods: {
        async login() {
            if(this.$refs.login_form.validate()) {
                this.loading = true
                try {
                    console.log(this.username, this.password);
                    
                    await this.loginRequest({
                        user: this.username, 
                        pass: this.password
                    });
                    this.$router.replace({path: "/admin"});
                } catch (error) {
                    alert(error);
                }
                this.loading = false
            }
        },
        ...mapActions([
            'loginRequest'
        ])
    },
}
</script>
