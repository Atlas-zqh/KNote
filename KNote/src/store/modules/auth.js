import * as authApi from '../../api/auth'

const state = {
  // isSignedIn: false,
  user: null
}

// actions 异步
const actions = {
  signUp ({dispatch}, {body, onSuccess, onError}) {
    authApi.signUp(data => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        dispatch('signIn', {body: body, onSuccess: onSuccess, onError: onError})
        onSuccess(state.user.name)
      }
    }, body)
  },
  signIn ({dispatch}, {body, onSuccess, onError}) {
    authApi.signIn(data => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        localStorage.setItem('token', data.token)
        dispatch('fetchUser', {onSuccess: onSuccess})
      }
    }, body)
  },
  fetchUser ({commit, state}, {onSuccess}) {
    let token = localStorage.getItem('token')
    authApi.currentUser(data => {
      commit('saveUser', data.user)
      if (onSuccess) {
        onSuccess(state.user.name)
      }
    }, token)
  },
  signOut ({commit}, {onSuccess}) {
    const username = state.user.name
    localStorage.setItem('token', null)
    commit('saveUser', null)
    if (onSuccess) {
      onSuccess(username)
    }
  },
  refreshUser ({dispatch}, {onSuccess}) {
    const token = localStorage.getItem('token')
    if (token !== null) {
      dispatch('fetchUser', {onSuccess})
    }
  },
  editUserInfo ({dispatch, state}, {userInfo, onSuccess, onError}) {
    let userId = state.user ? state.user.id : null
    console.log(userId)
    userInfo.userId = userId
    authApi.modifyUserInfo(data => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        dispatch('refreshUser', onSuccess)
        onSuccess(data.success)
      }
    }, userInfo)
  },
  editUserPass ({state}, {password, onSuccess, onError}) {
    let userId = state.user ? state.user.id : null
    password.userId = userId
    authApi.modifyPassword(data => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        onSuccess(data.success)
      }
    }, password)
  }
}

const mutations = {
  'saveUser' (state, user) {
    state.user = user
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
