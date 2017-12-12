<template>
  <div>
    <menu-bar></menu-bar>
    <div class="workbench-out">
      <side-bar></side-bar>
    </div>
    <div v-show="workbenchNote !== null" :class="editorWrapper">
      <tag-area class="tag-wrapper"></tag-area>
      <title-editor class="title-wrapper"
                    v-model="title.title">
      </title-editor>
      <div class="refresh-button-div-wrapper">
        <el-button type="text" size="large" class="refresh-button-wrapper" @click="rotateButton">
          <i class="el-icon-ali-sync" id="savingButton"></i>
        </el-button>
      </div>
      <vue-editor v-model="content.content"></vue-editor>
    </div>

    <div v-show="workbenchNote===null" :class="workbenchBkgWrapper">

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
  import { mapState, mapActions } from 'vuex'
  import ElButton from '../../node_modules/element-ui/packages/button/src/button.vue'
  //  import ElButton from '../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
    name: 'workbench',
    components: {
      ElButton,
      sideBar: sideBar,
      MenuBar,
      MainFoot,
      VueEditor,
      TagArea,
      TitleEditor
    },
    computed: {
      ...mapState('note', {
        workbenchNote: state => state.workbenchNote
      }),
      editorWrapper: function () {
        return {
          'workbench-wrapper-no-collapse': store.getters.isCollapsed,
          'workbench-wrapper-collapse': !store.getters.isCollapsed
        }
      },
      workbenchBkgWrapper: function () {
        return {
          'workbench-bkg-wrapper-no-collapse': store.getters.isCollapsed,
          'workbench-bkg-wrapper-collapse': !store.getters.isCollapsed
        }
      },
      content: function () {
        return {
          content: this.workbenchNote === null ? '<h1>Helloooooo!</h1>' : this.workbenchNote.note.content
        }
      },
      title: function () {
        let date = new Date()
        let time = date.getFullYear() + '年' + (date.getMonth() + 1) + '月' + date.getDate() + '日' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
        return {
          title: this.workbenchNote === null ? time + '的笔记' : this.workbenchNote.note.title
        }
      }
    },
    methods: {
      ...mapActions('note', [
        'setWorkbenchNoteNull', 'editNoteContent'
      ]),
      rotateButton () {
        this.autoSaving = true
        this.autoSaveContent()
      },
      stopRotate () {
        this.autoSaving = false
        clearInterval(this.rotateIntervalId)
      },
      autoSaveContent () {
        if (this.workbenchNote !== null) {
          this.autoSaving = true
          this.editNoteContent({
            noteContent: {
              noteId: this.workbenchNote.note.id,
              noteTitle: this.title.title,
              noteContent: this.content.content
            },
            onSuccess: () => {
              setTimeout(this.stopRotate, 3000)
            },
            onError: () => {
              this.autoSaving = false
              clearInterval(this.rotateIntervalId)
              this.$message.error('保存失败')
            }
          })
        }
      }
    },
    mounted: function () {
      this.intervalId = setInterval(this.autoSaveContent, 30000)
    },
    beforeDestroy (to, from, next) {
      this.setWorkbenchNoteNull()
      clearInterval(this.intervalId)
    },
    data () {
      return {
        intervalId: 0,
        autoSaving: false,
        rotateIntervalId: 0
      }
    },
    watch: {
      autoSaving: function () {
        if (this.autoSaving === true) {
          let element = document.getElementById('savingButton')
          let r = 0

          function rotate () {
            r += 1
            element.style.MozTransform = 'rotate(' + r + 'deg)'
            element.style.webkitTransform = 'rotate(' + r + 'deg)'
            element.style.msTransform = 'rotate(' + r + 'deg)'
            element.style.OTransform = 'rotate(' + r + 'deg)'
            element.style.transform = 'rotate(' + r + 'deg)'
          }

          this.rotateIntervalId = setInterval(rotate, 5)
        }
      }
    }
  }
</script>

<style scoped>
  @import "../assets/icon/iconfont.css";

  .workbench-out {
    text-align: left;
  }

  .workbench-wrapper-no-collapse {
    padding-top: 5px;
    display: inline-block;
    margin-left: 16%;
    width: 82.8%;
    height: 835px;
    text-align: left;
  }

  .workbench-wrapper-collapse {
    padding-top: 5px;
    display: inline-block;
    margin-left: 7.8%;
    width: 91%;
    height: 835px;
    text-align: left;
  }

  /*#quill-container {*/
  /*height: 700px;*/
  /*}*/

  .tag-wrapper {
    text-align: left;
  }

  .title-wrapper {
    text-align: left;
    /*margin-right: 5%;*/
    display: inline-block;
    width: 90%;
  }

  /deep/ .ql-toolbar /deep/ .ql-snow + /deep/ .ql-container /deep/ .ql-snow {
    height: 700px;
  }

  .refresh-button-div-wrapper {
    float: right;
    height: 60px;
  }

  .refresh-button-wrapper {
    margin-top: 10px;
    padding-right: 5px;
    font-size: x-large;
  }

  .rotate {
    -ms-transform: rotate(90deg); /* IE 9 */
    -moz-transform: rotate(90deg); /* Firefox */
    -webkit-transform: rotate(90deg); /* Safari and Chrome */
    -o-transform: rotate(90deg); /* Opera */
  }

  .workbench-bkg-wrapper-no-collapse {
    padding-top: 5px;
    display: inline-block;
    height: 835px;
    width: 100%;
    background-image: linear-gradient(to bottom, rgba(246, 246, 246, 0.7) 0%, rgba(246, 246, 246, 0.7) 100%), url('../assets/workbench_default_bkg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
  }

  .workbench-bkg-wrapper-collapse {
    padding-top: 5px;
    display: inline-block;
    height: 835px;
    width: 100%;
    background-image: linear-gradient(to bottom, rgba(246, 246, 246, 0.7) 0%, rgba(246, 246, 246, 0.7) 100%), url('../assets/workbench_default_bkg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
  }

</style>
