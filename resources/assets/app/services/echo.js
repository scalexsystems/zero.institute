import Echo from 'laravel-echo'
import { each, only, isArray, toArray, isObject } from '../util'

const aliases = {}

export default function (Vue, options) {
  if ('namespace' in options && options.namespace[0] !== '.') {
    options.namespace = `.${options.namespace}`
  }

  const echo = new Echo(options)

  Vue.mixin({
    beforeCreate () {
      this._channels = {}
      this._echoEvents = normalize(options.namespace || '', {}, this.$options.echo || {})
    },
    created () {
      if ('channel' in this.$options) {
        each(toArray(this.$options.channel), channel => this.$channel(channel))
      }
    },
    beforeDestroy () {
      each(Object.keys(this._channels), name => this.$stopChannel(name))

      delete this._channels
      delete this._echoEvents
    }
  })

  Vue.echo = echo
  Vue.prototype.$echoAlias = function (channel, alias) {
    aliases[alias] = channel
  }
  Vue.prototype.$echo = echo
  Vue.prototype.$stopChannel = function (any) {
    let name

    try {
      name = parseChannel(any).name
    } catch (e) {
      name = any
    }

    if (!(name in this._channels)) return

    this.$debug(`[echo] Unsubscribe channel: ${name}`)
    const { channel, handlers } = this._channels[name]

    each(handlers, (handler, event) => {
      channel.unbind(event, handler)
    })

    delete this._channels[name]
  }
  Vue.prototype.$channel = function (channel, names, extras) {
    const { name, type } = parseChannel(channel)

    if (name in this._channels) return

    const events = isArray(names) ? only(this._echoEvents, names) : this._echoEvents

    // eslint-disable-next-line
    const ctx = { channel: echo[type].call(echo, name), handlers: {}}
    this.$debug(`[echo] Subscribe channel: ${name}`)

    each(events, (cb, event) => {
      ctx.handlers[event] = (payload) => {
        this.$debug(`[echo] ${event} on ${name}:${type}`, payload)
        cb.call(this, payload, this.$store, this.$root, extras)
      }

      this.$debug(`[echo] Listen ${event} on ${name}:${type}`)
      ctx.channel.listen(event, ctx.handlers[event])
    })

    this._channels[name] = ctx
  }
}

/**
 * Get channel name & type
 *
 * @param {string} channel
 * @return {{type: {string}, name: {string}}}
 */
function parseChannel (channel) {
  channel = aliases[channel] || channel || ''
  const re = /^(private|public|presence):(.*)$/
  const [, type, name] = re.exec(channel) || []

  if (!type || !name) throw new Error(`Invalid channel name: ${channel}`)

  const mapping = {
    private: 'private',
    presence: 'join',
    public: 'channel'
  }

  return { type: mapping[type], name }
}

/**
 * Normalize event namespaces.
 *
 * @param {string} namespace
 * @param {Object} root
 * @param {Object} module
 * @return {*}
 */
function normalize (namespace, root, module) {
  if ('namespace' in module) {
    if (namespace === '' || module.namespace[0] === '.') {
      namespace = module.namespace
    } else {
      namespace += `.${module.namespace}`
    }
  }

  if (namespace[namespace.length - 1] !== '.') {
    namespace += '.'
  }

  const reserved = ['namespace']

  each(module, (cb, event) => {
    if (reserved.indexOf(event) > -1) return

    if (isObject(cb)) {
      root = normalize(`${namespace}${event}`, root, cb)
    } else {
      root[`${namespace}${event}`] = cb
    }
  })

  return root
}
