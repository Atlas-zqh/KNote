import axios from 'axios'

export function getNotes (callback, token, userId) {
  axios.get('note/getNotes', {
    params: {
      token: token,
      userId: userId
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function getNoteDetail (callback, token, noteId) {
  axios.get('note/detail', {
    params: {
      token: token,
      note_id: noteId
    }
  })
    .then(function (response) {
      console.log(response)
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function deleteTagRelation (callback, token, relationId) {
  axios.get('note/deleteTagRelation', {
    params: {
      token: token,
      relationId: relationId
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function addTagRelation (callback, token, noteId, tagContent) {
  axios.get('note/addTagRelation', {
    params: {
      token: token,
      noteId: noteId,
      tagContent: tagContent
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function deleteNote (callback, token, noteId) {
  axios.get('note/delete', {
    params: {
      token: token,
      noteId: noteId
    }
  }).then(function (response) {
    callback(response.data)
  }).catch(function (error) {
    callback(error.response.data)
  })
}
