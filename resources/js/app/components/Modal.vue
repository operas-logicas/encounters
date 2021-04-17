<template>
    <div class="modal"
         :class="[
            { 'show': show }
         ]">
        <div @click="$emit('closeModal')" class="modal-background"></div>
        <div class="modal-card">
            <login @closeModal="$emit('closeModal')" v-if="modal === 'login'" />
            <register @closeModal="$emit('closeModal')" v-else-if="modal === 'register'" />
            <sighting-form @closeModal="$emit('closeModal')" v-else-if="modal === 'post'" />
            <sighting-detail @closeModal="$emit('closeModal')" v-else-if="modal === 'sighting'" />
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
        show: Boolean,
        modal: String
    }
}
</script>

<style scoped>
.show {
    display: block;
    z-index: 1000;
}
</style>
