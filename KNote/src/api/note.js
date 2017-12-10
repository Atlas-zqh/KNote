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
  console.log('api/note.js 19')
  console.log(noteId)
  axios.get('note/detail', {
    params: {
      token: token,
      note_id: noteId
    }
  })
    .then(function (response) {
      console.log('response in api/note.js 30')
      console.log(response)
      callback(response.data)
    })
    .catch(function (error) {
      console.log('error in api/note.js 30')
      console.log(error)
      callback(error.response)
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

export function modifyNotePermission (callback, token, noteInfo) {
  axios.post('note/modifyPermission', noteInfo, {
    params: {
      token: token
    },
    headers:
      {
        'Content-Type': 'application/json'
      }
  })
    .then(function (response) {
      callback(response.data)
    }).catch(function (error) {
    callback(error.response)
  })
}

export function modifyNoteContent (callback, body) {
  axios.post('note/modify', body, {
    headers:
      {
        'Content-Type': 'application/json'
      }
  })
    .then(function (response) {
      callback(response.data)
    }).catch(function (error) {
    callback(error.response)
  })
}

export function addNote (callback, body) {
  axios.post('note/add', body, {
    headers:
      {
        'Content-Type': 'application/json'
      }
  })
    .then(function (response) {
      callback(response.data)
    }).catch(function (error) {
    callback(error.response)
  })
}

export function likeNote (callback, noteId, userId) {
  axios.get('note/like', {
    params: {
      noteId: noteId,
      userId: userId
    }
  }).then(function (response) {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}

export function unlikeNote (callback, noteId, userId) {
  axios.get('note/unlike', {
    params: {
      noteId: noteId,
      userId: userId
    }
  }).then(function (response) {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}

export function isLikingNote (callback, noteId, userId) {
  axios.get('note/isLikingNote', {
    params: {
      noteId: noteId,
      userId: userId
    }
  }).then(function (response) {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}
