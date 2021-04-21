require('./bootstrap')

import { createApp } from 'vue'
import Index from './Index'
import ValidationErrors from './app/shared/components/ValidationErrors'
import router from './routes'
import store from './store'

const app = createApp(Index)

app.component('v-errors', ValidationErrors)

app.use(router)
app.use(store)

app.mount('#app')
