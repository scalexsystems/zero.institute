import Vue from 'vue'
import './bootstrap'
import App from './App.vue'
import store from './vuex'
import router from './routes/index'

/* eslint-disable no-new */
new Vue({
  render: h => h(App),
  store,
  router
}).$mount('#app')
