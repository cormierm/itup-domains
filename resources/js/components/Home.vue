<template>
    <div>
        <h1>ItUp.ca</h1>

        <v-alert v-if="message" type="success">
            {{ message }}
        </v-alert>

        <form @submit.prevent>
            <v-text-field
                label="Sub Domain"
                v-model="subDomain"
                :error-messages="formErrors['sub_domain']"
            ></v-text-field>

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
            ></v-text-field>

            <v-btn
                color="info"
                class="mr-4"
                @click="submit"
            >
                Submit
            </v-btn>
            <v-btn
                color="secondary"
                class="mr-4"
                @click="reset"
            >
                Reset
            </v-btn>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                loading: false,
                message: "",
                subDomain: '',
                ip: '',
                email: '',
                formErrors: {},
            };
        },
        methods: {
            reset() {
                this.formErrors = {};
                this.ip = '';
                this.email = '';
                this.subDomain = '';
            },
            submit() {
                this.formErrors = {};
                this.loading = true;

                axios.post('/register', {
                    sub_domain: this.subDomain,
                    ip: this.ip,
                    email: this.email,
                }).then((response) => {
                    this.message = response.data.message;
                    this.reset();
                }).catch((err) => {
                    if (err.response.status === 422) {
                        this.formErrors = err.response.data.errors;
                    } else {
                        console.error(err);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
