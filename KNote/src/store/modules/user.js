import * as userApi from '../../api/user'

const state = {
  info: [],
  frequentTags: [],
  hotNotes: [],
  followers: [],
  following: [],
  isFollowingThisUser: false
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
  },
  followCurUser ({dispatch}, {userId, followedUserId, onError, onSuccess}) {
    userApi.followUser((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        console.log('followCurUser userId ', userId)
        dispatch('auth/refreshUser', {onSuccess: onSuccess}, {root: true})
        dispatch('fetchUserInfo', followedUserId)
        dispatch('isFollowingCurUser', {
          userId: userId,
          followedUserId: followedUserId,
          onSuccess: onSuccess,
          onError: onError
        })
        onSuccess(data)
      }
    }, userId, followedUserId)
  },
  unfollowCurUser ({dispatch}, {userId, followedUserId, onSuccess, onError}) {
    userApi.unFollowUser((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        dispatch('auth/refreshUser', {onSuccess: onSuccess}, {root: true})
        dispatch('fetchUserInfo', followedUserId)
        dispatch('isFollowingCurUser', {
          userId: userId,
          followedUserId: followedUserId,
          onSuccess: onSuccess,
          onError: onError
        })
        onSuccess(data)
      }
    }, userId, followedUserId)
  },
  isFollowingCurUser ({commit}, {userId, followedUserId, onSuccess, onError}) {
    userApi.isFollowingUser((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        commit('saveIsFollowingThisUser', data.isFollowing)
        onSuccess(data)
      }
    }, userId, followedUserId)
  }
}

const mutations = {
  'saveUserInfo' (state, userInfo) {
    console.log('userInfo')
    console.log(userInfo)
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
  },
  'saveIsFollowingThisUser' (state, isFollowingThisUser) {
    state.isFollowingThisUser = isFollowingThisUser
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
