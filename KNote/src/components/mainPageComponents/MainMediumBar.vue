<template>
  <div class="foot">
    <!--<el-row :gutter="20">-->
      <!--<el-col :span="9">-->
        <!--&lt;!&ndash;<div class="grid-content bg-purple"></div>&ndash;&gt;-->
        <br/>
        <h1 style="margin-top: 40px; font-size: 40px; margin-bottom: 15px">一起<br/>用KNote记录更多</h1>
        <el-button type="primary" style="margin-top: 0">创建新笔记</el-button>
      <!--</el-col>-->

      <!--<el-col :span="9">-->
        <!--<div class="grid-content bg-purple">-->

        <!--</div></el-col>-->
    <!--</el-row>-->
  </div>
</template>

<script>
  export default {
    name: 'mainMediumBar'
  }
</script>

<style scoped>
  .foot {
    width: 100%;
    height: 300px;
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

  .bg-purple {
    background: #d3dce6;
  }

  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
</style>
