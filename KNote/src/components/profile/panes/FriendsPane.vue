<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <el-row :gutter="80">
        <el-col :span="12">
          <div class="notify-wrapper">
            <i class="el-icon-ali-my"></i>
            关注的人
          </div>
          <div v-show="this.following.length==0" class="text item">暂无关注的人</div>
          <friends-brief-intro
            v-for="each_following in this.following"
            :friendInfo="each_following"
            class="friends-brief-info-wrapper">
          </friends-brief-intro>
        </el-col>
        <el-col :span="12">
          <div class="notify-wrapper">
            <i class="el-icon-ali-my"></i>
            粉丝
          </div>
          <div v-show="this.followers.length==0" class="text item">暂无关注的人</div>
          <friends-brief-intro
            v-for="follower in this.followers"
            :friendInfo="follower"
            class="friends-brief-info-wrapper">
          </friends-brief-intro>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
  import FriendsBriefIntro from '../FriendsBriefIntro.vue'
  import { mapState, mapActions } from 'vuex'

  export default {
    components: {FriendsBriefIntro},
    name: 'friendsPane',
    data () {
      return {
        userId: this.$route.params.userId
      }
    },
    created () {
      this.fetchFollowers(this.userId)
      this.fetchFollowing(this.userId)
    },
    computed: {
      ...mapState('user', {
        followers: state => state.followers,
        following: state => state.following
      })
    },
    methods: {
      ...mapActions('user', [
        'fetchFollowers',
        'fetchFollowing'
      ])
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";
  @import "../../../assets/icon/iconfont.css";

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

  .friends-brief-info-wrapper {
    margin-bottom: 20px;
  }

  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
    margin-left: 15%;
    float: left;
  }
</style>
