<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper"></profile-header>
    <friends-pane></friends-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import FriendsPane from '../components/profile/FriendsPane.vue'

  export default {
    components: {
      FriendsPane,
      MainFoot,
      MenuBar,
      ProfileHeader
    },
    name: 'friendsPage'
  }
</script>

<style scoped>
  .profile-header-wrapper {
    margin-top: 20px;
    z-index: 1;
  }
</style>
