<template>
    <fatal-error v-if="error" />
    <div v-else class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">
                Register
            </p>
            <button @click="$emit('closeModal')" class="delete" aria-label="close"></button>
        </header>

        <section class="modal-card-body pb-3">
            <div class="field">
                <label class="label">User Handle</label>
                <div class="control">
                    <input class="input"
                           type="text"
                           name="handle"
                           v-model="user.handle"
                           disabled
                    >
                </div>
                <p class="help">Automatically generated for you</p>
            </div>

            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input class="input"
                           type="password"
                           name="password"
                           placeholder="Enter your password"
                           v-model="user.password"
                           :class="[
                                { 'is-danger': validateErrors('password') }
                           ]"
                    >
                </div>
                <v-errors :errors="validateErrors('password')"></v-errors>
            </div>

            <div class="field">
                <label class="label">Confirm Password</label>
                <div class="control">
                    <input class="input"
                           type="password"
                           name="password_confirmation"
                           placeholder="Confirm your password"
                           v-model="user.password_confirmation"
                           :class="[
                                { 'is-danger': validateErrors('password_confirmation') }
                           ]"
                    >
                </div>
                <v-errors :errors="validateErrors('password_confirmation')"></v-errors>
            </div>

            <div>
                Already have an account?
                <router-link :to="{ name: 'login' }">Login</router-link>
            </div>
        </section>

        <footer class="modal-card-foot">
            <button @click.prevent="register"
                    class="button is-success"
                    :disabled="sending"
            >Register</button>
            <button @click="$emit('closeModal')"
                    class="button"
                    :disabled="sending"
            >Cancel</button>
            <p v-if="sending" class="i">Logging in...</p>
        </footer>
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import * as Auth from '../../shared/auth'

export default {
    setup(props, { emit }) {
        const router = useRouter()
        const store = useStore()

        if (Auth.isLoggedIn()) {
            emit('closeModal')
        }

        const str_shuffle = require('locutus/php/strings/str_shuffle')
        const user_handle = (str_shuffle('abcdef0123456789')).slice(0, 6)

        const state = reactive({
            user: {
                handle: user_handle,
                password: null,
                password_confirmation: null
            },
            errors: null,
            sending: false,
            error: false
        })

        function validateErrors(field) {
            return state.errors && state.errors[field] ? state.errors[field] : null
        }

        async function register() {
            state.sending = true
            state.errors = null

            try {
                const response = await axios.post(`/register`, state.user)
                if (response.status === 201) {
                    // Login user
                    Auth.logIn()
                    await store.dispatch('loadUser')

                    state.sending = false

                    // Close modal
                    emit('closeModal')

                    // Redirect home
                    await router.push({name: 'home'})
                }

            } catch (error) {
                if (error.response && error.response.status && error.response.status === 422)
                    state.errors = error.response.data.errors
                else state.error = true

            } finally {
                state.sending = false
            }
        }

        return {
            ...toRefs(state),
            validateErrors,
            register
        }
    }
}
</script>
