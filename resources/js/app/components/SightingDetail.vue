<template>
    <div v-if="loading">
        Loading...
    </div>
    <div v-else-if="sighting">
        <header class="modal-card-head pb-2">
            <p class="modal-card-title is-flex-shrink-1">
                {{ sighting.title }}
                <span class="is-block is-size-6 mt-1">(GPS: {{ sighting.location }})</span>
                <span class="is-block is-size-6 mt-4 mb-0">
                    <span class="is-size-5">👽</span>
                    {{ sighting.user_handle }} &bull; {{ niceDate }}
                </span>
            </p>
            <button @click="$emit('closeModal')" class="delete" aria-label="close"></button>
        </header>

        <section class="modal-card-body">
            <p v-if="sighting.img_path" class="image is-4by3 mb-3">
                <img :src="`../${sighting.img_path}`">
            </p>
            <p class="mb-3">
                {{ sighting.description }}
            </p>
            <p>
                <span @click="sighting.likes++">
                    <span v-if="hasLikes" class="is-clickable">💚</span>
                    <span v-else class="is-clickable">🤍</span> {{ sighting.likes }}
                </span>
            </p>
        </section>

        <footer class="modal-card-foot">
            <button @click="$emit('closeModal')" class="button">Close</button>
        </footer>
    </div>
</template>

<script>
import { reactive, toRefs, watch } from 'vue'
import { useRoute } from 'vue-router'
import moment from 'moment'

export default {
    props: {
        id: String
    },

    setup() {
        const route = useRoute()

        const state = reactive({
            sighting: null,
            hasLikes: true,
            niceDate: '',
            loading: true
        });

        // 'onCreated' load sighting
        (async function() {
            try {
                state.sighting = (await axios.get(
                    `/api/sightings/${route.params.id}`)
                ).data.data
            } catch (error) {
                console.log(error)
            } finally {
                state.loading = false
            }
        })()

        watch(
            () => state.sighting,
            () => {
                if (state.sighting)
                    state.niceDate = moment(state.sighting.date).format('ll')
            }
        )

        return {
            ...toRefs(state)
        }
    }
}
</script>
