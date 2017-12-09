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
              <el-breadcrumb-item :to="{ path: '/profile/notes' }">{{curNote.notebook[0].notebook_name}}
              </el-breadcrumb-item>
              <el-breadcrumb-item>{{curNote.note.title}}</el-breadcrumb-item>
            </el-breadcrumb>
          </div>

          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-download" @click="downloadAsPDF"></i>
          </el-button>
          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-delete" @click="deleteCurNote"></i>
          </el-button>
          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-write" @click="jumpToWorkbench"></i>
          </el-button>

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
            <el-button v-if="!liked" size="large" @click="handleLike" class="like-button-wrapper">
              <i class="el-icon-ali-xihuan-xianxing"></i>
              {{curNote.like_count}}
            </el-button>
            <el-button v-else size="large" @click="cancelLike" class="like-button-wrapper">
              <i class="el-icon-ali-xihuan"></i>
              {{curNote.like_count}}
            </el-button>
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

  </div>

</template>

<script>
  import ElButton from '../../../../node_modules/element-ui/packages/button/src/button.vue'
  import router from '../../../router'
  import { mapActions, mapState } from 'vuex'
  import html2canvas from 'html2canvas'
  import JsPDF from 'jspdf'
  import ElPopover from '../../../../node_modules/element-ui/packages/popover/src/main.vue'
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
//        likeCnt: 538,
        liked: false,
        tagsType: 'warning',
        unlockPopoverVisible: false,
        lockPopoverVisible: false
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
          console.log('NoteViewPane created onSuccess')
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
      ...mapActions('note', [
        'fetchNoteDetail', 'fetchWorkbenchNoteDetail', 'deleteNote', 'editNotePermission'
      ]),
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
//        console.log(document.getElementById('content'))
//        console.log(document.body)
        let _this = this
        html2canvas(document.getElementById('pdf-wrap')).then(function (canvas) {
//          // 返回图片dataURL，参数：图片格式和清晰度(0-1)
//          var pageData = canvas.toDataURL('image/png', 1.0);
//
//          // 方向默认竖直，尺寸ponits，格式a4[595.28,841.89]
//          var pdf = new JsPDF('', 'pt', 'a4');
//
//          // addImage后两个参数控制添加图片的尺寸，此处将页面高度按照a4纸宽高比列进行压缩
//          pdf.addImage(pageData, 'PNG', 0, 0, 595.28, 592.28/canvas.width * canvas.height );
//          pdf.save(_this.curNote.note.title)
//        })
//        let pdf = new JsPDF('l', 'pt', 'a4');
//        let options = {
//          pagesplit: true
//        };
//
//        pdf.addHTML(document.getElementById('content'), 0, 0, options, function(){
//          pdf.save("test.pdf");
          document.body.appendChild(canvas)
//          let imgData = canvas.toDataURL(
//            'image/png');
//          let doc = new JsPDF('p', 'mm');
//          doc.addImage(imgData, 'PNG', 10, 10);
//          doc.save('sample-file.pdf');
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
</style>
