<template>
    <div class="column is-three-fifths-tablet is-two-thirds-desktop">

        <l-map ref="map"
               v-if="!loading"
               @click="showForm"
               :zoom="zoom"
               :center="coords"
               :options="mapOptions"
        >
            <l-tile-layer
                :url="url"
                :attribution="attribution"
            />

            <l-marker :lat-lng="coords" />
        </l-map>
    </div>
</template>

<script>
import { onBeforeMount, reactive, toRefs } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'
import 'leaflet/dist/leaflet.css'

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker
    },

    setup() {
        const router = useRouter()
        const store = useStore()

        const state = reactive({
            zoom: 7,
            coords: [0, 0],
            url: 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            mapOptions: {
                scrollWheelZoom: false
            },
            sightings: null,
            loading: false
        })

        function showForm(event) {
            const { lat, lng } = event.latlng
            state.coords = [lat, lng]

            // router.push({
            //     name: 'post'
            // })
        }

        // 'onCreated' get sightings and save to store
        (async () => {
            state.loading = true

            try {
                state.sightings = (await axios.get(`/api/sightings`)).data

                // Save to store
                store.commit('setSightings', state.sightings)

            } catch (error) {
                console.log(error)
            } finally {
                state.loading = false
            }
        })()

        onBeforeMount(async () => {
            state.loading = true

            if (navigator.geolocation)
                await navigator.geolocation.getCurrentPosition(
                    // Success
                    position => {
                        const { latitude, longitude } = position.coords
                        state.coords = [latitude, longitude]

                        // Update the store
                        store.commit('setCurrentPosition', state.coords.join(','))

                        state.loading = false
                    },

                    // Error
                    () => {
                        alert('Could not get your position')
                    }
                )
        })

        return {
            ...toRefs(state),
            showForm
        }
    }
}
</script>

<style scoped>
.column {
    height: 760px;
}
</style>
