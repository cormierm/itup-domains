<template>
    <div class="home">
        <v-alert v-if="alert" :type="alert.type">
            {{ alert.text }}
        </v-alert>

        <v-alert v-if="message" :type="message.type">
            {{ message.text }}
        </v-alert>

        <v-card
            class="mx-auto my-10"
            max-width="500"
            color="#1F7087"
            dark
        >
            <v-card-title class="headline">Search For Your Hostname</v-card-title>

            <v-card-text>
                <hostname-input
                    prepend-inner-icon="fa-search"
                    v-model="hostname"
                    :readonly="validHostname"
                    :success-messages="messageHostname"
                    :error-messages="formErrors['hostname']"
                    @enter="check"
                />

                <v-card-actions v-if="!validHostname">
                    <v-btn
                        text
                        :loading="loading"
                        @click="check"
                    >
                        Search Hostname
                    </v-btn>
                </v-card-actions>

                <div v-if="validHostname">
                    <v-text-field
                        class="v-field"
                        label="Email"
                        type="email"
                        v-model="email"
                        :error-messages="formErrors['email']"
                    ></v-text-field>

                    <ip-address-input
                        v-model="ip"
                        :error-messages="formErrors['ip']"
                        :remote-ip="remoteIp"
                    />

                    <how-long-select
                        v-model="expiresIn"
                        :error-messages="formErrors['expires_in']"
                    />

                    <div class="register-buttons">
                        <v-btn
                            text
                            :disabled="disableRegister"
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
        </v-card>
    </div>
</template>

<script>
import HostnameInput from './Inputs/HostnameInput';
import HowLongSelect from './Inputs/HowLongSelect';
import IpAddressInput from './Inputs/IpAddressInput';

export default {
    name: "Home",
    components: { HostnameInput, HowLongSelect, IpAddressInput },
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
            expiresIn: 1,
        };
    },
    watch: {
        hostname() {
            this.messageHostname = '';
            this.validHostname = false;
        }
    },
    computed: {
        disableRegister() {
            return this.hostname === '' || this.ip === '' || this.email === '';
        },
    },
    methods: {
        reset() {
            this.validHostname = false;
            this.messageHostname = '';
            this.formErrors = {};
            this.ip = '';
            this.email = '';
            this.hostname = '';
            this.expiresIn = 1;
        },
        submit() {
            this.formErrors = {};
            this.loading = true;

            axios.post('/register', {
                hostname: this.hostname,
                ip: this.ip,
                email: this.email,
                expires_in: this.expiresIn,
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
            this.messageHostname = '';
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
        height: 100%;
        padding: 10px 50px;
    }

    .register-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .v-field {
        padding-bottom: 10px;
    }
</style>
