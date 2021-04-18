<template>
    <div class="column is-two-fifths-tablet is-one-third-desktop is-black">
        <article class="notification is-black">
            <p class="title">Top Sightings In Your State</p>
        </article>

        <article v-if="none" class="pb-6 mb-6 box">
            <p>No sightings reported yet...</p>
        </article>
        <div v-else class="mb-6">
            <router-link :to="{ name: 'sighting', params: { id: '123' } }">
                <sighting v-for="i in 3" :key="i" class="sighting" />
            </router-link>
        </div>

        <button @click="$emit('showModal', 'post')" class="button is-large is-fullwidth is-success">
            Add your own sighting
        </button>
    </div>
</template>

<script>
import { ref } from "vue";
import Sighting from './Sighting'

export default {
    components: {
        'sighting': Sighting
    },

    setup() {
        const none = ref(false)

        return {
            none
        }
    }
}
</script>

<style scoped>
.sighting:hover {
    transform: scale(1.01);
    box-shadow: 0 3px 12px 0 rgba(0, 0, 0, 0.2);
}
</style>
