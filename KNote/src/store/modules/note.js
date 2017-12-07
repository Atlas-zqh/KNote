import * as noteApi from '../../api/note'

const state = {
  latestNotes: [],
  curNote: null,
  workbenchNote: null
}

const actions = {
  fetchLatestNotes ({commit}, userId) {
    let token = localStorage.getItem('token')
    noteApi.getNotes((data) => {
      commit('saveLatestNotes', data)
    }, token, userId)
  },
  refreshLatestNotes ({dispatch}, userId) {
    dispatch('fetchLatestNotes', userId)
  },
  fetchNoteDetail ({commit}, {noteId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    noteApi.getNoteDetail((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        commit('saveCurNote', data)
        onSuccess(data)
      }
    }, token, noteId)
  },
  refreshNoteDetail ({dispatch}, {noteId, onSuccess, onError}) {
    dispatch('fetchNoteDetail', noteId, onSuccess, onError)
  },
  fetchWorkbenchNoteDetail ({commit}, {noteId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    noteApi.getNoteDetail((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        commit('saveWorkbenchNote', data)
        onSuccess(data)
      }
    }, token, noteId)
  },
  refreshWorkbenchNoteDetail ({dispatch}, {noteId, onSuccess, onError}) {
    dispatch('fetchWorkbenchNoteDetail', noteId, onSuccess, onError)
  },
  setWorkbenchNoteNull ({commit}) {
    commit('saveWorkbenchNote', null)
  },
  deleteTagRelation ({dispatch}, {noteId, relationId, onSuccess, onError}) {
    console.log(noteId)
    let token = localStorage.getItem('token')
    noteApi.deleteTagRelation((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        dispatch('refreshWorkbenchNoteDetail', noteId, onSuccess, onError)
        onSuccess(data)
      }
    }, token, relationId)
  },
  addTagRelation ({dispatch, commit}, {noteId, tagContent, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    noteApi.addTagRelation((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        console.log(data)
        commit('addTag', data)
        dispatch('refreshWorkbenchNoteDetail', noteId, onSuccess, onError)
        onSuccess(data)
      }
    }, token, noteId, tagContent)
  },
  deleteNote ({dispatch}, {noteId, onSuccess, onError}) {
    let token = localStorage.getItem('token')
    noteApi.deleteNote((data) => {
      if (data.error !== undefined) {
        onError(data.error)
      } else {
        dispatch('refreshLatestNotes', noteId)
        onSuccess(data)
      }
    }, token, noteId)
  }
}

const mutations = {
  'saveLatestNotes' (state, latestNotes) {
    state.latestNotes = latestNotes
  },
  'saveCurNote' (state, curNote) {
    state.curNote = curNote
  },
  'saveWorkbenchNote' (state, workbenchNote) {
    state.workbenchNote = workbenchNote
  },
  'removeTag' (state, tag) {
    state.workbenchNote.tags.splice(state.workbenchNote.tags.indexOf(tag), 1)
  },
  'addTag' (state, data) {
    state.workbenchNote.tags.push({
      relationId: data.relationId,
      id: data.id,
      tag_content: data.tagContent
    })
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
