<template>
    <div class="modal"
         :class="[
            { 'show': show }
         ]">
        <div @click="$emit('closeModal')" class="modal-background"></div>
        <div class="modal-card">
            <login v-if="modal === 'login'" />
            <register v-else-if="modal === 'register'" />
            <sighting-form v-else-if="modal === 'post'" />
            <sighting-detail v-else-if="modal === 'sighting'" />
        </div>
    </div>
</template>

<script>
import Login from './auth/Login'
import Register from './auth/Register'
import SightingForm from './SightingForm'
import SightingDetail from './SightingDetail'

export default {
    components: {
        'login': Login,
        'register': Register,
        'sighting-form': SightingForm,
        'sighting-detail': SightingDetail
    },

    props: {
        show: String,
        modal: String
    }
}
</script>

<style scoped>

</style>
