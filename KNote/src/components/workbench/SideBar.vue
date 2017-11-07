<template>
  <div class="menu-wrapper">
    <el-menu class="menu-vertical"
             :collapse="isCollapse">
      <div class="notebook-indicator">
        <div v-if="!isCollapse">
          <span>我的笔记本</span>
          <el-button type="text" size="mini" icon="arrow-left"
                     style="float: right; padding-top: 6px; padding-right: 5px" @click="handleOpen"></el-button>
        </div>
        <div v-else v-model="isCollapse">
          <span style="size: 5px">笔记本</span>
          <el-button type="text" size="mini" icon="arrow-right"
                     style="float: right; padding-top: 6px; padding-right: 0px" @click="handleOpen"></el-button>
        </div>
      </div>

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

  </div>
</template>

<script>
  import {
    RadioGroup,
    RadioButton,
    Menu,
    Submenu,
    MenuItemGroup,
    MenuItem,
    Breadcrumb,
    BreadcrumbItem
  } from 'element-ui'
  import { mapMutations } from 'vuex'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    name: 'sideBar',
    components: {
      ElButton,
      elRadioGroup: RadioGroup,
      elRadioButton: RadioButton,
      elMenu: Menu,
      elSubmenu: Submenu,
      elMenuItemGroup: MenuItemGroup,
      elMenuItem: MenuItem,
      elBreadcrumb: Breadcrumb,
      elBreadcrumbItem: BreadcrumbItem
    },
    data () {
      return {
        isCollapse: false
      }
    },
    computed: {},
    methods: {
      ...mapMutations([
        'changeCollapse'
      ]),
      handleOpen () {
        this.isCollapse = !this.isCollapse
        this.changeCollapse()
      }
    }
  }
</script>

<style scoped>

  .menu-wrapper {
    /*display: inline-block;*/
    width: auto;
    height: auto;
  }

  .menu-vertical:not(.el-menu--collapse) {
    width: 16%;
    min-height: 400px;
    height: 94%;
    position: fixed;
    top: 60px;
    overflow: scroll;
    background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

  .el-menu--collapse {
    /*text-align: center;*/
    min-height: 400px;
    height: 94%;
    width: 8%;
    position: fixed;
    top: 60px;
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
    z-index: 1;
  }

  .el-submenu /deep/ .el-menu {
    background-color: #f6f6f6;
  }

  .notebook-indicator {
    padding: 8px 15px;
  }

</style>
