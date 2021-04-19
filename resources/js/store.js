import { createStore } from 'vuex'

export default createStore({
    state: {
        sightings: null,
        currentPosition: ''
    },

    mutations: {
        setSightings(state, sightings) {
            state.sightings = sightings
        },

        setCurrentPosition(state, coords) {
            state.coords = coords
        }
    },

    getters: {
        topSightings: state => {
            const sightings = []

            for (const sighting of Object.values(state.sightings)) {
                sightings.push(sighting)
            }

            return {
                ...sightings
                    .sort((a, b) => b.likes - a.likes)
                    .slice(0, 3)
            }
        }
    }
})
