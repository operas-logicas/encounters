<template>
    <div class="column is-two-fifths-tablet is-one-third-desktop mb-6 is-black">
        <article class="notification is-black">
            <p class="title">Top Sightings In Your State</p>
        </article>

        <article v-if="loading" class="pb-6 box">
            <p>Loading...</p>
        </article>
        <article v-else-if="none" class="pb-6 box">
            <p>No sightings reported yet...</p>
        </article>
        <div v-else-if="sightings" class="mb-5">
            <router-link :to="{ name: 'sighting', params: { id: '123' } }">
                <sighting v-for="(sighting, i) in sightings"
                          :key="`sighting-${i}`"
                          :sighting="sighting"
                          class="sighting"
                />
            </router-link>
        </div>

        <button @click="$emit('showModal', 'post')" class="button is-large is-fullwidth is-success">
            Add your own sighting
        </button>
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
            state.sightings = store.getters['topSightings']
            if (!state.sightings) state.none = true
            state.loading = false
        }

        watch(
            () => store.state.sightings,
            topSightings
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
