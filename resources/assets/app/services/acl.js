import { isObject, isString, isFunction } from '../util'

export default function (Vue) {
  Vue.mixin({
    beforeCreate () {
      this.$policies = 'policies' in this.$options ? this.$options.policies : {}
      this.$rootPolicies = this.$parent ? this.$parent.$rootPolicies : this.$policies
    }
  })

  Vue.prototype.$can = function (rule, resource) {
    const policy = resolver(resource, this.$policies, this.$rootPolicies)

    if (!policy) {
      throw new Error(`Cannot find policy for resource: ${resource}`)
    }
    const user = wrap(this.$store.state.user)

    return check(policy, rule, user, resource)
  }
}

function resolver (resource, policies, rootPolices) {
  const type = isObject(resource) ? resource._type : (isString(resource) ? resource : null)


  if (type in policies) return policies[type]

  if (type in rootPolices) return rootPolices[type]

  console.error('Cannot find policy for resource:', type)

  return null
}

function wrap (user) {
  return {
    hasPermission (name) {
      return (user.permissions || []).indexOf(name) > -1
    },
    hasRole (name) {
      return (user.roles || []).indexOf(name) > -1
    },
    user () {
      return user
    },
    get id () {
      return user.id
    }
  }
}

function check (policy, rule, user, resource) {
  const camel = rule.replace(/-(.)/g, m => m[1].toLocaleUpperCase())

  const callable = policy[camel] || policy[rule]

  if (! isFunction(callable) ) {
    console.warn(`Cannot find '${rule}' or '${camel}' in `, policy)

    return false
  }

  return callable.call(policy, user, resource)
}
