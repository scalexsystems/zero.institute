import Vue from 'vue'

async function format (response) {
  if (/(text|application)\/json/i.test(response.headers.get('Content-Type'))) {
    return await response.json()
  }

  return response
}

async function process (response) {
  if (response.status === 422) {
    return (await format(response)).errors
  }

  if (response.status === 403) {
    // TODO: Redirect to login. User session expired.
  }

  if (response.status === 401) {
    // TODO: Notify user resource is not accessible.
  }

  if (response.status === 500) {
    // TODO: Take to sentry feedback page.
  }

  if (response.status === 404) {
    // TODO: Notify user resource not found.
  }

  if (response.status === 413) {
    // TODO: File size too large.
  }

  if (response.status === 429) {
    // TODO: Wait for cool down.
  }
}

export default {
  async any (method, ...args) {
    const shouldThrow = (args[0] === true)

    if (shouldThrow) args.shift()

    try {
      const response = await Vue.http[method].apply(Vue.http, args)

      return format(response)
    } catch (error) {
      const errors = await process(error)

      if (shouldThrow) throw { errors, response: error }

      return {}
    }
  },

  get (...args) {
    return this.any('get', ...args)
  },

  put (...args) {
    return this.any('put', ...args)
  },

  post (...args) {
    return this.any('post', ...args)
  },

  patch (...args) {
    return this.any('patch', ...args)
  },

  delete (...args) {
    return this.any('delete', ...args)
  }
}
