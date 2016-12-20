const elixir = require('laravel-elixir');
const del = require('del');

require('laravel-elixir-vue');

elixir.extend('delete', function (path) {
  return new elixir.Task('delete', function () {
    del.sync(path);
  });
});

elixir((mix) => {

  mix.delete('public/static')
    .copy('./node_modules/@scalex/zero.front/dist/vue.blade.php', 'resources/views/app/')
    .copy('./node_modules/@scalex/zero.front/dist/static', 'public/static')
    .sass('web.scss')
    .version(['public/css/web.css']);
});
