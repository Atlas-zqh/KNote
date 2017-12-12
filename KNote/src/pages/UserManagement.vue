<template>
  <div>
    <menu-bar></menu-bar>
    <div class="search-out-pane-wrapper">
      <div class="search-inner-wrapper">
        <el-input placeholder="输入用户名关键字搜索用户"
                  size="large"
                  style="width: 40%"
                  icon="search"
                  v-model="usernameKeyword"
                  :on-icon-click="searchUser"></el-input>
        <div style="font-size: 40px;font-weight: bold;margin-top: 30px">搜索结果</div>

        <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%">
          <admin-result-user-profile-card v-for="userBrief in adminResult" :userBrief="userBrief"></admin-result-user-profile-card>

        </el-row>

      </div>
    </div>
    <main-foot></main-foot>
  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import ElInput from '../../node_modules/element-ui/packages/input/src/input.vue'
  import ElRow from 'element-ui/packages/row/src/row'
  import AdminResultUserProfileCard from '../components/admin/AdminResultUserProfile.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import { mapActions, mapState } from 'vuex'

  export default {
    components: {
      MainFoot,
      AdminResultUserProfileCard,
      ElRow,
      ElInput,
      MenuBar
    },
    name: 'userManagement',
    data () {
      return {
        usernameKeyword: ''
      }
    },
    methods: {
      ...mapActions('admin', [
        'fetchAdminSearchResult'
      ]),
      searchUser () {
        if (this.usernameKeyword === '') {
          this.$message({
            message: '请输入搜索内容！',
            type: 'warning'
          })
        } else {
          this.fetchAdminSearchResult({
            keyword: this.usernameKeyword,
            onSuccess: () => {},
            onError: () => {}
          })
        }

      }
    },
    computed: {
      ...mapState('admin', {
        adminResult: state => state.adminSearchResult
      })
    }
  }
</script>

<style scoped>
  .search-out-pane-wrapper {
    margin-top: 20px;
    width: 81%;
    min-width: 800px;
    height: auto;
    min-height: 800px;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(238, 246, 242, 0.28);
  }

  .search-inner-wrapper {
    text-align: left;
    padding-top: 3%;
    padding-bottom: 3%;
    padding-left: 5%;
    margin-left: auto;
    margin-right: auto;
  }
</style>
