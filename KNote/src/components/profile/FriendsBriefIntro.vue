<template>
  <div>
    <el-card>
      <el-row>
        <el-col :span="5">
          <div class="user-pic-content"></div>
        </el-col>
        <el-col :span="7" class="friends-info-wrapper">
          <div class="name-text-wrapper" @click="jumpToUserInfo">
            {{this.friendInfo.name}}
          </div>
          <div class="fans-text-wrapper">
            {{this.friendInfo.fans_count}} 位粉丝
          </div>
        </el-col>
        <!--<el-col :span="7" class="button-col-wrapper">-->
        <!--<el-button class="button-wrapper">+ 关注</el-button>-->
        <!--</el-col>-->
      </el-row>
    </el-card>
  </div>
</template>

<script>
  import ElCard from '../../../node_modules/element-ui/packages/card/src/main.vue'
  import ElRow from 'element-ui/packages/row/src/row'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'
  import router from '../../router'

  export default {
    components: {
      ElButton,
      ElRow,
      ElCard
    },
    name: 'friendsBriefIntro',
    props: ['friendInfo'],
    data () {
      return {}
    },
    methods: {
      jumpToUserInfo () {
        router.push({name: 'userProfile', params: {userId: this.friendInfo.id}})
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
    width: 180px;
    text-align: left;
    font-size: 110%;
  }

  .friends-info-wrapper {
    margin-left: 3%;
    padding-left: 30px;
    margin-top: 4%;
  }

  .fans-text-wrapper {
    width: 180px;
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
