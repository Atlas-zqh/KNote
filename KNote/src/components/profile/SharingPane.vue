<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <el-row :gutter="10">
        <el-col :span="14">
          <div class="notify-wrapper1">
            <i class="el-icon-ali-calendar"></i>
            最新动态
          </div>
          <brief-note-card></brief-note-card>
          <brief-note-card></brief-note-card>
          <brief-note-card></brief-note-card>
          <brief-note-card></brief-note-card>
        </el-col>
        <el-col :span="10">
          <div>
            <div class="notify-wrapper2">
              <i class="el-icon-ali-my"></i>
              关于我
            </div>
            <brief-intro></brief-intro>
          </div>
          <div>
            <div class="notify-wrapper2">
              <i class="el-icon-ali-hot"></i>
              热门笔记
            </div>
            <hot-content></hot-content>
          </div>
        </el-col>
      </el-row>
    </div>
  </div>

</template>

<script>
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'
  import BriefNoteCard from './BriefNoteCard.vue'
  import HotContent from './HotContent.vue'
  import BriefIntro from './BriefIntro.vue'
  import ElRow from 'element-ui/packages/row/src/row'
  import ElCol from 'element-ui/packages/col/src/col'

  export default {
    components: {
      ElCol,
      ElRow,
      ElButton,
      BriefNoteCard,
      HotContent,
      BriefIntro
    },
    name: 'sharingPane'
  }
</script>

<style scoped>
  .pane-out-wrapper {
    margin-top: 20px;
    width: 81%;
    min-width: 800px;
    height: auto;
    min-height: 550px;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(238, 246, 242, 0.28);
    /*background-color: red;*/
  }

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: auto;
    margin-right: auto;
  }

  .notify-wrapper1 {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 3%;
  }

  .notify-wrapper2 {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 4.1%;
  }

</style>
