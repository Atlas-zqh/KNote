import axios from 'axios'

export function getCountInfo (callback, userId) {
  axios.get('/user/userInfo', {
    params: {
      userId: userId
    }
  })
    .then((response) => {
      callback(response.data)
    })
    .catch(function (error) {
      console.log(error)
    })
}

export function getFrequentTags (callback, userId) {
  axios.get('user/frequentTags', {
    params: {
      userId: userId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    console.log(error)
  })
}

export function getHotNotes (callback, userId) {
  axios.get('user/hotNotes', {
    params: {
      userId: userId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    console.log(error)
  })
}

export function getFollowers (callback, userId) {
  axios.get('user/followers', {
    params: {
      userId: userId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    console.log(error)
  })
}

export function getFollowing (callback, userId) {
  axios.get('user/following', {
    params: {
      userId: userId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    console.log(error)
  })
}
