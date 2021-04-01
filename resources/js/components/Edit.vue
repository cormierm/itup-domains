<template>
    <div class="update-screen">
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
            <v-card-title class="headline">Update Hostname</v-card-title>

            <v-card-text>
                <v-text-field
                    class="v-field"
                    label="Hostname"
                    :value="hostname"
                    :error-messages="formErrors['hostname']"
                    suffix=".itup.ca"
                ></v-text-field>

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
                            <v-icon>fa fa-map-marker-alt</v-icon>&nbsp;{{ remoteIp }}
                        </v-btn>
                    </template>
                </v-text-field>

                <v-select
                    class="v-field"
                    outlined
                    v-model="expiresIn"
                    :items="expiresInItems"
                    label="How Long Do You Want This Hostname?"
                    :error-messages="formErrors['expires_in']"
                ></v-select>

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
export default {
    name: 'Update',
    props: {
        alert: {
            type: Object,
            default: null,
        },
        hostname: {
            type: String,
            required: true,
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
            ip: '',
            email: '',
            formErrors: {},
            expiresIn: 1,
            expiresInItems: [
                {
                    text: '1 Day',
                    value: 1,
                },
                {
                    text: '1 Week',
                    value: 7,
                },
                {
                    text: '1 Month',
                    value: 30,
                },
            ],
        };
    },
    computed: {
        disableUpdate() {
            return this.hostname === '' || this.ip === '' || this.email === '';
        }
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
    .submit-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .v-field {
        padding-bottom: 10px;
    }
</style>
