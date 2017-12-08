<template>
  <div>
    <el-dialog title="创建新笔记本" :visible.sync="dialogVisible" :show-close="false" class="dialog-wrapper">
      <div style="margin-left: auto;margin-right: auto">
        <el-form :model="notebookInfoForm">
          <el-form-item label="笔记本名称">
            <el-input v-model="notebookInfoForm.notebookName" auto-complete="off" placeholder="请输入笔记本名称"
                      style="width: 50%"></el-input>
          </el-form-item>
          <el-form-item label="笔记本权限">
            <el-radio class="radio" v-model="notebookInfoForm.permission" label="public">公开</el-radio>
            <el-radio class="radio" v-model="notebookInfoForm.permission" label="private">私有</el-radio>
          </el-form-item>
        </el-form>
      </div>
      <div style="text-align: center">
        <el-button @click="confirm" type="primary">确定</el-button>
        <el-button @click="closeDialog">取消</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import ElDialog from '../../../node_modules/element-ui/packages/dialog/src/component.vue'
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'
  import ElForm from '../../../node_modules/element-ui/packages/form/src/form.vue'
  import ElFormItem from '../../../node_modules/element-ui/packages/form/src/form-item.vue'
  import ElInput from '../../../node_modules/element-ui/packages/input/src/input.vue'
  import ElRadio from '../../../node_modules/element-ui/packages/radio/src/radio.vue'

  export default {
    components: {
      ElRadio,
      ElInput,
      ElFormItem,
      ElForm,
      ElButton,
      ElDialog
    },
    name: 'newNotebookDialog',
    props: ['dialogVisible'],
    data () {
      return {
        notebookInfoForm: {
          notebookName: '',
          permission: 'public'
        },
        width: '30px'
      }
    },
    methods: {
      closeDialog () {
        this.$emit('closeCreateNotebookDialog')
      },
      confirm () {
        this.$emit('confirmCreateNotebook', this.notebookInfoForm)
      }
    }
  }
</script>

<style scoped>
  .dialog-wrapper {
    min-width: 800px;
    text-align: center;
  }

  /deep/ .el-dialog__body {
    text-align: left;
  }

  .el-form {
    margin-left: 20%;
    margin-right: 10%;
  }
</style>
