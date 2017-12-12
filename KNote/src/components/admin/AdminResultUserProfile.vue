<template>
  <div>
    <el-col :span="4" style="padding-top:20px;padding-bottom: 200px">
      <div style="width: 100%;margin-left: 5%;height: 20px;">
        <el-card class="box-card" :body-style="{ padding: '0px' }">
          <img src="../../assets/user-photo.jpg" class="image">
          <div class="name-wrapper">
            <i v-show="userBrief.is_valid==false" class="el-icon-warning" style="color: red"></i>
            {{this.userBrief.name}}
          </div>
          <div style="text-align: center;margin-bottom: 5%">
            <el-button type="text" size="mini" @click="blockThisUser" v-show="userBrief.is_valid==true">封号</el-button>
            <el-button type="text" size="mini" @click="unblockThisUser" v-show="userBrief.is_valid==false">解封</el-button>
            <el-button type="text" size="mini" @click="resetPassword">重置密码</el-button>
          </div>
        </el-card>
      </div>
    </el-col>
  </div>
</template>

<script>
  import ElCard from '../../../node_modules/element-ui/packages/card/src/main.vue'
  import ElCol from 'element-ui/packages/col/src/col'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'
  import { mapActions, mapState } from 'vuex'

  export default {
    components: {
      ElButton,
      ElCol,
      ElCard
    },
    name: 'adminResultUserProfileCard',
    props: ['userBrief'],
    computed: {
      ...mapState('admin', {
        searchKeyword: state => state.adminSearchKeyword
      })
    },
    methods: {
      ...mapActions('admin', [
        'doBlockUser', 'doResetPass', 'doUnblockUser'
      ]),
      blockThisUser () {
        this.$confirm('此操作将导致用户账户无法登录，但不会删除该用户已有信息，是否继续？', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.doBlockUser({
            userId: this.userBrief.id,
            keyword: this.searchKeyword,
            onSuccess: () => {
              this.$message({
                type: 'success',
                message: '已封禁账户: ' + this.userBrief.name
              })
            },
            onError: () => {
              this.$message.error('出错了，请稍后重试')
            }
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消封禁账户'
          })
        })
      },
      unblockThisUser () {
        this.$confirm('此操作将恢复被封禁用户的所有功能，是否继续？', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.doUnblockUser({
            userId: this.userBrief.id,
            keyword: this.searchKeyword,
            onSuccess: () => {
              this.$message({
                type: 'success',
                message: '已解封账户: ' + this.userBrief.name
              })
            },
            onError: () => {
              this.$message.error('出错了，请稍后重试')
            }
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消解封账户'
          })
        })
      },
      resetPassword () {
        this.$confirm('此操作将重置用户密码为"123456a"，是否继续？', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.doResetPass({
            userId: this.userBrief.id,
            onSuccess: () => {
              this.$message({
                type: 'success',
                message: '已为账户: ' + this.userBrief.name + ' 重置密码'
              })
            },
            onError: () => {
              this.$message.error('出错了，请稍后重试')
            }
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消重置密码'
          })
        })
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
