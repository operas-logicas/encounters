require('./bootstrap')

import { createApp } from 'vue'
import Index from './Index.vue'
import router from './routes'

const app = createApp(Index)

app.use(router)

app.mount('#app')
