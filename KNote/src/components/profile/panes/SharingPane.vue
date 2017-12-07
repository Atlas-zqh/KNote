<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <el-row :gutter="10">
        <el-col :span="14">
          <div class="notify-wrapper1">
            <i class="el-icon-ali-calendar"></i>
            最新动态
          </div>
          <div v-if="latestNotes.length>0">
            <brief-note-card v-for="note in this.latestNotes"
                             :briefNote="note"></brief-note-card>
          </div>
          <div v-show="latestNotes.length==0" class="text item">暂无新动态</div>
        </el-col>
        <el-col :span="10">
          <div>
            <div class="notify-wrapper2">
              <i class="el-icon-ali-my"></i>
              关于我
              <el-button v-if="this.user.id==this.userId" type="text" class="operation-wrapper"
                         @click="jumpToProfileEdit">修改个人信息
              </el-button>
            </div>
            <brief-intro></brief-intro>
          </div>
          <div>
            <div class="notify-wrapper2">
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
  import ElButton from '../../../../node_modules/element-ui/packages/button/src/button.vue'
  import BriefNoteCard from '../BriefNoteCard.vue'
  import HotContent from '../HotContent.vue'
  import BriefIntro from '../BriefIntro.vue'
  import ElRow from 'element-ui/packages/row/src/row'
  import ElCol from 'element-ui/packages/col/src/col'
  import router from '../../../router'
  import { mapState, mapActions } from 'vuex'

  export default {
    components: {
      ElCol,
      ElRow,
      ElButton,
      BriefNoteCard,
      HotContent,
      BriefIntro
    },
    name: 'sharingPane',
    props: ['curUserId'],
    data () {
      return {
        userId: this.curUserId
      }
    },
    created () {
      console.log('aaaa' + this.userId)
      this.fetchLatestNotes(this.userId)
    },
    methods: {
      jumpToProfileEdit () {
        router.push({name: 'profileEdit'})
      },
      ...mapActions('note', [
        'fetchLatestNotes'
      ])
    },
    computed: {
      ...mapState('note', {
        latestNotes: state => state.latestNotes
      }),
      ...mapState('auth', {
        user: state => state.user
      })
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: auto;
    margin-right: auto;
  }

  .notify-wrapper1 {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 3%;
  }

  .notify-wrapper2 {
    color: darkgreen;
    text-align: left;
    margin-left: 15%;
    margin-bottom: 4.1%;
  }

  .operation-wrapper {
    float: right;
    padding-right: 18%;
    font-size: small;
    padding-top: 4px;
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
