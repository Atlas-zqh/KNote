import * as notebookApi from '../../api/notebook'

const state = {
  allNotebooks: [],
  myNotebooks: [],
  curUserNotebooks: []
}

const actions = {
  fetchNotebooksAndNotes ({commit}, {userId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    notebookApi.getNotebooksAndNotes((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        commit('saveAllNoteBooks', data)
        onSuccess(data)
      }
    }, token, userId)
  },
  fetchMyNotebooks ({commit}, {userId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    notebookApi.getNotebooks((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        commit('saveMyNotebooks', data)
        onSuccess(data)
      }
    }, token, userId)
  },
  fetchCurUserNotebooks ({commit}, {userId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    notebookApi.getNotebooks((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        commit('saveCurUserNotebooks', data)
        onSuccess(data)
      }
    }, token, userId)
  }
}

const mutations = {
  'saveAllNoteBooks' (state, allNotebooks) {
    state.allNotebooks = allNotebooks
  },
  'saveMyNotebooks' (state, myNotebooks) {
    state.myNotebooks = myNotebooks
  },
  'saveCurUserNotebooks' (state, curUserNotebooks) {
    state.curUserNotebooks = curUserNotebooks
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
