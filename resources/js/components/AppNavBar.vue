<template>
    <v-app-bar
        dense
        dark
        fixed
    >
        <v-toolbar-title><strong>{{ appName }}</strong></v-toolbar-title>
        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon @click="goHome">mdi-home</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon @click="goHome">mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon @click="goEdit">mdi-pencil</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<script>
export default {
    name: 'AppNavBar',
    computed: {
        appName() {
            return process.env.MIX_APP_NAME;
        },
    },
    methods: {
        goEdit() {
            window.location = '/edit';
        },
        goHome() {
            window.location = '/';
        }
    }
}
</script>

<style scoped>

</style>
