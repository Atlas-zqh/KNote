import axios from 'axios'

export function getSearchResult (callback, userId, keyword) {
  axios.get('search/result', {
    params: {
      userId: userId,
      keyword: keyword
    }
  })
    .then(function (response) {
      callback(response.data)
    })
    .catch(function (error) {
      callback(error)
    })
}
