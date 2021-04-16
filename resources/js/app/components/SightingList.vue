<template>
    <div class="column is-two-fifths-tablet is-one-third-desktop is-black">
        <article class="notification is-black">
            <p class="title">Top Sightings In Your Area</p>
        </article>

        <article id="none" v-if="none" class="pb-6 mb-6 box">
            <p>No sightings reported yet...</p>
        </article>
        <sighting v-else />

        <button @click="$emit('modal', 'post')" class="button is-large is-fullwidth is-success">
            Add your own sighting
        </button>
    </div>
</template>

<script>
import Sighting from './Sighting'
import {ref} from "vue";

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
