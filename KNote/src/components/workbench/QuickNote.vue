<template>
  <div>
    <modal name="quick-note" height="700px" width="600px" :clickToClose="true">
      啊啊啊啊啊啊
      <div class="quick-note-wrapper">
        <vue-editor v-model="editor_content" quickMode="true"></vue-editor>
      </div>
    </modal>
  </div>
</template>

<script>
  import VueEditor from './VueEditor.vue'

  export default {
    name: 'quickNote',
    components: {
      VueEditor
    },
    data () {
      return {
        editor_content: 'Hello!'
      }
    }
  }
</script>

<style scoped>
  /deep/.ql-container {
    min-height: 200px;
  }

  .quick-note-wrapper {
    width: 50%;
    height: 210px;
  }
</style>
