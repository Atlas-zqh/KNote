<template>
  <div>
    <el-menu :default-active="1" class="el-menu-demo" mode="horizontal" @select="handleSelect">
      <div class="nav-wrapper">
        <div class="logo-wrapper">
          <img src="../../assets/logo_with_word.png" width="100px"/>
        </div>
        <div class="search-bar-wrapper">
          <el-input placeholder="搜索内容" v-model="search_input">
            <el-select v-model="select" slot="prepend" placeholder="搜素范围">
              <el-option label="全部笔记" value="1"></el-option>
              <el-option label="当前笔记" value="2"></el-option>
              <el-option label="笔记本" value="3"></el-option>
              <el-option label="标签" value="4"></el-option>
            </el-select>
            <el-button slot="append" icon="search"></el-button>
          </el-input>
        </div>
        <el-menu-item index="3" @click="sign_in">登录</el-menu-item>
        <el-submenu index="2">
          <template slot="title">我的工作台</template>
          <el-menu-item index="2-1" @click="create_quick_note">Quick Note</el-menu-item>
          <el-menu-item index="2-2">创建新笔记</el-menu-item>
          <el-menu-item index="2-3">我的笔记</el-menu-item>
          <el-menu-item index="2-4">我的笔记本</el-menu-item>
          <el-menu-item index="2-5">我的标签</el-menu-item>
        </el-submenu>
        <el-menu-item index="1" @click="jumpToIndex">首页</el-menu-item>
      </div>
    </el-menu>

    <sign-in-pane></sign-in-pane>
    <quick-note></quick-note>
  </div>

</template>

<script>
  import { Menu, MenuItem, Submenu, Input, Select, Option, Button } from 'element-ui'
  import VueJsModal from '../../../node_modules/vue-js-modal/src/Modal.vue'
  import SignInPane from '../signIn/SignInPane.vue'
  import QuickNote from '../workbench/QuickNote.vue'
  import router from '../../router'

  export default {
    name: 'menuBar',
    components: {
      VueJsModal,
      elMenu: Menu,
      elMenuItem: MenuItem,
      elSubmenu: Submenu,
      elInput: Input,
      elSelect: Select,
      elOption: Option,
      elButton: Button,
      SignInPane,
      QuickNote
    },
    data () {
      return {
        search_input: '',
        select: ''
      }
    },
    methods: {
      handleSelect (key, keyPath) {
        console.log(key, keyPath)
      },
      sign_in () {
        this.$modal.show('sign-in')
      },
      create_quick_note () {
        this.$modal.show('quick-note')
      },
      jumpToIndex () {
        router.push('/')
      }
    }
  }
</script>

<style scoped>
  .el-menu {
    border-radius: 0px;
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

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


</style>
