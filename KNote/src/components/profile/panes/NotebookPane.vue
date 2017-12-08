<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <div class="cur-location-wrapper">
        <i class="el-icon-ali-file"></i>
        笔记本
        <el-button v-if="user.id==userInfo[0].id" type="text" class="operation-wrapper"
                   @click="jumpToCreateNotebook">
          <i class="el-icon-plus"/>
        </el-button>
      </div>
      <el-row class="notebook-row-wrapper" :gutter="50">
        <brief-notebook-card v-for="notebook in notebooks" :briefNotebook="notebook"></brief-notebook-card>
      </el-row>
      <div v-show="notebooks.length==0" class="text item">暂无笔记本</div>
    </div>

    <new-notebook-dialog :dialogVisible="this.newNotebookDialogVisible"
                         @closeCreateNotebookDialog="closeNewNotebookDialog"
                         @confirmCreateNotebook="createNewNotebook"></new-notebook-dialog>
  </div>
</template>

<script>
  import router from '../../../router'
  import BriefNotebookCard from '../BriefNotebookCard.vue'
  import { mapActions, mapState } from 'vuex'
  import NewNotebookDialog from '../../dialog/NewNotebookDialog.vue'

  export default {
    components: {
      NewNotebookDialog,
      BriefNotebookCard
    },
    name: 'notebookPane',
    data () {
      return {
        newNotebookDialogVisible: false
      }
    },
    created () {
      this.fetchCurUserNotebooks({
        userId: this.userInfo[0].id,
        onSuccess: () => {},
        onError: (msg) => {
          this.$message.error(msg)
        }
      })
    },
    computed: {
      ...mapState('notebook', {
        notebooks: state => state.curUserNotebooks
      }),
      ...mapState('user', {
        userInfo: state => state.info
      }),
      ...mapState('auth', {
        user: state => state.user
      })
    },
    methods: {
      ...mapActions('notebook', [
        'fetchCurUserNotebooks', 'addNewNotebook'
      ]),
      handleClick () {
        router.push('/profile/notes')
      },
      jumpToCreateNotebook () {
        this.newNotebookDialogVisible = true
      },
      closeNewNotebookDialog () {
        this.newNotebookDialogVisible = false
      },
      createNewNotebook (notebookInfoForm) {
        notebookInfoForm.userId = this.user.id
        this.addNewNotebook({
          newNotebookInfo: notebookInfoForm,
          onSuccess: () => {
            this.$message({
              message: '创建笔记本成功!',
              type: 'success'
            })
            this.newNotebookDialogVisible = false
          },
          onError: (msg) => {
            this.$message.error(msg)
          }
        })
      }
    }
  }
</script>

<style scoped>
  @import "../../style/ProfileCurLocation.css";
  @import "../../../assets/icon/iconfont.css";
  @import "../../style/ProfilePaneOutWrapper.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: 8.7%;
    margin-right: 8.7%;
  }

  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
  }

  .notebook-name-wrapper {
    margin-top: 40%;
    margin-bottom: 50%;
    font-weight: bold;
  }

  .notebook-info-wrapper {
    margin-top: 3px;
    font-size: smaller;
  }

  .notebook-row-wrapper {
    margin-bottom: 30px;
  }

  .operation-wrapper {
    float: right;
    /*padding-right: 18%;*/
    font-size: small;
    padding-top: 4px;
  }

</style>
