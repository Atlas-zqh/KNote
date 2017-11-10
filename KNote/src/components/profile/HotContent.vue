<template>
  <div>
    <el-card class="box-card">
      <div v-for="o in 10" :key="o" class="text item">
        {{'列表内容 ' + o }}
      </div>
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'hotContent',
    data () {
      return {}
    }
  }
</script>

<style scoped>
  @import "../../assets/icon/iconfont.css";
  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
    text-align: left;
  }

  .box-card {
    width: 70%;
    margin-right: 15%;
    /*margin-bottom: 15%;*/
    float: right;
  }
</style>
