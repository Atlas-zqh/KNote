<template>
  <!--<div style="width: 100%;text-align: center">-->
  <div class="profile-header-bkg">
    <div class="user-info-wrapper">
      <!--<div class="col-wrapper">-->

      <div class="username-wrapper">{{username}}
        <el-button v-if="!followed" type="primary" class="follow-button-wrapper" @click="follow">+ 关注</el-button>
        <el-button v-else class="follow-button-wrapper" @click="unfollow">取消关注</el-button>
      </div>

      <el-row :gutter="20">
        <el-col :span="5">
          <div class="user-pic-content">
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <span class="num-font-wrapper">{{notebooks}}</span>
            <span class="type-font-wrapper">笔记本</span>
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <span class="num-font-wrapper">{{notes}}</span>
            <span class="type-font-wrapper">笔记</span>
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <span class="num-font-wrapper">{{following}}</span>
            <span class="type-font-wrapper">关注</span>
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <span class="num-font-wrapper">{{followers}}</span>
            <span class="type-font-wrapper">粉丝</span>
          </div>
        </el-col>
      </el-row>
    </div>

  </div>
  <!--</div>-->
  <!--</div>-->
</template>

<script>
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    name: 'profileHeader',
    data () {
      return {
        followed: false,
        notebooks: 7,
        notes: 233,
        following: 250,
        followers: 1770,
        username: 'Keenan'
      }
    },
    components: {ElButton},
    methods: {
      follow () {
        this.followed = true
        this.followers += 1
      },
      unfollow () {
        this.followed = false
        this.followers -= 1
      }
    }
  }
</script>

<style scoped>
  .profile-header-bkg {
    /*text-align: center;*/
    /*background-color: #50bfff;*/
    background-image: linear-gradient(to bottom, rgba(246, 246, 246, 0.7) 0%, rgba(246, 246, 246, 0.7) 100%), url('../../assets/user-bkg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;

    width: 81%;
    min-width: 800px;
    height: 250px;
    margin-left: auto;
    margin-right: auto;
    /*position: relative;*/
    /*display: inline-block;*/
  }

  .user-info-wrapper {
    padding-top: 160px;
    text-align: center;
    width: 90%;
    position: relative;
    display: inline-block;
    padding-left: 5%;
    /*position:absolute;*/
  }

  .grid-content {
    /*position: relative;*/
    /*text-align: center;*/
    /*display: inline-block;*/
    /*border-radius: 4px;*/
    min-height: 20px;
    min-width: 70px;
  }

  .user-pic-content {
    margin-top: -65px;
    border-radius: 50%;
    background-image: url("../../assets/user-photo.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    height: 150px;
    width: 150px;
    box-shadow: #666666 2px 2px 2px;
  }

  .num-font-wrapper {
    font-family: "Hiragino Sans GB";
    font-size: 150%;
    font-weight: 100;
    color: black;
  }

  .type-font-wrapper {
    padding-left: 3px;
    font-family: "Hiragino Sans GB";
    font-size: 85%;
    color: black;
  }

  .username-wrapper {
    text-align: left;
    padding-left: 25%;
    font-family: "Hiragino Sans GB";
    font-size: xx-large;
    /*color: black;*/
  }

  .follow-button-wrapper {
    margin-left: 30px;
    position: absolute;
    top: 50%;
    transform: translate(0, 50%);
  }
</style>
