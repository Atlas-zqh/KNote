<template>
  <div>
    <menu-bar></menu-bar>
    <!--<profile-header class="profile-header-wrapper"></profile-header>-->
    <profile-modify-pane></profile-modify-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import ProfileModifyPane from '../components/profile/panes/ProfileModifyPane.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'

  export default {
    components: {
      MainFoot,
      ProfileModifyPane,
      ProfileHeader,
      MenuBar
    },
    name: 'profileEdit'
  }
</script>

<style scoped>
  @import "../components/style/ProfileHeaderWrapper.css";
</style>
