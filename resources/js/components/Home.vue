<template>
    <div class="home">
        <h1 class="base-title">ItUp.ca</h1>

        <v-alert v-if="alert" :type="alert.type">
            {{ alert.text }}
        </v-alert>

        <v-alert v-if="message" :type="message.type">
            {{ message.text }}
        </v-alert>

        <v-card
            class="mx-auto"
            max-width="500"
            color="#1F7087"
            dark
        >
            <v-card-title class="headline">Search For Your Hostname</v-card-title>

            <v-card-text>
                <v-text-field
                    class="v-field"
                    label="Hostname"
                    v-model="hostname"
                    :read-only="validHostname"
                    maxlength="50"
                    counter
                    :success-messages="messageHostname"
                    :error-messages="formErrors['hostname']"
                    suffix=".itup.ca"
                ></v-text-field>

                <div v-if="validHostname">
                    <v-text-field
                        class="v-field"
                        label="Email"
                        type="email"
                        v-model="email"
                        :error-messages="formErrors['email']"
                    ></v-text-field>

                    <v-text-field
                        class="v-field"
                        label="IP Address"
                        v-model="ip"
                        :error-messages="formErrors['ip']"
                    >
                        <template v-slot:append-outer>
                            <v-btn
                                outlined
                                @click="ip = remoteIp"
                            >
                                <v-icon>fas fa-search</v-icon> {{ remoteIp }}
                            </v-btn>
                        </template>
                    </v-text-field>

                    <div class="register-buttons">
                        <v-btn
                            text
                            :loading="loading"
                            @click="submit"
                        >
                            Register
                        </v-btn>
                        <v-btn
                            text
                            @click="reset"
                        >
                            Reset
                        </v-btn>
                    </div>

                </div>
            </v-card-text>

            <v-card-actions v-if="!validHostname">
                <v-btn
                    text
                    :loading="loading"
                    @click="check"
                >
                    Search Hostname
                </v-btn>
            </v-card-actions>

        </v-card>
    </div>
</template>

<script>
    export default {
        name: "Home",
        props: {
            alert: {
                type: Object,
                default: null
            },
            remoteIp: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                loading: false,
                message: null,
                messageHostname: [],
                hostname: '',
                ip: '',
                email: '',
                formErrors: {},
                validHostname: false,
            };
        },
        watch: {
            hostname() {
                this.validHostname = false;
            }
        },
        methods: {
            reset() {
                this.validHostname = false;
                this.messageHostname = [];
                this.formErrors = {};
                this.ip = '';
                this.email = '';
                this.hostname = '';
            },
            submit() {
                this.formErrors = {};
                this.loading = true;

                axios.post('/register', {
                    hostname: this.hostname,
                    ip: this.ip,
                    email: this.email,
                }).then((response) => {
                    this.message = {
                        type: 'success',
                        text: response.data.message
                    };
                    this.reset();
                }).catch((err) => {
                    if (err.response.status === 422) {
                        this.formErrors = err.response.data.errors;
                    } else {
                        console.error(err);
                    }
                });
                this.loading = false;
            },
            check() {
                this.formErrors = {};
                this.messageHostname = [];
                this.loading = true;
                this.validHostname = false;

                axios.post('/check', {
                    hostname: this.hostname,
                }).then((response) => {
                    this.messageHostname = [response.data.message];
                    this.validHostname = true;
                }).catch((err) => {
                    if (err.response.status === 422) {
                        this.formErrors = err.response.data.errors;
                    } else {
                        console.error(err);
                    }
                });
                this.loading = false;
            }
        }
    }
</script>

<style scoped>
    .home {
        padding: 10px 50px;
    }
    .base-title {
        font-size: 3rem;
        font-weight: 300;
    }

    .register-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .v-field {
        padding-bottom: 10px;
    }

    p {
        font-size: 1.3rem;
        color: #424242;
        font-weight: 300;
    }
</style>
