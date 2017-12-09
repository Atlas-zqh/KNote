<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper" :curUserId="this.userId"></profile-header>
    <notebook-note-pane></notebook-note-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import NotebookNotePane from '../components/profile/panes/NotebookNotePane.vue'

  export default {
    components: {
      NotebookNotePane,
      MenuBar,
      ProfileHeader,
      MainFoot
    },
    name: 'notebookNote',
    data () {
      return {
        userId: this.$route.params.userId
      }
    }
  }
</script>

<style>
  @import "../components/style/ProfileHeaderWrapper.css";
</style>
