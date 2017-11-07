<template>
  <div id="tag_area">
    <el-tag
      :key="tag.name"
      :type="tag.type"
      v-for="tag in dynamicTags"
      :closable="true"
      :close-transition="false"
      @close="handleClose(tag)"
    >
      {{tag.name}}
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
    <el-button v-else class="button-new-tag" size="small" @click="showInput" v-show="notUpToMax">+ New Tag</el-button>
  </div>

</template>

<script>
  export default {
    name: 'tagArea',
    data () {
      return {
        dynamicTags: [{name: '游记', type: 'primary'},
          {name: '2017', type: 'primary'},
          {name: '夏天', type: 'primary'}],
        inputVisible: false,
        inputValue: '',
        notUpToMax: true
      }
    },
    methods: {
      handleClose (tag) {
        this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1)
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
          this.dynamicTags.push({name: inputValue, type: 'primary'})
        }
        this.inputVisible = false
        this.inputValue = ''
      }
    },
    watch: {
      dynamicTags: function () {
        if (this.dynamicTags.length >= 7) {
          this.notUpToMax = false
        } else {
          this.notUpToMax = true
        }
      }
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
