<template>
  <div class="pane-out-wrapper" id="pdf-wrap">
    <div class="pane-inner-wrapper">
      <div class="section-title-wrapper">
        <div style="float: left">
          <i class="el-icon-ali-edit_light"></i>
        </div>
        <div>
          <div style="float: left;padding-left: 2px">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item
                :to="{ name:'notebookNote', params: {userId: curNote.note.user_id, notebookId: curNote.note.notebook_id} }">
                {{curNote.notebook[0].notebook_name}}
              </el-breadcrumb-item>
              <el-breadcrumb-item>{{curNote.note.title}}</el-breadcrumb-item>
            </el-breadcrumb>
          </div>


          <el-popover
            ref="popover1"
            placement="top-start"
            width="150"
            trigger="hover"
            content="收藏到我的笔记本">
            <el-button slot="reference" type="text" class="operation-wrapper">
              <i class="el-icon-ali-fav" @click="saveToMyNotebook"></i>
            </el-button>
          </el-popover>


          <el-popover
            ref="popover2"
            placement="top-start"
            width="150"
            trigger="hover"
            content="下载为pdf">
            <el-button slot="reference" type="text" class="operation-wrapper">
              <i class="el-icon-ali-download" @click="downloadAsPDF"></i>
            </el-button>
          </el-popover>

          <el-popover
            ref="popover3"
            placement="top-start"
            width="150"
            trigger="hover"
            content="删除该笔记">
            <el-button slot="reference" type="text" class="operation-wrapper">
              <i class="el-icon-ali-delete" @click="deleteCurNote"></i>
            </el-button>
          </el-popover>

          <el-popover
            ref="popover4"
            placement="top-start"
            width="150"
            trigger="hover"
            content="编辑">
            <el-button slot="reference" type="text" class="operation-wrapper">
              <i class="el-icon-ali-write" @click="jumpToWorkbench"></i>
            </el-button>
          </el-popover>

          <el-popover
            ref="unlockPopover"
            placement="top"
            width="160"
            v-model="unlockPopoverVisible"
            v-show="curNote.note.permission=='private'">
            <p>是否将笔记公开？</p>
            <div style="text-align: right;margin: 0">
              <el-button size="mini" type="primary" @click="unlockNote">确定</el-button>
              <el-button size="mini" type="text" @click="unlockPopoverVisible=false">取消</el-button>
            </div>
            <el-button slot="reference" type="text" class="operation-wrapper">
              <i class="el-icon-ali-unlock"></i>
            </el-button>
          </el-popover>
          <el-popover
            ref="lockPopover"
            placement="top"
            width="160"
            v-model="lockPopoverVisible"
            v-show="curNote.note.permission=='public'"
          >
            <p>是否将笔记设为私有？</p>
            <div style="text-align: right;margin: 0">
              <el-button size="mini" type="primary" @click="lockNote">确定</el-button>
              <el-button size="mini" type="text" @click="lockPopoverVisible=false">取消</el-button>
            </div>
            <el-button slot="reference" type="text" class="operation-wrapper">
              <i class="el-icon-ali-lock"></i>
            </el-button>
          </el-popover>
        </div>
      </div>

      <div id="note_content">
        <div class="note-content-wrapper" v-html="formatContent"></div>
        <div class="note-info-wrapper">
          <div style="float: right;">
            <div v-show="!isLikedNote">
              <el-button size="large" @click="handleLike" class="like-button-wrapper">
                <i class="el-icon-ali-xihuan-xianxing"></i>
                {{curNote.like_count}}
              </el-button>
            </div>
            <div v-show="isLikedNote">
              <el-button size="large" @click="cancelLike" class="like-button-wrapper">
                <i class="el-icon-ali-xihuan"></i>
                {{curNote.like_count}}
              </el-button>
            </div>
          </div>
          <div>创建于: {{curNote.note.created_at}}</div>
          <div>更新于: {{curNote.note.updated_at}}</div>
          <div v-if="curNote.tags.length>0">标签:
            <el-tag
              v-for="tag in curNote.tags"
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

    <div>
      <el-dialog class="dialog" title="选择保存到的笔记本" :visible.sync="show_chooseNoteBook" width="30%">
        <div>
          <template>
            <el-select class="select" v-model="value" filterable placeholder="请选择">
              <el-option
                v-for="item in this.list"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
          </template>
        </div>

        <div slot="footer" style="text-align: center;">
          <el-button type="primary" @click="copyNote">确 定</el-button>
          <el-button @click="show_chooseNoteBook = false">取 消</el-button>
        </div>
      </el-dialog>
    </div>
  </div>

</template>

