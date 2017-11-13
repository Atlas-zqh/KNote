<template>
  <div>
    <el-card>
      <el-row>
        <el-col :span="5">
          <div class="user-pic-content"></div>
        </el-col>
        <el-col :span="7" class="friends-info-wrapper">
          <div class="name-text-wrapper">
            {{friendName}}
          </div>
          <div class="fans-text-wrapper">
            {{friendFans}} 位粉丝
          </div>
        </el-col>
        <el-col :span="7" class="button-col-wrapper">
          <el-button class="button-wrapper">+ 关注</el-button>
        </el-col>
      </el-row>
    </el-card>
  </div>
</template>

<script>
  import ElCard from '../../../node_modules/element-ui/packages/card/src/main.vue'
  import ElRow from 'element-ui/packages/row/src/row'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    components: {
      ElButton,
      ElRow,
      ElCard
    },
    name: 'friendsBriefIntro',
    data () {
      return {
        friendName: 'ISLAND2015282',
        friendFans: '50'
      }
    }
  }
</script>

<style scoped>
  .user-pic-content {
    /*margin-top: -65px;*/
    border-radius: 50%;
    background-image: url("../../assets/user-photo.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    height: 80px;
    width: 80px;
    box-shadow: #666666 2px 2px 2px;
  }

  .name-text-wrapper {
    text-align: left;
    font-size: 120%;
  }

  .friends-info-wrapper {
    margin-left: 3%;
    padding-left: 30px;
    margin-top: 4%;
  }

  .fans-text-wrapper {
    text-align: left;
    font-size: 14px;
    padding-top: 5%;
  }

  .button-wrapper {
    /*position: relative;*/
    float: right;
  }

  .button-col-wrapper {
    float: right;
    padding-top: 6%;
    padding-bottom: 3%;
  }
</style>
