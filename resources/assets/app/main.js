import Vue from 'vue'
import './bootstrap'
import App from './App.vue'
import store from './vuex'
import router from './routes'
import echo from './echo'
import policies from './policies'

/* eslint-disable no-new */
new Vue({
  echo,
  store,
  router,
  policies,
  ...App
}).$mount('#app')
