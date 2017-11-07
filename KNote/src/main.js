// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import '../theme/index.css'
import './index.css'
import VModal from 'vue-js-modal'
import store from './store'
import axios from 'axios'
import VueRouter from 'vue-router'

Vue.use(VModal)
Vue.use(VueRouter)
Vue.config.productionTip = false
Vue.use(ElementUI)
axios.defaults.baseURL = '/api'

/* eslint-disable no-new */
const app = new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: {App}
})

export { app, store, router }
