import * as notebookApi from '../../api/notebook'

const state = {
  allNotebooks: [],
  myNotebooks: [],
  curUserNotebooks: [],
  curNoteBookNotes: null
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
        commit('saveCurUserNotebooks', data)
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, token, userId)
  },
  addNewNotebook ({dispatch}, {newNotebookInfo, onSuccess, onError}) {
    notebookApi.addNotebook((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        console.log(newNotebookInfo)
        dispatch('fetchCurUserNotebooks', {userId: newNotebookInfo.userId})
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, newNotebookInfo)
  },
  fetchNotesInNotebook ({commit}, {notebookId, userId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    notebookApi.getNotesInNotebook((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        commit('saveCurNotebookNotes', data)
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, token, userId, notebookId)
  },
  editNotebookInfo ({dispatch}, {notebookInfo, onSuccess, onError}) {
    notebookApi.modifyNotebook((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        console.log('notebook.js 85')
        console.log(notebookInfo)
        dispatch('fetchNotesInNotebook', {notebookId: notebookInfo.notebookId, userId: notebookInfo.userId})
        if (onSuccess) {
          onSuccess(data)
        }
      }
    }, notebookInfo)
  },
  deleteCurNotebook ({dispatch}, {userId, notebookId, onSuccess, onError}) {
    notebookApi.deleteNotebook((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data.error)
        }
      } else {
        dispatch('fetchCurUserNotebooks', {userId: userId})
        onSuccess(data)
      }
    }, notebookId)
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
  },
  'saveCurNotebookNotes' (state, curNotebookNotes) {
    state.curNoteBookNotes = curNotebookNotes
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
