<template>
  <el-col :span="6" style="padding-bottom: 20px">
    <div>
      <el-card>
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
</template>

<script>
  export default {
    name: 'briefNotebookCard',
    components: {},
    props: ['briefNotebook'],
    data () {
      return {}
    },
    methods: {}
  }
</script>

<style>
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
</style>
