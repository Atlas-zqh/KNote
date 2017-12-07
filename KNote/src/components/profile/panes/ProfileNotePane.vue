<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <el-row :gutter="10">
        <el-col :span="14">
          <div class="section-title-wrapper">
            <i class="el-icon-ali-edit_light"></i>
            <span>全部笔记</span>
          </div>
          <div v-show="latestNotes.length==0" class="text item">暂无笔记</div>
          <brief-note-card v-for="note in latestNotes"
                           :briefNote="note"></brief-note-card>

        </el-col>
        <el-col :span="10">
          <div>
            <div class="section-title-wrapper2">
              <i class="el-icon-ali-hot"></i>
              热门笔记
            </div>
            <hot-content></hot-content>
          </div>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
  import ElRow from 'element-ui/packages/row/src/row'
  import ElCol from 'element-ui/packages/col/src/col'
  import BriefNoteCard from '../BriefNoteCard.vue'
  import HotContent from '../HotContent.vue'
//  import router from '../../../router'
  import { mapState, mapActions } from 'vuex'

  export default {
    components: {
      HotContent,
      BriefNoteCard,
      ElCol,
      ElRow
    },
    name: 'profileNotePane',
    data () {
      return {
        userId: this.$route.params.userId
      }
    },
    created () {
      this.fetchLatestNotes(this.userId)
    },
    methods: {
      ...mapActions('note', [
        'fetchLatestNotes'
      ])
    },
    computed: {
      ...mapState('note', {
        latestNotes: state => state.latestNotes
      })
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";
  @import "../../../assets/icon/iconfont.css";
  @import "../../style/ProfileCurLocation.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: auto;
    margin-right: auto;
  }

  .section-title-wrapper {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 3%;
  }

  .section-title-wrapper2 {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 4.1%;
  }

  .text {
    font-size: 14px;
  }

  .item {
    padding: 5px 0;
    margin-left: 15%;
    float: left;
  }
</style>
