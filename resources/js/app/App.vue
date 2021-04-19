<template>
    <section class="hero is-medium is-black">
        <!-- Hero head: will stick at the top -->
        <div class="hero-head">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-brand">
                        <span class="navbar-burger is-white"
                              data-target="navbarMenuHero"
                              @click="toggleNavbarMenu"
                              :class="[
                                  { 'is-active': navbarMenu }
                              ]"
                        >
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </div>

                    <div id="navbarMenuHero"
                         class="navbar-menu"
                         :class="[
                            { 'is-active': navbarMenu }
                         ]"
                    >
                        <div class="navbar-end">
                            <router-link :to="{ name: 'home' }" class="navbar-item">
                                Home
                            </router-link>
                            <router-link :to="{ name: 'post' }" class="navbar-item">
                                Post
                            </router-link>
                            <router-link :to="{ name: 'register' }" class="navbar-item">
                                Register
                            </router-link>
                            <router-link :to="{ name: 'login' }" class="navbar-item">
                                Login
                            </router-link>
                            <a href="#" class="navbar-item">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Hero content: will be in the middle -->
        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title is-1">
                    Encounters!
                </p>
                <p class="subtitle is-4">
                    UFO Sightings
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="columns">
            <sighting-list @showModal="showModal" />

            <map-view @showModal="showModal" />
        </div>
    </section>

    <modal @closeModal="closeModal" :show="show" :modal="view" />
</template>

<script>
import { reactive, toRefs, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import Map from './components/Map'
import Modal from './components/Modal'
import SightingList from './components/SightingList'

export default {
    components: {
        'map-view': Map,
        'modal': Modal,
        'sighting-list': SightingList
    },

    setup() {
        const router = useRouter()
        const route = useRoute()

        const state = reactive({
            navbarMenu: false,
            show: false,
            view: 'home'
        })

        function toggleNavbarMenu() {
            state.navbarMenu = !state.navbarMenu
        }

        function showModal(name) {
            router.push({ name })
        }

        function closeModal() {
            router.push({
                name: 'home'
            })
            state.show = false
            state.view = ''
        }

        watch(
            () => route.name,
            (name) => {
                if (name === 'home') return
                state.view = name
                state.show = true;
            }
        )

        return {
            ...toRefs(state),
            toggleNavbarMenu,
            showModal,
            closeModal
        }
    }
}
</script>

<style scoped>
.columns {
    height: auto;
}

.hero {
    background-image: url("../../../public/images/ufo-green-hero.jpg");
    background-position: top left;
    background-size: cover;
}

.navbar-burger {
    color: white;
}

.navbar-item:hover {
    background-color: hsl(0, 0%, 21%) !important;
}

.navbar-item.is-active:hover {
    background-color: black !important;
}
</style>
