require('./bootstrap')

import { createApp } from 'vue'
import Index from './Index'
import router from './routes'
import store from './store'

createApp(Index)
    .use(store)
    .use(router)
    .mount('#app')
