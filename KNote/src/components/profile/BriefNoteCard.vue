<template>
  <div style="width: 100%;margin-left: 5%">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <!--<a :href="'/#/profile/noteview'">-->
        <span @click="jumpToNoteDetail" class="brief-note-title-wrapper">{{this.briefNote.title}}</span>
        <!--</a>-->
        <br>
        <span style="font-size: small">{{this.briefNote.updated_at}}</span>
      </div>
      <div class="brief-note-content-wrapper">
        {{this.briefNote.content.replace(/<\/?.+?>/g, '').replace(/ /g, '')}}
      </div>
    </el-card>
  </div>
</template>
<script>
  import router from '../../router'

  export default {
    name: 'briefNoteCard',
    components: {},
    props: ['briefNote'],
    data () {
      return {}
    },
    methods: {
      jumpToNoteDetail () {
        router.push({name: 'noteview', params: {noteId: this.briefNote.id}})
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
    margin-left: 10%;
    margin-bottom: 3%;
  }

  .clearfix {
    text-align: left;
  }

  .box-card /deep/ .el-card__header {
    padding: 10px 20px;
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
  }

  .brief-note-content-wrapper{
    font-size: 14px;
    float: left;
    padding-top: 0px;
    padding-bottom: 20px;
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

</style>
