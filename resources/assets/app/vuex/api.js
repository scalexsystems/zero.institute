import Vue from 'vue'

async function format (response) {
  if (/(text|application)\/json/i.test(response.headers.get('Content-Type'))) {
    return await response.json()
  }

  return response
}

async function process (response) {
  const result = await format(response)

  if (response.status === 422) {
    if (result.errors) {
      result.errors.$message = 'There is some problem with your input. Make required changes and save again.'
    }

    return result.errors
  }

  if (response.status === 403) {
    return { $message: 'It feels like your session has expired.' }
  }

  if (response.status === 405) {
    return { $message: 'Ah! Oh! Feels like developer missed this one. Tell support that: <strong>There is an 405 here!</strong>' }
  }

  if (response.status === 401) {
    return { $message: 'You don\'t have access to perform this action.' }
  }

  if (response.status === 404) {
    return { $message: 'There is nothing like this on Zero servers. (Not Found)' }
  }

  if (response.status === 413) {
    return { $message: 'Oops! You file is too large to handle.' }
  }

  if (response.status === 429) {
    return { $message: 'Slow down! You\'ve hit the Zero servers too frequently. Wait for few minutes and try again.' }
  }

  if (response.status >= 500) {
    return { $message: 'Some unexpected error occurred. Don\'t worry developers have been notified, it would be fixed soon.' }
  }

  if (result && result.message) {
    return { $message: result.message }
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

      if (shouldThrow) {
        const e = { errors, response: error }

        throw e
      }

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
