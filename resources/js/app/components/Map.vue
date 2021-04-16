<template>
    <div class="tile is-parent">
        <l-map ref="map"
               class="tile is-child"
               v-if="!loading"
               :zoom="zoom"
               :center="coords"
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
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet'
import 'leaflet/dist/leaflet.css'

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker
    },

    setup() {
        const state = reactive({
            zoom: 7,
            coords: [0,0],
            url: 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            loading: false
        })

        onBeforeMount(async () => {
            state.loading = true

            if (navigator.geolocation)
                await navigator.geolocation.getCurrentPosition(
                    // Success
                    position => {
                        const { latitude, longitude } = position.coords
                        state.coords = [latitude, longitude]

                        state.loading = false
                    },

                    // Error
                    () => {
                        alert('Could not get your position')
                    }
                )
        })

        return {
            ...toRefs(state)
        }
    }
}
</script>
