<template>
  <div>
    <el-menu default-active=1     class="el-menu-demo" mode="horizontal"
             @select="handleSelect">
      <div class="nav-wrapper">
        <div class="logo-wrapper" @click="jumpToIndex">
          <img src="../../assets/logo_with_word.png" width="100px"/>
        </div>
        <div class="search-bar-wrapper">
          <el-input placeholder="搜索内容" v-model="search_input">
            <el-select v-model="select" slot="prepend" placeholder="搜索范围">
              <el-option label="全部笔记" value="1"></el-option>
              <el-option label="当前笔记" value="2"></el-option>
              <el-option label="笔记本" value="3"></el-option>
              <el-option label="标签" value="4"></el-option>
            </el-select>
            <el-button slot="append" icon="search"></el-button>
          </el-input>
        </div>
        <el-menu-item v-if="this.user==null" index="3" @click="sign_in">登录</el-menu-item>
        <el-submenu v-else index="4">
          <template slot="title">我的</template>
          <el-menu-item index="4-1" @click="jumpToMyPage">个人主页</el-menu-item>
          <el-menu-item index="4-2" @click="goSignOut">退出登录</el-menu-item>
        </el-submenu>


        <el-submenu index="2">
          <template slot="title">我的工作台</template>
          <el-menu-item index="2-1" @click="jumpToWorkbench">进入工作台</el-menu-item>
          <el-menu-item index="2-2" @click="showChooseNotebook">创建新笔记</el-menu-item>
          <el-menu-item index="2-3" @click="jumpToMyNotes">我的笔记</el-menu-item>
          <el-menu-item index="2-4" @click="jumpToMyNotebooks">我的笔记本</el-menu-item>
          <!--<el-menu-item index="2-5">我的标签</el-menu-item>-->
        </el-submenu>
        <el-menu-item index="1" @click="jumpToIndex">首页</el-menu-item>
      </div>
    </el-menu>

    <div>
      <el-dialog class="dialog" title="选择笔记本" :visible.sync="show_chooseNoteBook" width="30%">
        <div>
          <template>
            <el-select class="select" v-model="value" filterable remote placeholder="请选择" :remote-method="remoteMethod"
                       :loading="loading">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </template>
        </div>

        <div slot="footer" style="text-align: center;">
          <el-button type="primary" @click="show_chooseNoteBook = false">确 定</el-button>
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
      })
    },
    data () {
      return {
        search_input: '',
        select: '',
        show_chooseNoteBook: false,
        options: [],
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
    mounted () {
      this.fetchMyNotebooks({
        userId: this.user.id,
        onSuccess: () => {},
        onError: (msg) => this.$message.error(msg)
      })
      this.list = this.myNotebooks.map(item => {
        return {value: item.id, label: item.notebook_name}
      })
    },
    methods: {
      handleSelect (key, keyPath) {
        console.log(key, keyPath)
      },
      sign_in () {
        this.$modal.show('sign-in')
      },
      showChooseNotebook () {
        if (this.user == null) {
          this.$modal.show('sign-in')
        } else {
          this.show_chooseNoteBook = true
        }
      },
      jumpToIndex () {
        router.push('/')
      },
      jumpToMyNotebooks () {
        if (this.user == null) {
          this.$modal.show('sign-in')
        } else {
          router.push({name: 'notebooks', params: {userId: this.user.id}})
        }
      },
      jumpToWorkbench () {
        if (this.user == null) {
          this.$modal.show('sign-in')
        } else {
          router.push({name: 'workbench', params: {userId: this.user.id}})
        }
      },
      jumpToMyNotes () {
        if (this.user == null) {
          this.$modal.show('sign-in')
        } else {
          router.push({name: 'notes', params: {userId: this.user.id}})
        }
      },
      jumpToMyPage () {
        console.log('bbb' + this.user.id)
        this.fetchUserInfo(this.user.id)
        router.push({name: 'userProfile', params: {userId: this.user.id}})
      },
      remoteMethod (query) {
        console.log(this.list)
        if (query !== '') {
          this.loading = true
          setTimeout(() => {
            this.loading = false
            this.options = this.list.filter(item => {
              return item.label.toLowerCase()
                .indexOf(query.toLowerCase()) > -1
            })
          }, 200)
        } else {
          this.options = []
        }
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
      ...mapActions('auth', [
        'refreshUser', 'signOut'
      ]),
      ...mapActions('notebook', [
        'fetchMyNotebooks'
      ]),
      ...mapActions('user', [
        'fetchUserInfo'
      ])
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
    padding-left: 248px;
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
