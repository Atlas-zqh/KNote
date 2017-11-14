<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper"></profile-header>
    <sharing-pane></sharing-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import SharingPane from '../components/profile/panes/SharingPane.vue'
  import ElButton from '../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    name: 'userProfile',
    components: {
      ElButton,
      MenuBar,
      MainFoot,
      ProfileHeader,
      SharingPane
    }
  }
</script>

<style scoped>
  @import "../components/style/ProfileHeaderWrapper.css";
</style>
