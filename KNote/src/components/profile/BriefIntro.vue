<template>
  <div>
    <el-card class="box-card">
      <div class="text item">
        <i class="el-icon-ali-mail"></i>
        e-mail : {{userInfo[0].email}}
      </div>
      <div class="text item">
        <i class="el-icon-ali-gender"></i>
        性别 : {{userInfo[0].gender}}
      </div>
      <div class="text item">
        <i class="el-icon-ali-tag"></i>
        常用标签 :
        <span v-if="frequentTags.length>0">
          <el-tag
            v-for="tag in frequentTags"
            :key="tag.tag_content"
            :closable="false"
            :type="tagType"
          >
            {{tag.tag_content}}
          </el-tag>
        </span>
        <span class="item" v-show="frequentTags.length==0">暂无常用标签</span>
      </div>
    </el-card>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {
    name: 'hotContent',
    data () {
      return {
        userId: this.$route.params.userId,
        tagType: 'warning'
      }
    },
    created () {
      this.fetchFrequentTags(this.userId)
    },
    computed: {
      ...mapState('user', {
        userInfo: state => state.info,
        frequentTags: state => state.frequentTags
      })
    },
    methods: {
      ...mapActions('user', [
        'fetchFrequentTags'
      ])
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
