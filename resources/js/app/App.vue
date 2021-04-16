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
                            <a class="navbar-item">
                                Register
                            </a>
                            <a class="navbar-item">
                                Login
                            </a>
                            <a class="navbar-item">
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
        <div class="tile is-ancestor">
            <sighting-list />

            <map-view />
        </div>

        <sighting-form />
    </section>
</template>

<script>
import { ref } from 'vue'
import SightingForm from './components/SightingForm.vue'
import SightingList from './components/SightingList.vue'
import SightingModal from './components/SightingModal.vue'
import Map from './components/Map.vue'
import Sighting from "./components/Sighting";

export default {
    components: {
        Sighting,
        'sighting-form': SightingForm,
        'sighting-list': SightingList,
        'sighting-modal': SightingModal,
        'map-view': Map
    },

    setup() {
        const navbarMenu = ref(false)

        function toggleNavbarMenu() {
            navbarMenu.value = !navbarMenu.value
        }

        return {
            navbarMenu,
            toggleNavbarMenu
        }
    }
}
</script>

<style scoped>
.hero {
    background-image: url("../../../public/images/ufo-green-hero.jpg");
    background-position: center;
    background-size: cover;
}

.navbar-burger {
    color: white;
}
</style>
