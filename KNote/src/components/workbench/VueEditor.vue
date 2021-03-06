<template>
  <div class="quillWrapper">
    <div ref="quillContainer" :id="id"></div>
    <input v-if="useCustomImageHandler" @change="emitImageInfo($event)" ref="fileInput" id="file-upload" type="file"
           style="display:none;">
  </div>
</template>

<script>
  import Quill from 'quill'
  import 'quill/dist/quill.core.css'
  import 'quill/dist/quill.snow.css'

  var defaultToolbar = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block', 'image'],

    [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],

    [{'indent': '-1'}, {'indent': '+1'}],
    [{'header': [1, 2, 3, 4, 5, 6, false]}],

    [{'color': []}, {'background': []}],
    [{'font': []}],
    [{'align': []}],

    ['clean']
  ]
  //
  //  var quickNoteToolbar = [
  //    ['bold', 'italic', 'underline', 'strike'],
  //    ['blockquote', 'code-block', 'image'],
  //    [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
  //    [{'color': []}, {'background': []}, {'size': []}]
  //  ]

  export default {
    name: 'vue-editor',
    props: {
      value: String,
      id: {
        type: String,
        default: 'quill-container'
      },
      placeholder: String,
      disabled: Boolean,
      editorToolbar: Array,
      useCustomImageHandler: {
        type: Boolean,
        default: false
      },
      quickMode: Boolean
    },

    data () {
      return {
        quill: null,
        editor: null,
        toolbar: defaultToolbar
      }
    },

    mounted () {
      this.initializeVue2Editor()
      this.handleUpdatedEditor()
    },

    watch: {
      value (val) {
        if (val !== this.editor.innerHTML && !this.quill.hasFocus()) {
          this.editor.innerHTML = val
        }
      },
      disabled (status) {
        this.quill.enable(!status)
      }
    },

    methods: {
      initializeVue2Editor () {
        this.setQuillElement()
        this.setEditorElement()
        this.checkForInitialContent()
      },

      setQuillElement () {
        this.quill = new Quill(this.$refs.quillContainer, {
          modules: {
            toolbar: this.toolbar
          },
          placeholder: this.placeholder ? this.placeholder : '',
          theme: 'snow',
          readOnly: this.disabled ? this.disabled : false
        })
        this.checkForCustomImageHandler()
      },

      setEditorElement () {
        this.editor = document.querySelector(`#${this.id} .ql-editor`)
      },

      checkForInitialContent () {
        this.editor.innerHTML = this.value || ''
      },

      checkForCustomImageHandler () {
        if (this.useCustomImageHandler) {
          this.setupCustomImageHandler()
        }
      },
      setupCustomImageHandler () {
        let toolbar = this.quill.getModule('toolbar')
        toolbar.addHandler('image', this.customImageHandler)
      },

      handleUpdatedEditor () {
        this.quill.on('text-change', () => {
          this.$emit('input', this.editor.innerHTML)
        })
      },

      customImageHandler (image, callback) {
        this.$refs.fileInput.click()
      },

      emitImageInfo ($event) {
        let file = $event.target.files[0]
        let Editor = this.quill
        let range = Editor.getSelection()
        let cursorLocation = range.index
        this.$emit('imageAdded', file, Editor, cursorLocation)
      }
    }
  }
</script>

<style scoped>
  .ql-container {
    min-height: 700px;
  }

  .ql-editor {
    font-size: 16px;
  }

  .quillWrapper .ql-editor ul[data-checked=true] > li::before, .quillWrapper .ql-editor ul[data-checked=false] > li::before {
    font-size: 1.35em;
    vertical-align: baseline;
    bottom: -0.065em;
    font-weight: 900;
    color: #222;
  }

  div#quill-container.ql-container.ql-snow {
    height: 190px;
    overflow: scroll;
  }

</style>
