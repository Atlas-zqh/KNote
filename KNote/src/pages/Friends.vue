<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper" :curUserId="this.userId"></profile-header>
    <friends-pane></friends-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import FriendsPane from '../components/profile/panes/FriendsPane.vue'

  export default {
    components: {
      FriendsPane,
      MainFoot,
      MenuBar,
      ProfileHeader
    },
    name: 'friendsPage',
    data () {
      return {
        userId: this.$route.params.userId
      }
    }
  }
</script>

<style scoped>
  @import "../components/style/ProfileHeaderWrapper.css";
</style>
