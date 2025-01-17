import axios from "axios";

export default class Api {
  static get(url) {
    return new Promise((resolve, reject) => {
      axios
        .get(url)
        .then(({data}) => resolve(data))
        .catch(({response}) => reject(response))
    })
  }

  static post(url, data) {
    return new Promise((resolve, reject) => {
      axios
        .post(url, data)
        .then(({data}) => resolve(data))
        .catch(({response}) => reject(response))
    })
  }

  static delete(url) {
    return new Promise((resolve, reject) => {
      axios
        .delete(url)
        .then(({data}) => resolve(data))
        .catch(({response}) => reject(response))
    })
  }
}