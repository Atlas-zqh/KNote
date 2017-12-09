<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <el-row :gutter="10">
        <el-col :span="14">
          <div class="section-title-wrapper">
            <i class="el-icon-ali-edit_light"></i>
            <span>"{{curNotebookNotes.notebookName}}"中的笔记</span>
          </div>
          <div v-show="curNotebookNotes.notes.length==0" class="text item">暂无笔记</div>
          <brief-note-card v-for="note in curNotebookNotes.notes"
                           :briefNote="note"></brief-note-card>
        </el-col>
        <el-col :span="10">
          <div>
            <div class="section-title-wrapper2">
              <i class="el-icon-ali-hot"></i>
              笔记本信息
              <div class="operation-wrapper">
                <el-button type="text" class="operation-wrapper" @click="jumpToDeleteNotebook">
                  <i class="el-icon-ali-delete"></i>
                </el-button>
                <el-button type="text" class="operation-wrapper" @click="jumpToModifyNotebook">
                  <i class="el-icon-ali-edit"></i>
                </el-button>
              </div>
            </div>
          </div>
          <notebook-info></notebook-info>
        </el-col>
      </el-row>
    </div>
    <modify-notebook-dialog :dialogVisible="this.modifyNotebookDialogVisible" :notebook="curNotebookNotes"
                            @closeModifyNotebookDialog="closeEditNotebookDialog"
                            @confirmModifyNotebook="modifyNotebook"></modify-notebook-dialog>
  </div>
</template>

<script>
  import ElRow from 'element-ui/packages/row/src/row'
  import ElCol from 'element-ui/packages/col/src/col'
  import HotContent from '../HotContent.vue'
  import { mapActions, mapState } from 'vuex'
  import BriefNoteCard from '../BriefNoteCard.vue'
  import NotebookInfo from '../NotebookInfo.vue'
  import ModifyNotebookDialog from '../../dialog/ModifyNotebookDialog.vue'
  import router from '../../../router'

  export default {
    components: {
      ModifyNotebookDialog,
      NotebookInfo,
      BriefNoteCard,
      HotContent,
      ElCol,
      ElRow
    },
    name: 'notebookNotePane',
    computed: {
      ...mapState('notebook', {
        curNotebookNotes: state => state.curNoteBookNotes
      })
    },
    created () {
      this.fetchNotesInNotebook({
        notebookId: this.notebookId,
        userId: this.userId,
        onSuccess: () => {},
        onError: (msg) => {
          this.$message.error(msg)
        }
      })
    },
    data () {
      return {
        userId: this.$route.params.userId,
        notebookId: this.$route.params.notebookId,
        modifyNotebookDialogVisible: false
      }
    },
    methods: {
      ...mapActions('notebook', [
        'fetchNotesInNotebook', 'editNotebookInfo', 'deleteCurNotebook'
      ]),
      jumpToModifyNotebook () {
        this.modifyNotebookDialogVisible = true
      },
      closeEditNotebookDialog () {
        this.modifyNotebookDialogVisible = false
      },
      modifyNotebook (notebookInfoForm) {
        notebookInfoForm.userId = this.userId
        this.editNotebookInfo({
          notebookInfo: notebookInfoForm,
          onSuccess: () => {
            this.modifyNotebookDialogVisible = false
            this.$message({
              message: '修改笔记本信息成功',
              type: 'success'
            })
          },
          onError: (msg) => {this.$message.error(msg)}
        })
      },
      jumpToDeleteNotebook () {
        this.$confirm('删除笔记本时会将笔记本中的笔记删除，是否确认删除该笔记本 ?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.deleteCurNotebook({
            userId: this.userId,
            notebookId: this.notebookId,
            onSuccess: () => {
              this.$message({
                type: 'success',
                message: '删除成功!'
              })
              router.push({name: 'notebooks', params: {userId: this.userId}})
            },
            onError: () => {
              this.$message.error('删除失败!')
            }
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          })
        })
      }
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";
  @import "../../../assets/icon/iconfont.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: auto;
    margin-right: auto;
  }

  .section-title-wrapper {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 3%;
  }

  .section-title-wrapper2 {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 4.1%;
  }

  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
    margin-left: 15%;
    float: left;
  }

  .operation-wrapper {
    float: right;
    padding-right: 18%;
    font-size: large;
    padding-top: 1px;
  }
</style>
