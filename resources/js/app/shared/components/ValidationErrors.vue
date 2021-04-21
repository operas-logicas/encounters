<template>
    <p class="help is-danger"
         v-for="(error, index) in errors"
         :key="key(index)"
    >{{ error }}</p>
</template>

<script>
export default {
    props: [
        'errors'
    ],

    setup() {
        function key(index) {
            return `validation_error_${index}_${Math.random()}`
        }

        return {
            key
        }
    }
}
</script>
