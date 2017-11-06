<template>
  <div class="menu-wrapper">
    <el-radio-group v-model="isCollapse" style="margin-bottom: 20px;">
      <el-radio-button :label="false">展开</el-radio-button>
      <el-radio-button :label="true">收起</el-radio-button>
    </el-radio-group>


    <el-menu class="menu-vertical" @open="handleOpen" @close="handleClose"
             :collapse="isCollapse">

      <el-submenu index="1">
        <template slot="title">
          <i class="el-icon-message"></i>
          <span slot="title">导航一</span>
        </template>
        <el-menu-item index="1-1">选项1</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-2">选项2</el-menu-item>
        <el-menu-item index="1-3">选项3</el-menu-item>
        <el-submenu index="1-4">
          <span slot="title">选项4</span>
          <el-menu-item index="1-4-1">选项1</el-menu-item>
        </el-submenu>
      </el-submenu>

      <el-menu-item index="2">
        <i class="el-icon-menu"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      <el-menu-item index="3">
        <i class="el-icon-setting"></i>
        <span slot="title">导航三</span>
      </el-menu-item>
    </el-menu>

    <div :class="workbenchWrapper">


    </div>
  </div>
</template>

<script>
  import { RadioGroup, RadioButton, Menu, SubMenu, MenuItemGroup, MenuItem } from 'element-ui'

  export default {
    name: 'sideBar',
    components: {
      elRadioGroup: RadioGroup,
      elRadioButton: RadioButton,
      elMenu: Menu,
      elSubMenu: SubMenu,
      elMenuItemGroup: MenuItemGroup,
      elMenuItem: MenuItem
    },
    data () {
      return {
        isCollapse: false,
        small_collapse: true
      }
    },
    computed: {
      workbenchWrapper: function () {
        return {
          'workbench-wrapper-no-collapse': !this.isCollapse,
          'workbench-wrapper-collapse': this.isCollapse
        }
      }
    },
    methods: {
      handleOpen (key, keyPath) {
        console.log(key, keyPath)
      },
      handleClose (key, keyPath) {
        console.log(key, keyPath)
      }
    }
  }
</script>

<style>

  .menu-wrapper {
    /*display: inline-block;*/
    width: auto;
    height: auto;
  }

  .menu-vertical:not(.el-menu--collapse) {
    width: 20%;
    min-height: 400px;
    height: 80%;
    position: fixed;
    top: 116px;
    overflow: scroll;
    background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

  .el-menu--collapse {
    text-align: center;
    min-height: 400px;
    height: 80%;
    width: 6%;
    position: fixed;
    top: 116px;
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

  .el-submenu /deep/ .el-menu {
    background-color: #f6f6f6;
  }

  .workbench-wrapper-no-collapse {
    display: inline-block;
    margin-left: 240px;
    width: 80%;
    height: 500px;
    background-color: red;
  }

  .workbench-wrapper-collapse {
    display: inline-block;
    margin-left: 6%;
    width: 94%;
    height: 500px;
    background-color: red;
  }

</style>
