import Echo from 'laravel-echo';

export default function install(Vue, options) {
  if (install.installed) return;

  install.installed = true;

  const echo = new Echo(options);

  echo.registerVueRequestInterceptor();

  Object.defineProperty(Vue, 'echo', {
    get() {
      return echo;
    },
  });
  Object.defineProperty(Vue.prototype, '$echo', {
    get() {
      return echo;
    },
  });
}
