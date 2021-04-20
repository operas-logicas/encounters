<template>
    <div class="sighting-map column is-three-fifths-tablet is-two-thirds-desktop">
        <div v-if="loading">Loading...</div>
        <l-map v-else ref="map"
               @click="renderMap"
               :zoom="zoom"
               :center="coords"
               :options="mapOptions"
        >
            <l-tile-layer
                :url="url"
                :attribution="attribution"
            />

            <l-marker v-for="(sighting, i) in sightings"
                      :key="`marker-${i}`"
                      :lat-lng="sighting.location.split(',')"
            >
                <l-popup>
                    <router-link :to="{ name: 'sighting', params: { id: sighting.id } }">
                        <sighting :sighting="sighting" />
                    </router-link>
                </l-popup>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import { reactive, toRefs, watch } from 'vue'
import { useStore } from 'vuex'
import Sighting from './Sighting'
import { LMap, LTileLayer, LMarker, LPopup } from '@vue-leaflet/vue-leaflet'
import 'leaflet/dist/leaflet.css'

export default {
    components: {
        Sighting,
        LMap,
        LTileLayer,
        LMarker,
        LPopup
    },

    setup() {
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
            currentState: '',
            loading: true
        })

        async function getCurrentState() {
            const apiKey = 'de7fdcfba2734932be8d31c84963114a'

            try {
                // Need a single axios instance w/o X-Requested-With
                const axiosService = require('axios')
                delete axiosService.defaults.headers.common['X-Requested-With']

                state.currentState =
                    (await axiosService.get(
                        `https://api.opencagedata.com/geocode/v1/json?q=${
                            state.coords.join('+')
                        }&key=${ apiKey }`
                    )).data.results[0].components.state

            } catch (error) {
                alert(`Could not determine what state you're in.`)
            }
        }

        async function renderMap(position) {
            if (position.coords) {
                // Geolocation position
                const { latitude, longitude } = position.coords
                state.coords = [latitude, longitude]
            } else if (position.latlng && position.latlng !== state.coords) {
                // Map click event
                const { lat, lng } = position.latlng
                state.coords = [lat, lng]
            } else return

            // Update the store
            store.commit('setCurrentPosition', state.coords)

            await getCurrentState()
        }

        async function getSightings() {
            try {
                state.sightings =
                    (await axios.get(
                        `/api/sightings?state=${state.currentState}`)
                    ).data.data

                // Save to store
                store.commit('setSightings', state.sightings)

            } catch (error) {
                console.log(error)
            } finally {
                state.loading = false
            }
        }

        // 'onCreated' get current position and load map
        (async () => {
            if (navigator.geolocation)
                await navigator.geolocation.getCurrentPosition(
                    // Success
                    renderMap,

                    // Error
                    () => {
                        alert('Could not get your position.')
                    }
                )
        })()

        // When we get current state, get sightings
        watch(
            () => state.currentState,
            getSightings
        )

        return {
            ...toRefs(state),
            renderMap
        }
    }
}
</script>

<style>
.sighting-map {
    height: 800px;
}

.leaflet-popup-content {
    margin: 0 !important;
    width: 320px !important;
}
</style>
