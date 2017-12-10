<template>
  <div @click="jumpToNotebook">
    <el-col :span="4" style="padding-bottom: 145px">
      <div style="width: 100%;margin-left: 5%;height: 20px;">
        <el-card class="box-card">
          <div class="text item">
            <div class="notebook-name-wrapper">
              {{this.briefNotebook.notebook_name}}
            </div>
            <div class="notebook-info-wrapper">
              共{{this.briefNotebook.notes_count}}篇笔记
            </div>
            <div class="notebook-info-wrapper">
              最新修改于
            </div>
            <div class="notebook-info-wrapper">
              {{this.briefNotebook.updated_at}}
            </div>
          </div>
        </el-card>
      </div>
    </el-col>
  </div>
</template>

<script>
  import router from '../../router'
  import ElCard from '../../../node_modules/element-ui/packages/card/src/main.vue'
  import ElCol from 'element-ui/packages/col/src/col'

  export default {
    components: {
      ElCol,
      ElCard
    },
    name: 'searchBriefNotebookCard',
    props: ['briefNotebook'],
    methods: {
      jumpToNotebook () {
        router.push({
          name: 'notebookNote',
          params: {userId: this.briefNotebook.user_id, notebookId: this.briefNotebook.id}
        })
      }
    }
  }
</script>

<style scoped>
  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }

  .clearfix:after {
    clear: both;
  }

  .box-card {
    margin-left: 1%;
    margin-bottom: 3%;
  }

  .clearfix {
    text-align: left;
  }

  .box-card /deep/ .el-card__header {
    padding: 1px 15px;
  }

  /deep/ .el-card__body {
    padding: 10px 15px;
  }

  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
  }

  .notebook-name-wrapper {
    margin-top: 15%;
    margin-bottom: 20%;
    font-weight: bold;
    /*font-size: 1em;*/
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    cursor: pointer;
    text-align: center;
  }

  .notebook-info-wrapper {
    text-align: center;
    margin-top: 3px;
    font-size: smaller;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
</style>
