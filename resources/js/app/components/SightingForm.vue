<template>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">
                Add Sighting
            </p>
            <button @click="$emit('closeModal')" class="delete" aria-label="close"></button>
        </header>

        <section class="modal-card-body pb-3">
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input"
                           type="text"
                           name="title"
                           placeholder="Close encounter in..."
                           v-model="title"
                           :class="[
                                { 'is-danger': validateErrors('title') }
                           ]"
                    >
                </div>
                <p v-if="!validateErrors('title')" class="help">
                    Enter a title for the sighting
                </p>
                <v-errors :errors="validateErrors('title')"></v-errors>
            </div>

            <div class="field">
                <label class="label">Date</label>
                <div class="control">
                    <input class="input"
                           type="text"
                           name="date"
                           placeholder="YYYY-MM-DD"
                           v-model="date"
                           :class="[
                                { 'is-danger': validateErrors('date') }
                           ]"
                    >
                </div>
                <p v-if="!validateErrors('date')" class="help">
                    Enter the date of the event <i>(Format: YYYY-MM-DD)</i>
                </p>
                <v-errors :errors="validateErrors('date')"></v-errors>
            </div>

            <div class="field">
                <label class="label">GPS Coordinates</label>
                <div class="control is-flex is-invalid">
                    <input class="input mr-2"
                           type="text"
                           name="location.latitude"
                           placeholder="Latitude"
                           v-model="coords[0]"
                           :class="[
                                { 'is-danger': validateErrors('location') }
                           ]"
                    >
                    <input class="input ml-2"
                           type="text"
                           name="location.longitude"
                           placeholder="Longitude"
                           v-model="coords[1]"
                           :class="[
                                { 'is-danger': validateErrors('location') }
                           ]"
                    >
                </div>
                <p v-if="!validateErrors('location')" class="help">
                    Enter latitude and longitude where the event ocurred
                    <i>(current position on map shown)</i>
                </p>
                <v-errors :errors="validateErrors('location')"></v-errors>
            </div>

            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <textarea
                        class="textarea"
                        name="description"
                        placeholder="Tell us what happened..."
                        v-model="description"
                        :class="[
                            { 'is-danger': validateErrors('description') }
                        ]"
                    ></textarea>
                </div>
                <p v-if="!validateErrors('description')" class="help">
                    Describe what happened
                </p>
                <v-errors :errors="validateErrors('description')"></v-errors>
            </div>

            <div class="field">
                <label class="label">Upload Image</label>
                <div class="control">
                    <div class="file">
                        <label class="file-label">
                            <input class="file-input" type="file" name="file">
                            <span class="file-cta">
                                <span class="file-icon">⇪</span>
                                <span class="file-label">Upload image...</span>
                            </span>
                        </label>
                    </div>
                </div>
                <p class="help">Upload an image of the event</p>
            </div>
        </section>

        <footer class="modal-card-foot">
            <button @click.prevent="submit"
                    class="button is-success"
                    :disabled="sending"
            >Submit</button>
            <button @click="$emit('closeModal')"
                    class="button"
                    :disabled="sending"
            >Cancel</button>
        </footer>
    </div>
</template>

<script>
import { reactive, toRefs, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import getCurrentState from '../shared/getCurrentState'

export default {
    setup(props, { emit }) {
        const router = useRouter()
        const store = useStore()

        const state = reactive({
            title: null,
            date: null,
            description: null,
            file: null,
            coords: [
                store.state.currentPosition[0],
                store.state.currentPosition[1]
            ],
            currentState: null,

            errors: null,
            sending: false,
            error: false,
        })

        function validateErrors(field) {
            return state.errors && state.errors[field] ? state.errors[field] : null
        }

        async function submit() {
            state.sending = true
            state.errors = null

            state.currentState = await getCurrentState(state.coords)

            const formData = new FormData()
            formData.append('title', state.title)
            formData.append('date', state.date)
            formData.append('description', state.description)
            formData.append('location', state.coords.join(','))
            formData.append('state', state.currentState)
            if (state.file) formData.append('file', state.file.files[0])

            try {
                const response = await axios.post(
                    `/api/sightings`,
                    formData,
                    {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }
                )

                // Success
                if (response.status === 201) {
                    state.sending = false

                    // Push new sighting to global store
                    // (will trigger refresh from server)
                    const sighting = response.data.data
                    store.commit('setSighting', sighting)

                    // Close modal
                    emit('closeModal')

                    // Redirect to new sighting
                    await router.push({
                        name: 'sighting',
                        params: {
                            id: sighting.id
                        }
                    })
                }

            } catch (error) {
                if (error.response && error.response.status && error.response.status === 422)
                    state.errors = error.response.data.errors
                else state.error = true

            } finally {
                state.sending = false
            }
        }

        watch(
            () => store.state.currentPosition,
            () => {
                state.coords = [
                    store.state.currentPosition[0],
                    store.state.currentPosition[1]
                ]
            }
        )

        return {
            ...toRefs(state),
            validateErrors,
            submit
        }
    }
}
</script>
