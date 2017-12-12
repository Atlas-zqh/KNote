import * as adminApi from '../../api/admin'

const state = {
  adminSearchResult: null,
  adminSearchKeyword: ''
}

const actions = {
  fetchAdminSearchResult ({commit}, {keyword, onSuccess, onError}) {
    adminApi.getAdminSearchResult((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        commit('saveAdminSearchResult', data.users)
        commit('saveAdminSearchKeyword', keyword)
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, keyword)
  },
  doBlockUser ({dispatch}, {userId, keyword, onSuccess, onError}) {
    adminApi.blockUser((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        dispatch('fetchAdminSearchResult', {keyword: keyword, onSuccess: onSuccess, onError: onError})
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, userId)
  },
  doUnblockUser ({dispatch}, {userId, keyword, onSuccess, onError}) {
    adminApi.unblockUser((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        dispatch('fetchAdminSearchResult', {keyword: keyword, onSuccess: onSuccess, onError: onError})
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, userId)
  },
  doResetPass ({userId, onSuccess, onError}) {
    adminApi.reset((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, userId)
  }
}

const mutations = {
  'saveAdminSearchResult' (state, result) {
    state.adminSearchResult = result
  },
  'saveAdminSearchKeyword' (state, keyword) {
    state.adminSearchKeyword = keyword
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
