<template>
  <div>
    <menu-bar></menu-bar>
    <div class="workbench-out">
      <side-bar></side-bar>



    </div>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import sideBar from '../components/workbench/SideBar.vue'
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'

  export default {
    name: 'workbench',
    components: {
      sideBar: sideBar,
      MenuBar,
      MainFoot
    }
  }
</script>

<style>
  .workbench-out {
    text-align: left;
  }

</style>


