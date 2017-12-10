<template>
  <div>
    <el-col :span="4" style="padding-bottom: 100px">
      <div style="width: 100%;margin-left: 5%;height: 20px;">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <div @click="jumpToNoteDetail" class="brief-note-title-wrapper">{{this.noteInfo.title}}</div>
            <div class="update-time-wrapper">{{this.noteInfo.updated_at}}</div>
          </div>
          <div class="brief-note-content-wrapper">
            <el-tag type="primary">{{this.noteInfo.tag_content}}</el-tag>
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
    name: 'briefNoteTagCard',
    props: ['noteInfo'],
    methods: {
      jumpToNoteDetail () {
        router.push({name: 'noteview', params: {userId: this.noteInfo.user_id, noteId: this.noteInfo.id}})
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

  a:link,
  a:visited {
    color: #000000;
    text-decoration: none;
  }

  a:hover,
  a:active {
    color: darkgreen;
    text-decoration: none;
  }

  .brief-note-title-wrapper {
    line-height: 36px;
    font-weight: bold;
    cursor: pointer;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    font-size: small;
  }

  .brief-note-content-wrapper {
    font-size: 14px;
    float: left;
    padding-top: 0px;
    padding-bottom: 10px;
    text-align: left;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    /*overflow : hidden;*/
    /*text-overflow: ellipsis;*/
    /*display: -webkit-box;*/
    /*-webkit-line-clamp: 2;*/
    /*-webkit-box-orient: vertical;*/
    width: 100%;
  }

  .update-time-wrapper {
    font-size: smaller;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    margin-bottom: 5px;
  }

  /deep/ .el-card__body {
    padding: 10px 15px;
  }
</style>
