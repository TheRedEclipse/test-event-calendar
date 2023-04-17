import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";

const store = createStore({
  state () {
    return {
        currentUser: {},
        isLoggedIn: false,
    }
  },
  mutations: {
    logined(state, payload) {
        console.log(state, payload)
        state.isLoggedIn = true
        state.currentUser = Object.assign({}, payload.user, {
          token: payload.access_token,
        })
      },
    logout(state) {
        state.isLoggedIn = false
        state.currentUser = {}
    },
  },
  actions: {
    logined(context, content) {
      context.commit('logined', content)
    },
    logout(context) {
      context.commit('logout')
    },
  },
  getters: {
    isLoggedIn(state) {
      return state.isLoggedIn
    },
    currentUser(state) {
      return state.currentUser
    },
  },
  plugins: [createPersistedState()],
})

export default store

