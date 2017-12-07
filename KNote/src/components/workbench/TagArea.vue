<template>
  <div id="tag_area">
    <el-tag v-if="workbenchNote!==null"
            :type="tagType"
            v-for="tag in workbenchNote.tags"
            :closable="true"
            :close-transition="false"
            @close="handleClose(tag)"
    >
      {{tag.tag_content}}
    </el-tag>

    <el-input
      class="input-new-tag"
      v-if="inputVisible"
      v-model="inputValue"
      ref="saveTagInput"
      size="mini"
      @keyup.enter.native="handleInputConfirm"
      @blur="handleInputConfirm"
      maxlength="7"
    >
    </el-input>
    <el-button v-else class="button-new-tag" size="small" @click="showInput"
               v-show="workbenchNote==null||workbenchNote.tags.length<=6">
      + 新标签
    </el-button>
  </div>

</template>

<script>
  import { mapState, mapActions, mapMutations } from 'vuex'

  export default {
    name: 'tagArea',
    data () {
      return {
        tagType: 'primary',
        inputVisible: false,
        inputValue: '',
        notUpToMax: true
      }
    },
    computed: {
      ...mapState('note', {
        workbenchNote: state => state.workbenchNote
      })
    },
    methods: {
      handleClose (tag) {
        console.log(tag)
        this.removeTag(tag)
        this.deleteTagRelation({
          noteId: this.workbenchNote.note.id,
          relationId: tag.relationId,
          onSuccess: () => {
          },
          onError: (msg) => {
            this.$message.error(msg)
          }
        })
      },

      showInput () {
        this.inputVisible = true
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus()
        })
      },

      handleInputConfirm () {
        let inputValue = this.inputValue
        if (inputValue) {
          this.addTagRelation({
            noteId: this.workbenchNote.note.id,
            tagContent: inputValue,
            onSuccess: () => {
            },
            onError: (msg) => {
              this.$message.error(msg)
            }
          })
        }
        this.inputVisible = false
        this.inputValue = ''
      },
      ...mapActions('note', [
        'deleteTagRelation',
        'addTagRelation'
      ]),
      ...mapMutations('note', [
        'removeTag',
        'addTag'
      ])
    }
  }
</script>

<style scoped>
  .input-new-tag {
    width: 90px;
  }

  .el-tag--primary {
    margin-right: 4px;
    margin-top: 2px;
  }

</style>
