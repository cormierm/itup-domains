<template>
    <div class="edit">
        <v-alert v-if="message" :type="message.type">
            {{ message.text }}
        </v-alert>

        <v-card
            class="mx-auto my-10"
            max-width="500"
            color="#1F7087"
            dark
        >
            <v-card-title class="headline">Update Existing Hostname</v-card-title>

            <v-card-text>
                <hostname-input
                    v-model="hostname"
                    :error-messages="formErrors['hostname']"
                />

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

                <div class="submit-buttons">
                    <v-btn text :disabled="disableUpdate" :loading="loading" @click="submit">
                        Update
                    </v-btn>
                    <v-btn text @click="reset">
                        Reset
                    </v-btn>
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
    name: 'Update',
    components: { HostnameInput, HowLongSelect, IpAddressInput },
    props: {
        incomingHostname: {
            type: String,
            default: '',
        },
        remoteIp: {
            type: String,
            default: null,
        },
    },
    data() {
        return {
            loading: false,
            message: null,
            hostname: this.incomingHostname,
            ip: '',
            email: '',
            formErrors: {},
            expiresIn: 1,
        };
    },
    computed: {
        disableUpdate() {
            return this.hostname === '' || this.ip === '' || this.email === '';
        },
    },
    methods: {
        reset() {
            this.formErrors = {};
            this.ip = '';
            this.email = '';
            this.hostname = '';
            this.expiresIn = 1;
        },
        submit() {
            this.formErrors = {};
            this.loading = true;

            axios.post('/update', {
                hostname: this.hostname,
                ip: this.ip,
                email: this.email,
                expires_in: this.expiresIn,
            }).then((response) => {
                this.message = {
                    type: 'success',
                    text: response.data.message,
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
    },
}
</script>

<style scoped>
    .edit {
        padding-top: 50px;
    }

    .submit-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .v-field {
        padding-bottom: 10px;
    }
</style>
