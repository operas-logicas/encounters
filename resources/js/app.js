require('./bootstrap')

import { createApp } from 'vue'
import Index from './Index'
import ValidationErrors from './app/shared/components/ValidationErrors'
import router from './routes'
import store from './store'

// Create Vue app
const app = createApp(Index)
app.component('v-errors', ValidationErrors)
app.use(router)
app.use(store)
app.mount('#app')

// Intercept 401 Unauthorized
window.axios.interceptors.response.use(
    response => response,
    async error => {
        if (error.response.status === 401)
            await store.dispatch('logout')
        return Promise.reject(error)
    }
);

// Load logged in status from browser local storage
// Load authenticated user from server and set in global store
(async () => {
    await store.dispatch('loadStoredUser');
    await store.dispatch('loadUser');
})()
