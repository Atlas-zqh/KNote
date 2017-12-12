<template>
  <div>
    <el-card class="box-card">
      <div v-if="hotNotes.length>0" v-for="note in this.hotNotes" :key="note.id" class="text item">
        <div @click="jumpToNoteDetail(note.id)">
          {{note.title}}
        </div>
      </div>
      <div class="text item" v-show="hotNotes.length == 0">
        暂无热门笔记
      </div>
    </el-card>
  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  import router from '../../router'

  export default {
    name: 'hotContent',
    data () {
      return {
        userId: this.$route.params.userId
      }
    },
    created () {
      this.fetchHotNotes(this.userId)
    },
    computed: {
      ...mapState('user', {
        hotNotes: state => state.hotNotes
      })
    },
    methods: {
      ...mapActions('user', [
        'fetchHotNotes'
      ]),
      jumpToNoteDetail (noteId) {
        router.push({name: 'noteview', params: {userId: this.userId, noteId: noteId}})
      }
    }
  }
</script>

<style scoped>
  @import "../../assets/icon/iconfont.css";

  .text {
    font-size: 14px;
    cursor: pointer;
  }

  .item {
    padding: 5px 0;
    text-align: left;
  }

  .box-card {
    width: 70%;
    margin-right: 15%;
    /*margin-bottom: 15%;*/
    float: right;
  }
</style>