<script>
  import ElButton from '../../../../node_modules/element-ui/packages/button/src/button.vue'
  import router from '../../../router'
  import { mapActions, mapState } from 'vuex'
  import html2canvas from 'html2canvas'
  import JsPDF from 'jspdf'
  import ElPopover from '../../../../node_modules/element-ui/packages/popover/src/main.vue'
  import * as axios from 'axios'
  //  import * as rasterizeHTML from 'rasterizehtml';

  export default {
    components: {
      ElPopover,
      ElButton
    },
    name: 'noteViewPane',
    data () {
      return {
        noteId: this.$route.params.noteId,
        tagsType: 'warning',
        unlockPopoverVisible: false,
        lockPopoverVisible: false,
        show_chooseNoteBook: false,
        list: [],
        value: []
      }
    },
    computed: {
      ...mapState('note', {
        curNote: state => state.curNote,
        isLikedNote: state => state.isLikingNote
      }),
      ...mapState('auth', {
        user: state => state.user
      }),
      ...mapState('notebook', {
        myNotebooks: state => state.myNotebooks
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
          console.log(msg)
          this.$message.error(msg)
          router.back()
        }
      })
      this.isLikingCurNote({
        noteId: this.noteId,
        userId: this.user.id,
        onSuccess: () => {},
        onError: () => {}
      })
    },
    methods: {
      ...mapActions('note', [
        'fetchNoteDetail', 'fetchWorkbenchNoteDetail', 'deleteNote', 'editNotePermission',
        'isLikingCurNote', 'likeCurNote', 'unlikeCurNote', 'createNote', 'fetchPDF'
      ]),
      ...mapActions('notebook', [
        'fetchMyNotebooks'
      ]),
      handleLike () {
        console.log('handleLike')
        console.log(this.isLikedNote)
        this.likeCurNote({
          noteId: this.noteId,
          userId: this.user.id,
          onSuccess: () => {},
          onError: () => {}
        })
      },
      cancelLike () {
        console.log('cancelLike')
        console.log(this.isLikedNote)
        this.unlikeCurNote({
          noteId: this.noteId,
          userId: this.user.id,
          onSuccess: () => {},
          onError: () => {}
        })
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
      unlockNote () {
        this.unlockPopoverVisible = false
        this.editNotePermission({
            newPermission: 'public',
            noteInfo: this.curNote.note,
            onSuccess: () => {
              this.$message({
                message: '已将笔记权限修改为公开',
                type: 'success'
              })
            },
            onError: (msg) => {
              this.$message.error(msg)
            }
          }
        )
      },
      lockNote () {
        this.lockPopoverVisible = false
        this.editNotePermission({
            newPermission: 'private',
            noteInfo: this.curNote.note,
            onSuccess: () => {
              this.$message({
                message: '已将笔记权限修改为私有',
                type: 'success'
              })
            },
            onError: (msg) => {
              this.$message.error(msg)
            }
          }
        )
      },
      downloadAsPDF () {
        let _this = this
        axios({
          method: 'post',
          url: 'download',
          responseType: 'arraybuffer',
          data: {
            noteId: this.noteId
          }
        })
          .then(function (response) {
            let blob = new Blob([response.data], {type: 'application/pdf'})
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = _this.curNote.note.title + '.pdf'
            link.click()
          })
      },
      saveToMyNotebook () {
        this.show_chooseNoteBook = true
        this.fetchMyNotebooks({
          userId: this.user.id,
          onSuccess: () => {},
          onError: (msg) => this.$message.error(msg)
        })
        this.list = this.myNotebooks.map(item => {
          return {value: item.id, label: item.notebook_name}
        })
      },
      copyNote () {
        console.log('NoteViewPane 359')
        console.log(this.curNote.note)
        this.createNote({
          noteInfo: {
            userId: this.user.id,
            notebookId: this.value[0],
            noteTitle: '[转]' + this.curNote.note.title,
            noteContent: this.curNote.note.content,
            permission: 'public'
          },
          onSuccess: () => {
            this.show_chooseNoteBook = false
            router.push({name: 'notes', params: {userId: this.user.id}})
          },
          onError: () => {
            this.$message.error('创建失败')
          }
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

  .el-button + .el-button {
    margin-left: 0px;
  }

  .el-input-group__append div.el-select .el-input__inner, /deep/
  .el-input-group__append div.el-select:hover .el-input__inner, /deep/
  .el-input-group__prepend div.el-select .el-input__inner, /deep/
  .el-input-group__prepend div.el-select:hover /deep/ .el-input__inner {
    font-size: 13px;
    width: 101px;
    color: rgb(72, 106, 87);
  }

  .el-input-group__append, /deep/ .el-input-group__prepend {
    color: rgb(83, 113, 96);
  }

  .dialog {
    z-index: 2000 !important;
  }

  .el-select-dropdown__item {
    font-family: sans-serif;
  }


</style>
