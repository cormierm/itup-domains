<template>
    <v-text-field
        class="v-field"
        label="Hostname"
        :prepend-inner-icon="prependInnerIcon"
        :value="value"
        :readonly="readonly"
        maxlength="50"
        counter
        :success-messages="successMessages"
        :error-messages="errorMessages"
        :suffix="suffix"
        @input="$emit('input', $event)"
        @keydown.enter="$emit('enter', $event)"
    ></v-text-field>
</template>

<script>
export default {
    name: "HostnameInput",
    props: {
        value: {
            type: String,
            required: true
        },
        errorMessages: {
            type: [String, Array],
            default: null
        },
        successMessages: {
            type: [String, Array],
            default: null
        },
        prependInnerIcon: {
            type: String,
            default: null
        },
        readonly: {
            type: Boolean,
            default: false
        },
        showSearchIcon: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        suffix() {
            return `.${process.env.MIX_DOMAIN}`;
        },
    },
}
</script>

