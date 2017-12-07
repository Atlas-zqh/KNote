<template>
  <div style="width: 100%;margin-left: 5%">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <!--<a :href="'/#/profile/noteview'">-->
        <span @click="jumpToNoteDetail" style="line-height: 36px; font-weight: bold;">{{this.briefNote.title}}</span>
        <!--</a>-->
        <br>
        <span style="font-size: small">{{this.briefNote.updated_at}}</span>
      </div>
      <div class="text item">
        {{this.briefNote.content}}
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
  .text {
    font-size: 14px;
  }

  .item {
    float: left;
    padding-top: 0px;
    padding-bottom: 20px;
    text-align: left;
  }

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

</style>
