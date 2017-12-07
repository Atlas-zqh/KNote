<template>
  <div class="profile-header-bkg">
    <div class="user-info-wrapper">

      <div class="username-wrapper">
        <a @click="jumpToUser">
          {{this.userInfo[0].name}}
        </a>
        <div v-show="user!=null&&user.id!=userId">
          <el-button v-if="!followed" type="primary" class="follow-button-wrapper" @click="follow">+ 关注</el-button>
          <el-button v-else class="follow-button-wrapper" @click="unfollow">取消关注</el-button>
        </div>
      </div>

      <el-row :gutter="20">
        <el-col :span="5">
          <div class="user-pic-content">
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <a @click="jumpToNotebooks">
              <span class="num-font-wrapper">{{this.userInfo[0].notebooks_count}}</span>
            </a>
            <span class="type-font-wrapper">笔记本</span>
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <a @click="jumpToNotes">
              <span class="num-font-wrapper">{{this.userInfo[0].notes_count}}</span>
            </a>
            <span class="type-font-wrapper">笔记</span>
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <a @click="jumpToFans">
              <span class="num-font-wrapper">{{this.userInfo[0].follow_count}}</span>
            </a>
            <span class="type-font-wrapper">关注</span>
          </div>
        </el-col>
        <el-col :span="4">
          <div class="grid-content">
            <a @click="jumpToFans">
              <span class="num-font-wrapper">{{this.userInfo[0].fans_count}}</span>
            </a>
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
  import { mapState, mapActions } from 'vuex'
  import router from '../../router'

  export default {
    name: 'profileHeader',
    props: ['curUserId'],
    data () {
      return {
        userId: this.curUserId,
        followed: false
      }
    },
    created () {
//      console.log(this.userId)
      this.fetchUserInfo(this.userId)
    },
    computed: {
      ...mapState('user', {
        userInfo: state => state.info
      }),
      ...mapState('auth', {
        user: state => state.user
      })
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
      },
      jumpToUser () {
        router.push({name: 'userProfile', params: {userId: this.userId}})
      },
      jumpToNotebooks () {
        console.log(this.user.id)
        console.log(this.userId)
        router.push({name: 'notebooks', params: {userId: this.userId}})
      },
      jumpToNotes () {
        router.push({name: 'notes', params: {userId: this.userId}})
      },
      jumpToFans () {
        router.push({name: 'friends', params: {userId: this.userId}})
      },
      ...mapActions('user', [
        'fetchUserInfo'
      ])
    }
  }
</script>

<style scoped>
  .profile-header-bkg {
    background-image: linear-gradient(to bottom, rgba(246, 246, 246, 0.7) 0%, rgba(246, 246, 246, 0.7) 100%), url('../../assets/user-bkg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;

    width: 81%;
    min-width: 800px;
    height: 250px;
    margin-left: auto;
    margin-right: auto;
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
    margin-left: 220px;
    position: absolute;
    top: 50%;
    transform: translate(0, 50%);
  }

  a:link,
  a:visited {
    color: #000000;
    text-decoration: none;
  }

  a:hover,
  a:active {
    color: #000000;
    text-decoration: none;
  }
</style>
