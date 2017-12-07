<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <div class="section-title-wrapper">
        <div style="float: left">
          <i class="el-icon-ali-edit_light"></i>
        </div>
        <div>
          <div style="float: left;padding-left: 2px">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item :to="{ path: '/profile/notes' }">{{this.curNote.notebook[0].notebook_name}}
              </el-breadcrumb-item>
              <el-breadcrumb-item>{{this.curNote.note.title}}</el-breadcrumb-item>
            </el-breadcrumb>
          </div>

          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-write" @click="jumpToWorkbench"></i>
          </el-button>
          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-delete" @click="deleteCurNote"></i>
          </el-button>
        </div>

      </div>

      <div class="note-content-wrapper" v-html="formatContent"></div>
      <div class="note-info-wrapper">
        <div style="float: right;">
          <el-button v-if="!liked" size="large" @click="handleLike" class="like-button-wrapper">
            <i class="el-icon-ali-xihuan-xianxing"></i>
            {{this.curNote.like_count}}
          </el-button>
          <el-button v-else size="large" @click="cancelLike" class="like-button-wrapper">
            <i class="el-icon-ali-xihuan"></i>
            {{this.curNote.like_count}}
          </el-button>
        </div>
        <div>创建于: {{this.curNote.note.created_at}}</div>
        <div>更新于: {{this.curNote.note.updated_at}}</div>
        <div v-if="this.curNote.tags.length>0">标签:
          <el-tag
            v-for="tag in this.curNote.tags"
            :key="tag.tag_content"
            :closable="false"
            :type="tagsType"
          >
            {{tag.tag_content}}
          </el-tag>
        </div>
        <div v-else>标签:&nbsp&nbsp&nbsp&nbsp暂无</div>

      </div>

    </div>

  </div>

</template>

<script>
  import ElButton from '../../../../node_modules/element-ui/packages/button/src/button.vue'
  import router from '../../../router'
  import { mapActions, mapState } from 'vuex'

  export default {
    components: {ElButton},
    name: 'noteViewPane',
    data () {
      return {
        noteId: this.$route.params.noteId,
//        likeCnt: 538,
        liked: false,
        tagsType: 'warning'
      }
    },
    computed: {
      ...mapState('note', {
        curNote: state => state.curNote
      }),
      ...mapState('auth', {
        user: state => state.user
      }),
      formatContent: function () {
        return '<h1>' + this.curNote.note.title + '</h1>' + this.curNote.note.content
      }
    },
    created () {
      this.fetchNoteDetail({
        noteId: this.noteId,
        onSuccess: (detail) => {
          console.log(detail)
        },
        onError: (msg) => {
          console.log('error')
          console.log(msg)
          this.$message.error(msg)
          router.back()
        }
      })
    },
    methods: {
      handleLike () {
        this.liked = true
        this.likeCnt += 1
      },
      cancelLike () {
        this.liked = false
        this.likeCnt -= 1
      },
      deleteCurNote () {
        this.$confirm('确认删除该笔记 ?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.deleteNote({
            noteId: this.curNote.note.id,
            onSuccess: () => {
              this.$message({
                type: 'success',
                message: '删除成功!'
              })
              router.push({name: 'userProfile', params: {userId: this.user.id}})
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
      },
      jumpToWorkbench () {
        this.fetchWorkbenchNoteDetail({
          noteId: this.curNote.note.id,
          onSuccess: () => {
            router.push({name: 'workbench', params: {userId: this.user.id}})
          },
          onError: (msg) => {
            this.$message.error(msg)
          }
        })
      },
      ...mapActions('note', [
        'fetchNoteDetail', 'fetchWorkbenchNoteDetail', 'deleteNote'
      ])
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";
  @import "../../../assets/icon/iconfont.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: 8.7%;
    margin-right: 8.7%;
  }

  .section-title-wrapper {
    color: darkgreen;
    text-align: left;
    margin-bottom: 3%;
  }

  .el-breadcrumb {
    font-size: 16px;
    line-height: 1.45;
    /*padding-left: 200px;*/
  }

  .note-content-wrapper {
    margin-top: 40px;
    padding: 3% 3%;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(228, 241, 235, 0.11);
    word-break: break-all;
    text-align: left;
  }

  .note-info-wrapper {
    /*margin-top: 40px;*/
    padding: 3% 3%;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(228, 241, 235, 0.11);
    word-break: break-all;
    text-align: left;
    font-size: 14px;
    color: #2a8146;
  }

  .like-button-wrapper {
    color: #2a8146;
    margin-top: 20px;
  }

  .operation-wrapper {
    float: right;
    font-size: larger;
    padding-top: 3px;
  }

  .el-tag--warning {
    margin-right: 4px;
    margin-top: 2px;
  }
</style>
