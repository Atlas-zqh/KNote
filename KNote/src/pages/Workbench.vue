<template>
  <div>
    <menu-bar></menu-bar>
    <div class="workbench-out">
      <side-bar></side-bar>
    </div>
    <div :class="editorWrapper">
      <tag-area class="tag-wrapper"></tag-area>
      <title-editor class="title-wrapper"></title-editor>
      <vue-editor v-model="editor_content"></vue-editor>
    </div>
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

  export default {
    name: 'workbench',
    components: {
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
      }
    },

    data () {
      return {
        editor_content: '<h1>Hello!</h1>'
      }
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


