import * as userApi from '../../api/user'

const state = {
  info: [],
  frequentTags: [],
  hotNotes: [],
  followers: [],
  following: []
}

const actions = {
  fetchUserInfo ({commit}, userId) {
    userApi.getCountInfo((data) => {
      commit('saveUserInfo', data.user)
    }, userId)
  },
  fetchFrequentTags ({commit}, userId) {
    userApi.getFrequentTags((data) => {
      commit('saveFrequentTags', data)
    }, userId)
  },
  fetchHotNotes ({commit}, userId) {
    userApi.getHotNotes((data) => {
      commit('saveHotNotes', data)
    }, userId)
  },
  fetchFollowers ({commit}, userId) {
    userApi.getFollowers((data) => {
      commit('saveFollowers', data)
    }, userId)
  },
  fetchFollowing ({commit}, userId) {
    userApi.getFollowing((data) => {
      commit('saveFollowing', data)
    }, userId)
  }
}

const mutations = {
  'saveUserInfo' (state, userInfo) {
    state.info = userInfo
  },
  'saveFrequentTags' (state, tags) {
    state.frequentTags = tags
  },
  'saveHotNotes' (state, hotNotes) {
    state.hotNotes = hotNotes
  },
  'saveFollowers' (state, followers) {
    state.followers = followers
  },
  'saveFollowing' (state, following) {
    state.following = following
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
