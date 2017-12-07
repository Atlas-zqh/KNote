<template>
  <div>
    <menu-bar></menu-bar>
    <div class="workbench-out">
      <side-bar></side-bar>
    </div>
    <div :class="editorWrapper">
      <tag-area class="tag-wrapper"></tag-area>
      <title-editor class="title-wrapper"
                    v-model="title.title"></title-editor>
      <vue-editor v-model="content.content"></vue-editor>
    </div>
    <!--<el-button @click="showMessage">哈哈哈</el-button>-->
  </div>
</template>

<script>
  import sideBar from '../components/workbench/SideBar.vue'
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import VueEditor from '../components/workbench/VueEditor.vue'
  import TagArea from '../components/workbench/TagArea.vue'
  import TitleEditor from '../components/workbench/TitleEditor.vue'
  import { store } from '../main'
  import { mapState, mapActions } from 'vuex'
  //  import ElButton from '../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    name: 'workbench',
    components: {
//      ElButton,
      sideBar: sideBar,
      MenuBar,
      MainFoot,
      VueEditor,
      TagArea,
      TitleEditor
    },

    computed: {
      editorWrapper: function () {
        return {
          'workbench-wrapper-no-collapse': store.getters.isCollapsed,
          'workbench-wrapper-collapse': !store.getters.isCollapsed
        }
      },
      ...mapState('note', {
        workbenchNote: state => state.workbenchNote
      }),
      content: function () {
        return {
          content: this.workbenchNote === null ? '<h1>Helloooooo!</h1>' : this.workbenchNote.note.content
        }
      },
      title: function () {
        var date = new Date()
        var time = date.getFullYear() + '年' + (date.getMonth() + 1) + '月' + date.getDate() + '日' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
        return {
          title: this.workbenchNote === null ? time + '的笔记' : this.workbenchNote.note.title
        }
      }
    },
    methods: {
      ...mapActions('note', [
        'setWorkbenchNoteNull'
      ])
    },
    beforeDestroy (to, from, next) {
      this.setWorkbenchNoteNull()
    },
    data () {
      return {}
    }
  }
</script>

<style scoped>
  .workbench-out {
    text-align: left;
  }

  .workbench-wrapper-no-collapse {
    padding-top: 5px;
    display: inline-block;
    margin-left: 16%;
    width: 82.8%;
    height: 835px;
  }

  .workbench-wrapper-collapse {
    padding-top: 5px;
    display: inline-block;
    margin-left: 7.8%;
    width: 91%;
    height: 835px;
  }

  /*#quill-container {*/
  /*height: 700px;*/
  /*}*/

  .tag-wrapper {
    text-align: left;
  }

  .title-wrapper {
    text-align: left;
  }

  /deep/ .ql-toolbar /deep/ .ql-snow + /deep/ .ql-container /deep/ .ql-snow {
    height: 700px;
  }

</style>


