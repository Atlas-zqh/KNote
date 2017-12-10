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

export function followUser (callback, userId, followedUserId) {
  axios.get('user/follow', {
    params: {
      follow_user_id: userId,
      followed_user_id: followedUserId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}

export function unFollowUser (callback, userId, followedUserId) {
  axios.get('user/unFollow', {
    params: {
      follow_user_id: userId,
      followed_user_id: followedUserId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}

export function isFollowingUser (callback, userId, followedUserId) {
  axios.get('user/isFollowing', {
    params: {
      follow_user_id: userId,
      followed_user_id: followedUserId
    }
  }).then((response) => {
    callback(response.data)
  }).catch(function (error) {
    callback(error)
  })
}
