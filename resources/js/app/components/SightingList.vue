<template>
    <div class="column is-two-fifths-tablet is-one-third-desktop mb-6 is-black">
        <article class="notification is-black">
            <p class="title mb-2">Top Sightings In Your State</p>
            <p class="is-size-7">(Click on the map to show sightings in another state)</p>
        </article>

        <article v-if="loading" class="pb-6 box">
            <p>Loading...</p>
        </article>
        <article v-else-if="none" class="pb-6 box">
            <p>No sightings reported yet...</p>
        </article>
        <div v-for="(sighting, i) in sightings"
             :key="`sighting-${i}`" class="mb-5">
            <router-link :to="{ name: 'sighting', params: { id: String(sighting.id) } }">
                <sighting :sighting="sighting" class="sighting" />
            </router-link>
        </div>

        <button @click="$emit('showModal', 'post')" class="button is-large is-fullwidth is-success">
            Add your own sighting
        </button>
        <p class="is-size-7 pt-1">(Click on the map first to get GPS coordinates)</p>
    </div>
</template>

<script>
import { reactive, toRefs, watch } from 'vue'
import { useStore } from 'vuex'
import Sighting from './Sighting'

export default {
    components: {
        'sighting': Sighting
    },

    setup() {
        const store = useStore()

        const state = reactive({
            sightings: null,
            loading: true,
            none: false
        })

        function topSightings() {
            state.none = false

            state.sightings = store.getters['topSightings']
            if (_.size(state.sightings) === 0) state.none = true

            state.loading = false
        }

        // Watch for sightings! Get the top ones.
        watch(
            () => store.state.sightings,
            topSightings,
            { deep: true }
        )

        return {
            ...toRefs(state)
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
