<template>
  <div>
    <el-card class="box-card">
      <div class="text item">
        <i class="el-icon-ali-mail"></i>
        e-mail : {{email}}
      </div>
      <div class="text item">
        <i class="el-icon-ali-gender"></i>
        性别 : {{gender}}
      </div>
      <div class="text item">
        <i class="el-icon-ali-tag"></i>
        常用标签 :
        <el-tag
          v-for="tag in tags"
          :key="tag.name"
          :closable="false"
          :type="tag.type"
        >
          {{tag.name}}
        </el-tag>
      </div>
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'hotContent',
    data () {
      return {
        email: 'zqhatlas@gmail.com',
        gender: '男',
        tags: [
          {name: '标签一', type: 'warning'},
          {name: '标签二', type: 'warning'},
          {name: '标签三', type: 'warning'},
          {name: '标签四', type: 'warning'},
          {name: '标签五', type: 'warning'},
          {name: '标签六', type: 'warning'}
        ]
      }
    }
  }
</script>

<style scoped>
  @import "../../assets/icon/iconfont.css";

  .text {
    font-size: 14px;
  }

  .item {
    padding: 8px 0;
    text-align: left;
  }

  .box-card {
    width: 70%;
    margin-right: 15%;
    margin-bottom: 15%;
    float: right;
  }

  .el-tag--warning {
    margin-right: 4px;
    margin-top: 2px;
  }
</style>
