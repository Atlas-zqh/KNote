import * as noteApi from '../../api/note'

const state = {
  latestNotes: [],
  curNote: null,
  workbenchNote: null,
  isLikingNote: false
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
    dispatch('fetchNoteDetail', {noteId: noteId, onSuccess: onSuccess, onError: onError})
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
    dispatch('fetchWorkbenchNoteDetail', {noteId: noteId, onSuccess: onSuccess, onError: onError})
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
        dispatch('refreshWorkbenchNoteDetail', {noteId: noteId, onSuccess: onSuccess, onError: onError})
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
        dispatch('refreshWorkbenchNoteDetail', {noteId: noteId, onSuccess: onSuccess, onError: onError})
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
        dispatch('refreshLatestNotes', {noteId: noteId})
        onSuccess(data)
      }
    }, token, noteId)
  },
  editNotePermission ({dispatch, commit}, {newPermission, noteInfo, onSuccess, onError}) {
    commit('editNotePermission', newPermission)
    let token = localStorage.getItem('token')
    noteApi.modifyNotePermission((data) => {
      if (data.error !== undefined) {
        let oldPermission = (newPermission === 'public') ? 'private' : 'public'
        commit('editNotePermission', oldPermission)
        onError(data.error)
      } else {
        dispatch('refreshNoteDetail', {noteId: noteInfo.id, onSuccess: onSuccess, onError: onError})
        onSuccess(data)
      }
    }, token, noteInfo)
  },
  editNoteContent ({dispatch}, {noteContent, onSuccess, onError}) {
    noteApi.modifyNoteContent((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data)
        }
      } else {
        dispatch('refreshWorkbenchNoteDetail', {noteId: noteContent.noteId, onSuccess: onSuccess, onError: onError})
        onSuccess(data)
      }
    }, noteContent)
  },
  createNote ({dispatch}, {noteInfo, onSuccess, onError}) {
    noteApi.addNote((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data)
        }
      } else {
        dispatch('notebook/fetchMyNotebooks', {
          userId: data.userId,
          onSuccess: onSuccess,
          onError: onError
        }, {root: true})
        dispatch('refreshWorkbenchNoteDetail', {noteId: data.noteId, onSuccess: onSuccess, onError: onError})
        onSuccess(data)
      }
    }, noteInfo)
  },
  likeCurNote ({dispatch}, {noteId, userId, onSuccess, onError}) {
    noteApi.likeNote((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data)
        }
      } else {
        dispatch('refreshNoteDetail', {noteId: noteId, onSuccess: onSuccess, onError: onError})
        dispatch('isLikingCurNote', {noteId: noteId, userId: userId, onSuccess: onSuccess, onError: onError})
        onSuccess(data)
      }
    }, noteId, userId)
  },
  unlikeCurNote ({dispatch}, {noteId, userId, onSuccess, onError}) {
    noteApi.unlikeNote((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data)
        }
      } else {
        console.log('note.js unlikeCurNote')
        console.log(data)
        dispatch('refreshNoteDetail', {noteId: noteId, onSuccess: onSuccess, onError: onError})
        dispatch('isLikingCurNote', {noteId: noteId, userId: userId, onSuccess: onSuccess, onError: onError})
        onSuccess(data)
      }
    }, noteId, userId)
  },
  isLikingCurNote ({commit}, {noteId, userId, onSuccess, onError}) {
    noteApi.isLikingNote((data) => {
      if (data.error !== undefined) {
        if (onError) {
          onError(data)
        }
      } else {
        console.log(data)
        commit('saveLikingNote', data.isLiking)
        onSuccess(data)
      }
    }, noteId, userId)
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
  },
  'editNotePermission' (state, newPermission) {
    state.curNote.note.permission = newPermission
  },
  'saveLikingNote' (state, isLiking) {
    state.isLikingNote = isLiking
  }
}

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
