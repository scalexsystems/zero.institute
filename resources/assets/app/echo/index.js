function normalize (namespace, root, module) {
  namespace = namespace + ('namespace' in module ? `.${module.namespace}.` : '.')

  const reserved = ['namespace', 'modules']
  const events = Object.keys(module).filter(event => reserved.indexOf(event) < 0)

  for (let i = 0; i < events.length; i += 1) {
    root[`${namespace}${events[i]}`] = module[events[i]]
  }

  if ('modules' in module) {
    module.modules.each(m => normalize(namespace, root, m))
  }

  return root
}

const root = {
  namespace: 'Scalex.Zero',
  modules: [
      require('./group')
  ]
}

export default normalize('', root, root)
