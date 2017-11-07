<template>
  <div class="main-page-wrapper">
    <menu-bar></menu-bar>
    <main-carousel></main-carousel>
    <main-medium-bar class="foot-wrapper"></main-medium-bar>
    <main-card class="card-wrapper"></main-card>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import menuBar from '../components/Layout/MenuBar.vue'
  import mainCarousel from '../components/mainPageComponents/MainCarousel.vue'
  import mainCard from '../components/mainPageComponents/MainCard.vue'
  import mainMediumBar from '../components/mainPageComponents/MainMediumBar.vue'
  import mainFoot from '../components/Layout/MainFoot.vue'

  export default {
    name: 'MainPage',
    components: {
      menuBar: menuBar,
      mainCarousel: mainCarousel,
      mainCard: mainCard,
      mainMediumBar: mainMediumBar,
      mainFoot: mainFoot
    }
  }
</script>

<style scoped>
  .main-page-wrapper {
    text-align: center;
  }

  .card-wrapper{
    margin-top: 30px;
    text-align: center;
    display: inline-block;
    width: 960px;
  }

  .card-wrapper /deep/ .el-row{
    text-align: center;
    position: relative;
    display: inline-block;
  }

  .foot-wrapper{
    margin-top: 30px;
  }
</style>
