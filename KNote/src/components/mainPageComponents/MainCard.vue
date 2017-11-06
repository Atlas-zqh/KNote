<template xmlns="http://www.w3.org/1999/html">
  <el-row :gutter="40">
    <!--<el-col :span="6" v-for="(o, index) in 3" :key="o" :offset="(index>0) ? 2 : 0">-->
    <el-col :span="9">
      <div>
        <el-card :body-style="{ padding: '10px' }">
          <img src="../../assets/desk.png" class="image">
          <div style="padding: 14px;">
            <span>好吃的汉堡</span>
          </div>
        </el-card>
      </div>
    </el-col>

    <el-col :span="9">
      <div>
        <el-card :body-style="{ padding: '10px' }">
          <img src="../../assets/cloud.png" class="image">
          <div style="padding: 14px;">
            <span>好吃的汉堡</span>
          </div>
        </el-card>
      </div>
    </el-col>

    <el-col :span="9">
      <div>
        <el-card :body-style="{ padding: '10px' }">
          <img src="../../assets/keyboard.png" class="image">
          <div style="padding: 14px;">
            <span>好吃的汉堡</span>
          </div>
        </el-card>
      </div>
    </el-col>
  </el-row>
</template>

<script>
  import { Col, Row, Card } from 'element-ui'

  export default {
    name: 'mainCard',
    components: {
      elCol: Col,
      elRow: Row,
      elCard: Card
    }
  }
</script>


<style scoped>
  /*.time {*/
  /*font-size: 13px;*/
  /*color: #999;*/
  /*}*/

  .el-card {
    width: 100%;
    height: 350px;
  }

  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }

  .image {
    width: 180px;
    display: inline-block;
  }

  .el-col /deep/ .el-col-9 {
    padding-left: 0;
    padding-right: 0;
  }

  .el-col-9 {
    width: 33%;
  }

  .el-card__body {
    text-align: center;
    display: inline-block
  }
</style>
