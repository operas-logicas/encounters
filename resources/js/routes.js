import { createRouter, createWebHistory } from 'vue-router'
import App from './app/App'
import Login from './app/components/auth/Login'
import Register from './app/components/auth/Register'
import SightingDetail from './app/components/Sighting'
import SightingForm from './app/components/SightingForm'

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
        path: '/post',
        component: SightingForm,
        name: 'post'
    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
    {
        path: '/sighting/:id',
        component: SightingDetail,
        name: 'sighting'
    }
]

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'is-active',
    routes
})

export default router
