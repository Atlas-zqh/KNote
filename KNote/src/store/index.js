import Vue from 'vue'
import Vuex from 'vuex'
// import * as actions from './actions'
// import * as getters from './getters'
import WorkbenchEditor from './modules/WorkbenchEditor'
import createLogger from 'vuex/dist/logger'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  // actions,
  // getters,
  modules: {
    WorkbenchEditor
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})
