<template>
  <div style="width: 100%;margin-left: 5%">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <a :href="'/#/'">
          <span style="line-height: 36px; font-weight: bold;">{{title}}</span>
        </a>
        <br>
        <span style="font-size: small">{{date}}</span>
      </div>
      <div class="text item">
        {{content}}
      </div>
    </el-card>
  </div>
</template>
<script>
  export default {
    name: 'briefNoteCard',
    components: {},
    data () {
      return {
        title: '大开眼界 Voir du pays (2016)',
        date: '2017-11-09',
        content: '即使是在军队中，不平等的性别差也非常明显，尤其是部队这种“力量”世界，男性对女性的“轻视“更加突出，作为一名女性，不管你外貌如何或是何种职业，总会有一群男人想睡你，不容许你有一丝一毫的“僭越”。他们从骨子里认为自己在女人面前是上帝。所谓并肩作战的“兄弟情”，是不会与异性分享的！'
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
