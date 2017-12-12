import Vue from 'vue'
import Vuex from 'vuex'
// import * as actions from './actions'
// import * as getters from './getters'
import WorkbenchEditor from './modules/WorkbenchEditor'
import auth from './modules/auth'
import user from './modules/user'
import note from './modules/note'
import notebook from './modules/notebook'
import search from './modules/search'
import admin from './modules/admin'
import createLogger from 'vuex/dist/logger'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  // actions,
  // getters,
  modules: {
    WorkbenchEditor,
    auth,
    user,
    note,
    notebook,
    search,
    admin
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})
