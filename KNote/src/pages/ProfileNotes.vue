<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper"></profile-header>
    <profile-note-pane></profile-note-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import ProfileNotePane from '../components/profile/panes/ProfileNotePane.vue'

  export default {
    components: {
      ProfileNotePane,
      MainFoot,
      ProfileHeader,
      MenuBar
    },
    name: 'profileNotes'
  }
</script>

<style scoped>
  @import "../components/style/ProfileHeaderWrapper.css";
</style>
