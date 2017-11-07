const state = {
  isCollapsed: true
}

const getters = {
  isCollapsed: state => state.isCollapsed
}

const mutations = {
  changeCollapse (state) {
    state.isCollapsed = !state.isCollapsed
  }
}

export default {
  state,
  getters,
  mutations
  // actions
}
