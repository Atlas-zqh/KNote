import * as searchApi from '../../api/search'

const state = {
  searchResult: null
}

const actions = {
  fetchSearchResult ({commit}, {userId, keyword, onSuccess, onError}) {
    searchApi.getSearchResult((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        commit('saveSearchResult', data)
        onSuccess(data)
      }
    }, userId, keyword)
  }
}

const mutations = {
  'saveSearchResult' (state, result) {
    state.searchResult = result
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
