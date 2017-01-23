import debug from 'debug';

export default function plugin(Vue, options = {}) {
  if (plugin.installed === true) return;
  plugin.installed = true;

  if (options.debug !== true) {
    Object.defineProperty(Vue.prototype, '$debug', {
      get() {
        return () => {
          // Ignore!
        };
      },
    });
  } else {
    const logger = debug('app');
    debug.enable('app');

    Object.defineProperty(Vue.prototype, '$debug', {
      get() {
        return logger;
      },
    });
  }
}
