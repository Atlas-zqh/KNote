<template>
  <div>
    <el-menu :default-active="1" class="el-menu-demo" mode="horizontal" @select="handleSelect">
      <div class="nav-wrapper">
        <div class="logo-wrapper">
          <img src="../../assets/logo_with_word.png" width="100px"/>
        </div>
        <el-menu-item index="3" @click="sign_in">登录</el-menu-item>

        <el-submenu index="2">
          <template slot="title">我的工作台</template>
          <el-menu-item index="2-1">创建新笔记</el-menu-item>
          <el-menu-item index="2-2">我的笔记</el-menu-item>
          <el-menu-item index="2-3">我的笔记本</el-menu-item>
          <el-menu-item index="2-4">我的标签</el-menu-item>
        </el-submenu>
        <el-menu-item index="1">首页</el-menu-item>
      </div>
    </el-menu>

    <sign-in-pane></sign-in-pane>
  </div>

</template>

<script>
  import { Menu, MenuItem, Submenu } from 'element-ui'
  import VueJsModal from '../../../node_modules/vue-js-modal/src/Modal.vue'
  import SignInPane from '../signIn/SignInPane.vue'

  export default {
    name: 'menuBar',
    components: {
      VueJsModal,
      elMenu: Menu,
      elMenuItem: MenuItem,
      elSubmenu: Submenu,
      SignInPane
    },
    methods: {
      handleSelect (key, keyPath) {
        console.log(key, keyPath)
      },
      sign_in () {
        this.$modal.show('sign-in')
      }
    }
  }
</script>

<style scoped>
  .el-menu {
    border-radius: 0px;
    /*background-color: rgba(238, 241, 246, 0.58);*/
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
    /*background-image: linear-gradient(to top, #d5d4d0 0%, #d5d4d0 1%, #eeeeec 31%, #efeeec 75%, #e9e9e7 100%);*/
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
</style>
