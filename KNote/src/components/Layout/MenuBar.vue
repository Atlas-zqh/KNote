<template>
  <div>
    <el-menu default-active=1               class="el-menu-demo" mode="horizontal">
      <div class="nav-wrapper">
        <div class="logo-wrapper" @click="jumpToIndex">
          <img src="../../assets/logo_with_word.png" width="100px"/>
        </div>
        <div class="search-bar-wrapper" v-show="user==null||(user!=null&&user.permission=='normal')">
          <el-input placeholder="输入搜索内容" icon="search" v-model="search_input"
                    :on-icon-click="showSearchResult"></el-input>
        </div>
        <el-menu-item v-if="user==null" index="3" @click="sign_in">登录</el-menu-item>
        <el-submenu v-else index="4" v-show="user.permission!=='admin'">
          <template slot="title">我的</template>
          <el-menu-item index="4-1" @click="jumpToMyPage">个人主页</el-menu-item>
          <el-menu-item index="4-2" @click="goSignOut">退出登录</el-menu-item>
        </el-submenu>

        <el-submenu v-show="user!=null&&user.permission=='admin'" index="5">
          <template slot="title">管理员</template>
          <el-menu-item index="5-1" @click="goUserManagement">用户管理</el-menu-item>
          <el-menu-item index="5-2" @click="goSignOut">退出登录</el-menu-item>
        </el-submenu>

        <el-submenu index="2" v-show="user==null||(user!=null&&user.permission=='normal')">
          <template slot="title">我的工作台</template>
          <el-menu-item index="2-1" @click="jumpToWorkbench">进入工作台</el-menu-item>
          <el-menu-item index="2-2" @click="showChooseNotebook">创建新笔记</el-menu-item>
          <el-menu-item index="2-3" @click="jumpToMyNotes">我的笔记</el-menu-item>
          <el-menu-item index="2-4" @click="jumpToMyNotebooks">我的笔记本</el-menu-item>
        </el-submenu>
        <el-menu-item index="1" @click="jumpToIndex">首页</el-menu-item>
      </div>
    </el-menu>

    <div>
      <el-dialog class="dialog" title="选择笔记本" :visible.sync="show_chooseNoteBook" width="30%">
        <div>
          <template>
            <el-select class="select" v-model="value" filterable placeholder="请选择">
              <el-option
                v-for="item in list"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </template>
        </div>

        <div slot="footer" style="text-align: center;">
          <el-button type="primary" @click="createNewNote">确 定</el-button>
          <el-button @click="show_chooseNoteBook = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
    <sign-in-pane></sign-in-pane>
  </div>
</template>

