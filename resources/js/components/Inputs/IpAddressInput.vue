<template>
    <v-text-field
        class="v-field"
        label="IP Address"
        :value="value"
        :error-messages="errorMessages"
        @input="$emit('input', $event)"
    >
        <template v-slot:append-outer>
            <v-btn
                outlined
                @click="$emit('input', remoteIp)"
            >
                <v-icon>fa fa-map-marker-alt</v-icon>&nbsp;{{ remoteIp }}
            </v-btn>
        </template>
    </v-text-field>
</template>

<script>
export default {
    name: 'IpAddressInput',
    props: {
        value: {
            type: String,
            required: true,
        },
        errorMessages: {
            type: [String, Array],
            default: null
        },
        remoteIp: {
            type: String,
            default: '',
        }
    },
}
</script>

<style scoped>

</style>
