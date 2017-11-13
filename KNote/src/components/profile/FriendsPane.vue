<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <el-row :gutter="80">
        <el-col :span="12">
          <div class="notify-wrapper">
            <i class="el-icon-ali-my"></i>
            关注的人
          </div>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
        </el-col>
        <el-col :span="12">
          <div class="notify-wrapper">
            <i class="el-icon-ali-my"></i>
            粉丝
          </div>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
          <friends-brief-intro class="friends-brief-info-wrapper"></friends-brief-intro>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
  import FriendsBriefIntro from './FriendsBriefIntro.vue'

  export default {
    components: {FriendsBriefIntro},
    name: 'friendsPane'
  }
</script>

<style scoped>
  @import "../style/ProfilePaneOutWrapper.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: 8.7%;
    margin-right: 8.7%;
  }

  .notify-wrapper {
    color: darkgreen;
    text-align: left;
    margin-bottom: 3%;
  }

  .friends-brief-info-wrapper{
    margin-bottom: 20px;
  }
</style>
