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
  }
}

const mutations = {
  'saveUser' (state, user) {
    state.user = user
  }
}

export default {
  // namespaced: true,
  state,
  // getters,
  actions,
  mutations
}
