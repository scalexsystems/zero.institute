import Vue from 'vue'

async function json (response) {
  if (/(text|application)\/json/i.test(response.headers.get('Content-Type'))) {
    return await response.json()
  }

  return response
}

async function wrap (request) {
  try {
    const response = await request

    return json(response)
  } catch (error) {

  }
}

export default {
  async any (method, ...args) {
    try {
      const response = await Vue.http[method](...args)

      return json(response)
    } catch (error) {
      if (error.status >= 422) {
        return json(error)
      }

      return error
    }
  },

  get (...args) {
    return this.any('get', ...args)
  }

  put (...args) {
    return this.any('put', ...args)
  }

  post (...args) {
    return this.any('post', ...args)
  }

  patch (...args) {
    return this.any('patch', ...args)
  }

  delete (...args) {
    return this.any('delete', ...args)
  }
}
