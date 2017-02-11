import Vue from 'vue'
import './bootstrap'
import App from './App.vue'
import store from './vuex'
import router from './routes'
import echo from './echo'

/* eslint-disable no-new */
new Vue({
  echo,
  store,
  router,
  ...App
}).$mount('#app')
