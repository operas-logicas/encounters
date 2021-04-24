<template>
    <p class="mb-3">
        <span @click="updateLikes">
            <span v-if="state.hasLikes" class="is-clickable">💚</span>
            <span v-else class="is-clickable">🤍</span> {{ state.likes }}
        </span>
    </p>
    <p v-if="state.error"
       class="is-size-7 pb-3"
       style="color: hsl(348, 86%, 61%) !important"
    >Error! Failed to persist likes to db.</p>
</template>

<script>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import * as Auth from '../shared/auth'

export default {
    props: {
        sighting: Object,
        hasLikes: Boolean,
        likes: Number
    },

    setup(props, { emit }) {
        const router = useRouter()
        const store = useStore()

        const state = reactive({
            hasLikes: props.hasLikes,
            likes: props.likes,
            error: false
        })

        async function updateLikes() {
            // Check if logged in, otherwise redirect to login
            if (!Auth.isLoggedIn()) {
                emit('closeModal')
                await router.push({ name: 'login' })
            }

            state.error = false

            // Try incrementing first
            try {
                // Initialize CSRF Protection
                await axios.get(`/sanctum/csrf-cookie`)

                const response = await axios.post(
                    `/api/likes`,
                    {
                        sighting_id: props.sighting.id
                    }
                )

                let sighting = null

                // Success
                if (response.data.data) {
                    state.likes++
                    state.hasLikes = true
                    sighting = response.data.data
                } else {
                    state.hasLikes = state.likes > 1
                    state.likes--
                    sighting = props.sighting
                    sighting.likes--
                }

                // Push updated sighting to global store
                store.commit('updateSighting', sighting)

            } catch (error) {
                // Like already in the db so delete it instead
                if (
                    error.response &&
                    error.response.status &&
                    error.response.status === 401
                ) {
                    state.error = true
                }
                else state.error = true
            }
        }

        return {
            state,
            updateLikes
        }
    }
}
</script>
