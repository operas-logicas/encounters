import { createRouter, createWebHistory } from 'vue-router'
import App from './app/App.vue'
import Login from './auth/Login.vue'
import Register from './auth/Register.vue'

const routes = [
    {
        path: '/',
        component: App,
        name: 'home'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
