import Echo from 'laravel-echo'
import { each, only, isArray, toArray, isObject } from '../util'

/**
 * Normalize event namespaces.
 *
 * @param {string} namespace
 * @param {Object} root
 * @param {Object} module
 * @return {*}
 */
function normalize (namespace, root, module) {
  namespace = (
      namespace + ('namespace' in module ? `.${module.namespace}.` : '.')
  ).replace(/[.]{2,}/, '.')

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

/**
 * Get channel name & type
 *
 * @param {string} channel
 * @return {{type: {string}, name: {string}}}
 */
function parseChannel (channel) {
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

export default function (Vue, options) {
  const echo = new Echo(options)

  Vue.mixin({
    beforeCreate () {
      this._channels = {}
      this._echoEvents = normalize('', {}, this.$options.echo || {})
    },
    created () {
      if ('channel' in this.$options) {
        each(toArray(this.$options.channel), channel => this.$channel(channel))
      }
    },
    beforeDestroy () {
      each(this._channels, channel => channel.unsubscribe())
    }
  })

  Vue.echo = echo
  Vue.prototype.$echo = echo
  Vue.prototype.$stopChannel = function (channel) {
    const { name } = parseChannel(channel)

    if (name in this._channels) {
      this._channels[name].unsubscribe()

      delete this._channels[name]
    }
  }
  Vue.prototype.$channel = function (channel, names, extras) {
    const { name, type } = parseChannel(channel)

    if (name in this._channels) return

    const events = isArray(names) ? only(this._echoEvents, names) : this._echoEvents

    this._channels[name] = echo[type].call(echo, name)

    each(events, (cb, event) => {
      console.log(`(${type}) ${name}: ${event}`)
      this._channels[name].listen(event, (event) => {
        cb.call(this, event, this.$store, this.$root, extras)
      })
    })
  }
}
