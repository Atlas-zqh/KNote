<template>
  <div>
    <menu-bar></menu-bar>
    <profile-header class="profile-header-wrapper"></profile-header>
    <note-view-pane></note-view-pane>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import NoteViewPane from '../components/profile/panes/NoteViewPane.vue'
  import ProfileHeader from '../components/profile/ProfileHeader.vue'

  export default {
    components: {
      ProfileHeader,
      NoteViewPane,
      MainFoot,
      MenuBar
    },
    name: 'noteView'
  }
</script>

<style scoped>
  @import "../components/style/ProfileHeaderWrapper.css";

</style>
