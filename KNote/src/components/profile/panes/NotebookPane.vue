<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <div class="cur-location-wrapper">
        <i class="el-icon-ali-file"></i>
        笔记本
      </div>
      <el-row class="notebook-row-wrapper" :gutter="50">
        <brief-notebook-card v-for="notebook in notebooks" :briefNotebook="notebook"></brief-notebook-card>
      </el-row>
      <div v-show="notebooks.length==0" class="text item">暂无笔记本</div>
    </div>
  </div>
</template>

<script>
  import router from '../../../router'
  import BriefNotebookCard from '../BriefNotebookCard.vue'
  import { mapActions, mapState } from 'vuex'

  export default {
    components: {BriefNotebookCard},
    name: 'notebookPane',
    data () {
      return {}
    },
    created () {
      this.fetchCurUserNotebooks({
        userId: this.userInfo[0].id,
        onSuccess: () => {},
        onError: (msg) => {
          this.$message.error(msg)
        }
      })
    },
    computed: {
      ...mapState('notebook', {
        notebooks: state => state.curUserNotebooks
      }),
      ...mapState('user', {
        userInfo: state => state.info
      })
    },
    methods: {
      ...mapActions('notebook', [
        'fetchCurUserNotebooks'
      ]),
      handleClick () {
        router.push('/profile/notes')
      }
    }
  }
</script>

<style scoped>
  @import "../../style/ProfileCurLocation.css";
  @import "../../../assets/icon/iconfont.css";
  @import "../../style/ProfilePaneOutWrapper.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: 8.7%;
    margin-right: 8.7%;
  }

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

  .notebook-row-wrapper {
    margin-bottom: 30px;
  }

</style>
