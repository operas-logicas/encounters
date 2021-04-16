<template>
    <div class="tile is-parent is-5 is-black">
        <div class="tile is-vertical">
            <article class="tile is-child notification is-black">
                <p class="title">Top Sightings In Your Area</p>
            </article>

            <sighting v-for="i in 3" :key="i" />
        </div>
    </div>
</template>

<script>
import Sighting from './Sighting.vue'

export default {
    components: {
        'sighting': Sighting
    }
}
</script>
