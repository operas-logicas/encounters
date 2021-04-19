import { createStore } from 'vuex'
import moment from 'moment'

export default createStore({
    state: {
        sightings: null,
        currentPosition: []
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

            const end = sightings.length > 3 ? 3 : sightings.length

            return {
                ...sightings
                    .sort((a, b) => {
                        // Sort by likes desc
                        if (b.likes > a.likes) return 1
                        if (a.likes > b.likes) return -1

                        // If likes are the same, sort by dates desc
                        const date1 = moment(a.date)
                        const date2 = moment(b.date)

                        if (date2.diff(date1) > date1.diff(date2)) return 1
                        else return -1
                    })
                    .slice(0, end)
            }
        }
    }
})
