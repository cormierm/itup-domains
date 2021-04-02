<template>
    <v-select
        class="v-field"
        outlined
        :value="value"
        :items="expiresInItems"
        label="How Long Do You Want This Hostname?"
        :error-messages="errorMessages"
        @input="$emit('input', $event)"
    ></v-select>
</template>

<script>
export default {
    name: "HowLongSelect",
    props: {
        value: {
            type: Number,
            required: true,
        },
        errorMessages: {
            type: String, Array,
            default: null
        }
    },
    data() {
        return {
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
                {
                    text: '3 Months',
                    value: 90,
                },
                {
                    text: '1 Year',
                    value: 365,
                },
            ]
        };
    }
}
</script>

<style scoped>

</style>
