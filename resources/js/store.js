import { createStore } from 'vuex'
import * as Auth from './app/shared/auth'
import moment from 'moment'

export default createStore({
    state: {
        sightings: null,
        currentPosition: [],
        isLoggedIn: false,
        user: null,
    },

    mutations: {
        setSightings(state, sightings) {
            state.sightings = sightings
        },

        setSighting(state, sighting) {
            state.sightings.push(sighting)
        },

        setCurrentPosition(state, coords) {
            state.currentPosition = coords
        },

        setUser(state, user) {
            state.user = user
        },

        setLoggedIn(state, isLoggedIn) {
            state.isLoggedIn = isLoggedIn
        }
    },

    actions: {
        loadStoredUser({ commit }) {
            commit('setLoggedIn', Auth.isLoggedIn())
        },

        async loadUser({ commit, dispatch }) {
            if (Auth.isLoggedIn()) {
                try {
                    const user = (await axios.get(`/user`)).data
                    commit('setUser', user)
                    commit('setLoggedIn', true)
                } catch (error) {
                    dispatch('logout')
                }
            }
        },

        logout({ commit }) {
            commit('setUser', null)
            commit('setLoggedIn', false)
            Auth.logOut()
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