<script>
  import { Menu, MenuItem, Submenu, Input, Select, Option, Button } from 'element-ui'
  import VueJsModal from '../../../node_modules/vue-js-modal/src/Modal.vue'
  import SignInPane from '../signIn/SignInPane.vue'
  import router from '../../router'
  import ElDialog from '../../../node_modules/element-ui/packages/dialog/src/component.vue'
  import { mapState, mapActions } from 'vuex'

  export default {
    name: 'menuBar',
    components: {
      ElDialog,
      VueJsModal,
      elMenu: Menu,
      elMenuItem: MenuItem,
      elSubmenu: Submenu,
      elInput: Input,
      elSelect: Select,
      elOption: Option,
      elButton: Button,
      SignInPane
    },
    computed: {
      ...mapState('auth', {
        user: state => state.user
      }),
      ...mapState('notebook', {
        myNotebooks: state => state.myNotebooks
      }),
      title: function () {
        let date = new Date()
        let time = date.getFullYear() + '年' + (date.getMonth() + 1) + '月' + date.getDate() + '日' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
        return {
          title: time + '的笔记'
        }
      }
    },
    data () {
      return {
        search_input: '',
        show_chooseNoteBook: false,
        value: [],
        list: [],
        loading: false
      }
    },
    created () {
      this.refreshUser({
        onSuccess: () => {}
      })
    },
    methods: {
      ...mapActions('auth', [
        'refreshUser', 'signOut'
      ]),
      ...mapActions('notebook', [
        'fetchMyNotebooks'
      ]),
      ...mapActions('user', [
        'fetchUserInfo'
      ]),
      ...mapActions('note', [
        'createNote'
      ]),
      ...mapActions('search', [
        'fetchSearchResult'
      ]),
      sign_in () {
        this.$modal.show('sign-in')
      },
      showChooseNotebook () {
        if (this.user === null || this.user === undefined) {
          this.$modal.show('sign-in')
        } else {
          this.show_chooseNoteBook = true
          this.fetchMyNotebooks({
            userId: this.user.id,
            onSuccess: () => {
              this.list = this.myNotebooks.map(item => {
                return {value: item.id, label: item.notebook_name}
              })
            },
            onError: (msg) => this.$message.error(msg)
          })
        }
      },
      jumpToIndex () {
        router.push('/')
      },
      jumpToMyNotebooks () {
        if (this.user === null || this.user === undefined) {
          this.$modal.show('sign-in')
        } else {
          router.push({name: 'notebooks', params: {userId: this.user.id}})
        }
      },
      jumpToWorkbench () {
        if (this.user === null || this.user === undefined) {
          this.$modal.show('sign-in')
        } else {
          router.push({name: 'workbench', params: {userId: this.user.id}})
        }
      },
      jumpToMyNotes () {
        if (this.user === null || this.user === undefined) {
          this.$modal.show('sign-in')
        } else {
          router.push({name: 'notes', params: {userId: this.user.id}})
        }
      },
      jumpToMyPage () {
        this.fetchUserInfo(this.user.id)
        router.push({name: 'userProfile', params: {userId: this.user.id}})
      },
      goSignOut () {
        this.signOut({
          onSuccess: (username) => {
            this.$message({
              message: 'Bye, ' + username + '!',
              type: 'success'
            })
            router.push('/')
          }
        })
      },
      createNewNote () {
        this.createNote({
          noteInfo: {
            userId: this.user.id,
            notebookId: this.value,
            noteTitle: this.title.title,
            noteContent: '',
            permission: 'public'
          },
          onSuccess: () => {
            this.show_chooseNoteBook = false
            router.push({name: 'workbench', params: {userId: this.user.id}})
          },
          onError: () => {
            this.$message.error('创建失败')
          }
        })
      },
      showSearchResult () {
        if (this.user === null || this.user === undefined) {
          this.$modal.show('sign-in')
        } else {
          this.fetchSearchResult({
            userId: this.user.id,
            keyword: this.search_input,
            onSuccess: () => {
              router.push({name: 'searchResultPage'})
            },
            onError: () => {
              this.$message.error('出错了！请稍后重试！')
            }
          })
        }
      },
      goUserManagement () {
        router.push({name: 'userManagement'})
      }
    }
  }
</script>

<style scoped>
  .el-menu {
    border-radius: 0px;
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

  /*.el-select .el-select-dropdown{*/
  /*z-index: 2002;*/
  /*}*/

  .nav-wrapper {
    width: 960px;
    margin: 0 auto;
  }

  .logo-wrapper {
    float: left;
    display: inline-block;
    padding-top: 12px;
  }

  .el-menu /deep/ .el-menu-item {
    float: right;
  }

  .el-menu /deep/ .el-submenu {
    float: right;
  }

  .search-bar-wrapper {
    display: inline-block;
    padding-top: 12px;
    padding-left: 340px;
  }

  .el-input-group__append div.el-select .el-input__inner, /deep/
  .el-input-group__append div.el-select:hover .el-input__inner, /deep/
  .el-input-group__prepend div.el-select .el-input__inner, /deep/
  .el-input-group__prepend div.el-select:hover /deep/ .el-input__inner {
    font-size: 13px;
    width: 101px;
    color: rgb(72, 106, 87);
  }

  .el-input-group__append, /deep/ .el-input-group__prepend {
    color: rgb(83, 113, 96);
  }

  .dialog {
    z-index: 2000 !important;
  }

  .el-select-dropdown__item {
    font-family: sans-serif;
  }

</style>
