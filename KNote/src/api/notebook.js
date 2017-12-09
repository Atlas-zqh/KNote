import axios from 'axios'

export function getNotebooksAndNotes (callback, token, userId) {
  axios.get('workbench', {
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

export function getNotebooks (callback, token, userId) {
  axios.get('notebooks', {
    params: {
      token: token,
      userId: userId
    }
  }).then(function (response) {
    console.log('getNotebooks')
    console.log(response)
    callback(response.data)
  }).catch(function (error) {
    callback(error.response.data)
  })
}

export function addNotebook (callback, body) {
  axios.post('notebooks/add', body, {
    headers: {'Content-Type': 'application/json'}
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error)
    })
}

export function getNotesInNotebook (callback, token, userId, notebookId) {
  axios.get('notebooks/getNotes', {
    params: {
      token: token,
      userId: userId,
      notebookId: notebookId
    }
  }).then(function (response) {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}

export function modifyNotebook (callback, body) {
  axios.post('notebooks/modify', body, {
    headers: {'Content-Type': 'application/json'}
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error)
    })
}

export function deleteNotebook (callback, notebookId) {
  axios.get('notebooks/delete', {
    params: {
      notebookId: notebookId
    }
  })
    .then(function (response) {
      callback(response.data)
    }).catch(function (error) {
    callback(error)
  })
}
