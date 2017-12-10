<template>
  <div>
    <el-col :span="4" style="padding-bottom: 220px">
      <div style="width: 100%;margin-left: 5%;height: 20px;">
        <el-card class="box-card" :body-style="{ padding: '0px' }">
          <img src="../../assets/user-photo.jpg" class="image">
          <div class="name-wrapper">
            {{this.userBrief.name}}
          </div>
          <div style="text-align: center;margin-bottom: 5%">
            <el-button type="text" size="mini" @click="jumpToUserProfile">查看个人主页</el-button>
          </div>
        </el-card>
      </div>
    </el-col>
  </div>
</template>

<script>
  import router from '../../router'
  import ElCard from '../../../node_modules/element-ui/packages/card/src/main.vue'
  import ElCol from 'element-ui/packages/col/src/col'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    components: {
      ElButton,
      ElCol,
      ElCard
    },
    name: 'briefUserProfileCard',
    props: ['userBrief'],
    methods: {
      jumpToUserProfile () {
        router.push({name: 'userProfile', params: {userId: this.userBrief.id}})
      }
    }
  }
</script>

<style scoped>
  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }

  .clearfix:after {
    clear: both;
  }

  .box-card {
    margin-left: 1%;
    margin-bottom: 3%;
  }

  .clearfix {
    text-align: left;
  }

  .box-card /deep/ .el-card__header {
    padding: 1px 15px;
  }

  /deep/ .el-card__body {
    padding: 10px 15px;
  }

  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
  }

  .name-wrapper {
    margin-top: 5%;
    margin-bottom: 2%;
    font-weight: bold;
    /*font-size: 1em;*/
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    text-align: center;
  }

  .notebook-info-wrapper {
    text-align: center;
    margin-top: 3px;
    font-size: smaller;
  }

  .image {
    width: 100%;
    display: block;
  }
</style>
