<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper" :curUserId="this.userId"></profile-header>
    <notebook-pane></notebook-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import NotebookPane from '../components/profile/panes/NotebookPane.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'

  export default {
    components: {
      MainFoot,
      NotebookPane,
      MenuBar,
      ProfileHeader
    },
    name: 'notebooks',
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
