<template>
  <div class="menu-wrapper">
    <el-menu class="menu-vertical"
             :collapse="isCollapse"
             :default-openeds="selectedNotebook"
    >
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

      <el-submenu v-for="notebook in this.notebookInfo" :index="notebook.id">
        <template slot="title">
          <i class="el-icon-document"></i>
          <span slot="title">{{notebook.notebook_name}}</span>
        </template>
        <el-menu-item v-for="note in notebook.notes" :index="note.id" @click="handleChosen(note.id)">
          <div style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">
            {{note.title}}
          </div>
        </el-menu-item>
      </el-submenu>
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
  import { mapMutations, mapActions, mapState } from 'vuex'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'
  import router from '../../router'

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
        isCollapse: false,
        userId: this.$route.params.userId
      }
    },

    computed: {
      ...mapState('notebook', {
        notebookInfo: state => state.allNotebooks
      }),
      ...mapState('note', {
        workbenchNote: state => state.workbenchNote
      }),
      selectedNotebook: function () {
        let notebookId = this.workbenchNote === null ? '' : this.workbenchNote.notebook[0].id
        return [notebookId]
      }
    },
    created () {
      console.log(this.workbenchNote)
      this.fetchNotebooksAndNotes({
        userId: this.userId,
        onSuccess: (data) => {},
        onError: (msg) => {
          this.$message.error(msg)
          router.push('/')
        }
      })
    },
    methods: {
      ...mapMutations([
        'changeCollapse'
      ]),
      ...mapActions('notebook', [
        'fetchNotebooksAndNotes'
      ]),
      ...mapActions('note', [
        'fetchWorkbenchNoteDetail'
      ]),
      handleOpen () {
        console.log(this.selectedNotebook)

        this.isCollapse = !this.isCollapse
        this.changeCollapse()
      },
      handleChosen (index) {
        console.log(index)
        this.fetchWorkbenchNoteDetail({
          noteId: index,
          onSuccess: (detail) => {},
          onError: (msg) => {
            this.$message.error(msg)
          }
        })
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
    /*overflow: scroll;*/
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
    z-index: 1;
  }

  .el-submenu /deep/ .el-menu {
    background-color: #f6f6f6;
    /*overflow: scroll;*/
  }

  .notebook-indicator {
    padding: 8px 15px;
  }

</style>
