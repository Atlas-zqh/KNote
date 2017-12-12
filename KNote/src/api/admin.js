import axios from 'axios'

export function getAdminSearchResult (callback, keyword) {
  axios.get('admin/search', {
    params: {
      adminSearchKeyword: keyword
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response)
    })
}

export function blockUser (callback, userId) {
  axios.get('admin/block', {
    params: {
      userId: userId
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response)
    })
}

export function unblockUser (callback, userId) {
  axios.get('admin/unblock', {
    params: {
      userId: userId
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response)
    })
}

export function reset (callback, userId) {
  axios.get('admin/reset', {
    params: {
      userId: userId
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response)
    })
}
