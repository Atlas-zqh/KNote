import * as authApi from '../../api/auth'

const state = {
  isSignedIn: false,
  user: null
}

// actions 异步
const actions = {
  signUp ({commit}, {body, onSuccess, onError}) {
    authApi.signUp(data => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        onSuccess(data.success)
      }
    }, body)
  },
  signIn ({dispatch}, {body, onSuccess, onError}) {
    authApi.signIn(data => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        localStorage.setItem('token', data.token)
        console.log(data)
        dispatch('fetchUser', {onSuccess})
      }
    }, body)
  },
  fetchUser ({commit, state}, {onSuccess}) {
    let token = localStorage.getItem('token')
    authApi.currentUser(data => {
      commit('saveUser', data.user)
      if (onSuccess) {
        onSuccess(state.user.username)
      }
    }, token)
  },
  signOut ({commit}, {onSuccess}) {
    const username = state.user.username
    localStorage.setItem('token', null)
    commit('saveUser', null)
    if (onSuccess) {
      onSuccess(username)
    }
  },
  refreshUser ({dispatch}, {onSuccess}) {
    const token = localStorage.getItem('token')
    if (token !== null) {
      dispatch('fetchUser', onSuccess)
    }
  }
}

const mutations = {
  'saveUser' (state, user) {
    state.user = user
  },
  'setSignedIn' (state) {
    state.isSignedIn = true
  },
  'setSignedUp' (state) {
    state.isSignedIn = false
  }
}

export default {
  // namespaced: true,
  state,
  // getters,
  actions,
  mutations
}
