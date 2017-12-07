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
