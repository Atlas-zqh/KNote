<template>
  <div>
    <el-card class="box-card">
      <div>
        <li class="text item">
          名称: {{curNotebookNotes.notebookName}}
        </li>
        <li  class="text item">
          笔记数: {{curNotebookNotes.notesCount}}
        </li>
        <li class="text item">
          创建于: {{curNotebookNotes.createdAt}}
        </li>
        <li class="text item">
          权限: {{curNotebookNotes.permission==='public'?'公开':'私有'}}
        </li>
      </div>
    </el-card>
  </div>
</template>

<script>
  import ElCard from '../../../node_modules/element-ui/packages/card/src/main.vue'
  import { mapState } from 'vuex'

  export default {
    components: {ElCard},
    name: 'notebookInfo',
    computed: {
      ...mapState('notebook', {
        curNotebookNotes: state => state.curNoteBookNotes
      })
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
