<template>
  <div>
    <menu-bar></menu-bar>
    <!--<profile-header class="profile-header-wrapper"></profile-header>-->
    <profile-modify-pane :userInfo="this.userInfo"></profile-modify-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import ProfileModifyPane from '../components/profile/panes/ProfileModifyPane.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import { mapState } from 'vuex'

  export default {
    components: {
      MainFoot,
      ProfileModifyPane,
      ProfileHeader,
      MenuBar
    },
    name: 'profileEdit',
    computed: {
      ...mapState('auth', {
        userInfo: state => state.user
      })
    }
  }
</script>

<style scoped>
  @import "../components/style/ProfileHeaderWrapper.css";
</style>
