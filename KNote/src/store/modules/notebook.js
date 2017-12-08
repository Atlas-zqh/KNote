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
        if (onError) {
          onError(data.error)
        }
      } else {
        console.log('success')
        console.log('aaaa ' + userId)
        commit('saveCurUserNotebooks', data)
        console.log(data)
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, token, userId)
  },
  addNewNotebook ({dispatch}, {newNotebookInfo, onSuccess, onError}) {
    notebookApi.addNotebook((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        console.log(newNotebookInfo)
        dispatch('fetchCurUserNotebooks', {userId: newNotebookInfo.userId})
        onSuccess(data)
      }
    }, newNotebookInfo)
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
