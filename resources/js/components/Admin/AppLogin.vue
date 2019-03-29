<template>
    <v-app>
        <v-content>
            <v-container grid-list-lg fill-height>
                <v-layout row wrap justify-center align-center>
                    <v-flex xs12 md9 style="max-width: 600px">
                        <v-card elevation-10>
                        <v-form ref="login_form">
                            <v-card-text>
                                <v-text-field
                                    label="Username"
                                    type="text"
                                ></v-text-field>
                                <v-text-field
                                    label="Password"
                                    type="password"
                                ></v-text-field>
                            </v-card-text>
                            <v-card-text class="text-xs-center">
                                <v-btn color="primary" 
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
export default {
    
}
</script>
