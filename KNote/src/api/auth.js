import axios from 'axios'

export function signIn (callback, body) {
  axios.post('/user/login', body,
    {
      headers: {'Content-Type': 'application/json'}
    }
  )
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function currentUser (callback, token) {
  axios.get('/user/me', {
    params: {
      token: token
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function signUp (callback, body) {
  axios.post('/user/register', body,
    {
      headers: {'Content-Type': 'application/json'}
    }
  )
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error.response.data)
    })
}

export function modifyUserInfo (callback, body) {
  axios.post('user/modifyInfo', body, {
    headers: {'Content-Type': 'application/json'}
  })
    .then(function (response) {
      console.log(response)
      callback(response.data)
    })
    .catch(function (error) {
      callback(error)
    })
}

export function modifyPassword (callback, body) {
  axios.post('user/modifyPassword', body, {
    headers: {'Content-Type': 'application/json'}
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error)
    })
}
