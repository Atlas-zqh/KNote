<template>
  <div>
    <el-input placeholder="请输入标题..." :maxlength="30" v-bind:value="value"
              @change="handleInput($event)"></el-input>
    <!--<span>-->
          <!--<el-button type="text" style="float: right">-->
      <!--<i class="el-icon-ali-sync"></i>-->
    <!--</el-button>-->
    <!--</span>-->
  </div>
</template>

<script>
//  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'

  export default {
//    components: {ElButton},
    name: 'titleEditor',
    props: ['value'],
    methods: {
      handleInput (value) {
        this.$emit('input', value)
      }
    }
  }
</script>

<style scoped>
  @import "../../assets/icon/iconfont.css";

  .el-input /deep/ .el-input__inner {
    border: none;
    height: 60px;
    font-size: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 5px;
  }

  /*::-webkit-input-placeholder { !* WebKit browsers *!*/
  /*color: #ececec;*/
  /*}*/

  /*:-moz-placeholder { !* Mozilla Firefox 4 to 18 *!*/
  /*color: #ececec;*/
  /*opacity: 1;*/
  /*}*/

  /*::-moz-placeholder { !* Mozilla Firefox 19+ *!*/
  /*color: #ececec;*/
  /*opacity: 1;*/
  /*}*/

  /*:-ms-input-placeholder { !* Internet Explorer 10+ *!*/
  /*color: #ececec;*/
  /*}*/
</style>
