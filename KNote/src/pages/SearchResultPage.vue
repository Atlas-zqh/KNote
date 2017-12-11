<template>
  <div>
    <menu-bar></menu-bar>
    <div class="search-result-out-pane-wrapper">
      <div class="search-result-inner-wrapper">
        <div style="font-size: 40px; font-weight: bold">搜索结果</div>
        <div v-show="searchresult.myNotes.length!=0">
          <div class="text item">
            <i class="el-icon-search"></i>
            我的笔记中包含"{{searchresult.searchContent}}"的
          </div>
          <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%;">
            <vertical-brief-note-card v-for="note in searchresult.myNotes" :briefNote="note"></vertical-brief-note-card>
          </el-row>
        </div>


        <div v-show="searchresult.myNotebooks.length!=0">
          <div class="text item">
            <i class="el-icon-search"></i>
            我的笔记本中包含"{{searchresult.searchContent}}"的
          </div>
          <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%">
            <search-brief-notebook-card v-for="notebook in searchresult.myNotebooks"
                                        :briefNotebook="notebook"></search-brief-notebook-card>
          </el-row>
        </div>

        <div v-show="searchresult.tags.length!=0">
          <div class="text item">
            <i class="el-icon-search"></i>
            我的笔记标签中包含"{{searchresult.searchContent}}"的
          </div>
          <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%;">
            <brief-note-tag-card v-for="noteInfo in searchresult.tags" :noteInfo="noteInfo"></brief-note-tag-card>
          </el-row>
        </div>


        <div v-show="searchresult.users.length!=0">
          <div class="text item">
            <i class="el-icon-search"></i>
            用户名中包含"{{searchresult.searchContent}}"的
          </div>
          <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%;">
            <brief-user-profile-card v-for="userProfile in searchresult.users"
                                     :userBrief="userProfile"></brief-user-profile-card>
          </el-row>
        </div>

        <div v-show="searchresult.othersNotes.length!=0">
          <div class="text item">
            <i class="el-icon-search"></i>
            他人的笔记中包含"{{searchresult.searchContent}}"的
          </div>
          <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%;">
            <vertical-brief-note-card v-for="note in searchresult.othersNotes"
                                      :briefNote="note"></vertical-brief-note-card>
          </el-row>
        </div>


        <div v-show="searchresult.othersNotebooks.length!=0">
          <div class="text item">
            <i class="el-icon-search"></i>
            他人的笔记本中包含"{{searchresult.searchContent}}"的
          </div>
          <el-row :gutter="10" style="margin-left: -5px;margin-right: 6%">
            <search-brief-notebook-card v-for="notebook in searchresult.othersNotebooks"
                                        :briefNotebook="notebook"></search-brief-notebook-card>
          </el-row>
        </div>
      </div>
    </div>
    <main-foot></main-foot>

  </div>
</template>

<script>
  import MenuBar from '../components/Layout/MenuBar.vue'
  import MainFoot from '../components/Layout/MainFoot.vue'
  import VerticalBriefNoteCard from '../components/profile/VerticalBriefNoteCard.vue'
  import ElRow from 'element-ui/packages/row/src/row'
  import BriefNoteTagCard from '../components/profile/BriefNoteTagCard.vue'
  import BriefNotebookCard from '../components/profile/BriefNotebookCard.vue'
  import SearchBriefNotebookCard from '../components/profile/SearchBriefNotebookCard.vue'
  import BriefUserProfileCard from '../components/profile/BriefUserProfile.vue'
  import { mapState } from 'vuex'

  export default {
    components: {
      BriefUserProfileCard,
      SearchBriefNotebookCard,
      BriefNotebookCard,
      BriefNoteTagCard,
      ElRow,
      VerticalBriefNoteCard,
      MainFoot,
      MenuBar
    },
    name: 'searchResultPage',
    computed: {
      ...mapState('search', {
        searchresult: state => state.searchResult
      })
    },
    methods: {}
  }
</script>

<style scoped>
  .search-result-out-pane-wrapper {
    margin-top: 20px;
    width: 81%;
    min-width: 800px;
    height: auto;
    min-height: 800px;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(238, 246, 242, 0.28);
  }

  .search-result-inner-wrapper {
    text-align: left;
    padding-top: 3%;
    padding-bottom: 3%;
    padding-left: 5%;
    margin-left: auto;
    margin-right: auto;
  }

  .text {
    font-size: 17px;
  }

  .item {
    padding: 5px 0;
    /*margin-left: 15%;*/
    /*float: left;*/
  }
</style>
