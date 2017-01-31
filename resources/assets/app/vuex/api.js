import Vue from 'vue'

async function format (response) {
  if (/(text|application)\/json/i.test(response.headers.get('Content-Type'))) {
    return await response.json()
  }

  return response
}

async function process (response) {
}

export default {
  async any (method, ...args) {
    const shouldThrow = (args[0] === true)

    if (shouldThrow) args.shift()

    try {
      const response = await Vue.http[method].apply(Vue.http, args)

      return format(response)
    } catch (error) {
      error = await process(error)

      if (shouldThrow) throw error
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
