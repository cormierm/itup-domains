<template>
    <div class="home">
        <h1 class="base-title">ItUp.ca</h1>

        <p>Tired of trying to remember an IP address? Register a hostname to use for all your lookup needs.</p>

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
            <v-card-title class="headline">Create Your Hostname</v-card-title>
            <v-card-subtitle>Start by checking if your hostname is available</v-card-subtitle>

            <v-card-text>
                <v-text-field
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
                        label="Email"
                        type="email"
                        v-model="email"
                        :error-messages="formErrors['email']"
                    ></v-text-field>

                    <v-text-field
                        label="IP Address"
                        v-model="ip"
                        :error-messages="formErrors['ip']"
                    >
                    </v-text-field>

                    <v-btn
                        color="info"
                        class="mr-4"
                        @click="submit"
                    >
                        Register
                    </v-btn>
                    <v-btn
                        color="secondary"
                        class="mr-4"
                        @click="reset"
                    >
                        Reset
                    </v-btn>
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
                default: null,
            },
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

    p {
        font-size: 1.3rem;
        color: #424242;
        font-weight: 300;
    }
</style>
