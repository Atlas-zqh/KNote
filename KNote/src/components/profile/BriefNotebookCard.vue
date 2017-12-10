<template>
  <div @click="jumpToNotebookNotes(briefNotebook.id, briefNotebook.user_id)">

    <el-col :span="6" style="padding-bottom: 20px">
      <div>
        <el-card style="height: 235px">
          <div class="text item">
            <div class="notebook-name-wrapper">
              {{this.briefNotebook.notebook_name}}
            </div>
            <div class="notebook-info-wrapper">
              共 {{this.briefNotebook.notes_count}} 篇笔记
            </div>
            <div class="notebook-info-wrapper">
              最新修改于
            </div>
            <div class="notebook-info-wrapper">
              {{this.briefNotebook.updated_at}}
            </div>
          </div>
        </el-card>
      </div>
    </el-col>
  </div>

</template>

<script>
  import router from '../../router'

  export default {
    name: 'briefNotebookCard',
    components: {},
    props: ['briefNotebook'],
    data () {
      return {}
    },
    methods: {
      jumpToNotebookNotes (notebookId, userId) {
        router.push({name: 'notebookNote', params: {notebookId: notebookId, userId: userId}})
      }
    }
  }
</script>

<style scoped>
  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
  }

  .notebook-name-wrapper {
    margin-top: 25%;
    margin-bottom: 40%;
    font-weight: bold;
    /*font-size: 1em;*/
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    cursor: pointer
  }

  .notebook-info-wrapper {
    margin-top: 3px;
    font-size: smaller;
  }
</style>
