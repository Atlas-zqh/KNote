<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <div class="section-title-wrapper">
        <div style="float: left">
          <i class="el-icon-ali-edit_light"></i>
        </div>
        <div>
          <div style="float: left;padding-left: 2px">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item :to="{ path: '/profile/notes' }">2017游记</el-breadcrumb-item>
              <el-breadcrumb-item>大开眼界 Voir du pays (2016)</el-breadcrumb-item>
            </el-breadcrumb>
          </div>


          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-write" @click="jumpToWorkbench"></i>
          </el-button>
          <el-button type="text" class="operation-wrapper">
            <i class="el-icon-ali-delete" @click="deleteNote"></i>
          </el-button>
        </div>

      </div>

      <div class="note-content-wrapper" v-html="content"></div>
      <div class="note-info-wrapper">
        <div style="float: right;">
          <el-button v-if="!liked" size="large" @click="handleLike" class="like-button-wrapper">
            <i class="el-icon-ali-xihuan-xianxing"></i>
            {{likeCnt}}
          </el-button>
          <el-button v-else size="large" @click="cancelLike" class="like-button-wrapper">
            <i class="el-icon-ali-xihuan"></i>
            {{likeCnt}}
          </el-button>
        </div>
        <div>创建于: 2017/11/13 20:05</div>
        <div>更新于: 2017/11/13 20:05</div>
        <div>标签:
          <el-tag
            v-for="tag in tags"
            :key="tag.name"
            :closable="false"
            :type="tag.type"
          >
            {{tag.name}}
          </el-tag>
        </div>

      </div>

    </div>

  </div>

</template>

<script>
  import ElButton from '../../../../node_modules/element-ui/packages/button/src/button.vue'
  import router from '../../../router'

  export default {
    components: {ElButton},
    name: 'noteViewPane',
    data () {
      return {
        content: '<h1>大开眼界 Voir du pays (2016)</h1><p>我們常用思維定式去思想戰爭所帶來的景象，機槍、硝煙、哭嚎、鮮血、斷臂殘肢⋯從戰場上經歷了擦肩而過的死神，回家的腳步就沈重起來，見到家人不再是一種期盼而是找回真我的解脫途徑；每一個細微敏感的點都可能引起一系列心理不適的連鎖反應，戰後心靈創傷並不是依靠三天的紓壓假期就可以撫平的，但［為了避免脫下戰甲的丈夫回家殺死妻子」，形式走秀似得催眠士兵們遺忘他們的所見所聞。</p>' +
        '<p>撇除由戰爭帶來的暴力傾向，盲目自大的肌肉直男們對女性的侵害、團體中的不平等霸凌現象、職業族群間設定的假象敵等等，讓影片緊繃著一股強硬制衡，那種對立氣焰彷彿隨時會爆發。看似遠離了戰場，卻沒能走出危險危險的黑暗地帶；後半段著重描繪了這群註解脫離險境的軍人 同社會環境的難以融洽融入，當穿著軍裝隔離開性別特徵時的平等消失了，所取代的是男性大兵用自以為高高在上的姿態，挑釁當地人、放縱自我約束、欺凌弱勢者，甚至對已換上洋裝的失去抵抗力和威懾保護的女兵進行強暴性侵害。喪失良知和道德底線，已經不僅僅是Soko罵的「一群幼稚小孩子」能涵蓋的了，種種低品劣行很難將其與保衛國家和公民安全的戰士掛勾，然而這確是真實存在的症狀。</p>' +
        '<p>影片結尾，帶著詭異的氛圍，不再互相攀談的同伴們沈默地步入歸途，由一人發起而形成合唱著回家的思念之歌，女主壓抑的淚水終於瓦解潰堤⋯映後座談時聽說由於這部電影的演員採取的是專業藝人+退伍軍人模式，所以多數情感的真實性大大增加了精神負荷，片場也真的存在欺凌弱勢者的情況，影片內外都出於力量的薄弱無法改變現狀，才是最可怕的；跳脫出故事，或許她最後的眼淚包含了更多我們不知情的內容。</p>' +
        '<p>作為今年女性影展的第一部觀影，我長長呼出一口氣。但願影響所帶來的微薄影響多少能撼動一下這個殘酷無情的世界。</p>',
        likeCnt: 538,
        liked: false,
        tags: [
          {name: '标签一', type: 'warning'},
          {name: '标签二', type: 'warning'},
          {name: '标签三', type: 'warning'},
          {name: '标签四', type: 'warning'},
          {name: '标签五', type: 'warning'},
          {name: '标签六', type: 'warning'}
        ]
      }
    },
    methods: {
      handleLike () {
        this.liked = true
        this.likeCnt += 1
      },
      cancelLike () {
        this.liked = false
        this.likeCnt -= 1
      },
      deleteNote () {
        this.$confirm('确认删除该笔记 ?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$message({
            type: 'success',
            message: '删除成功!'
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          })
        })
      },
      jumpToWorkbench () {
        router.push('/workbench')
      }
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";
  @import "../../../assets/icon/iconfont.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: 8.7%;
    margin-right: 8.7%;
  }

  .section-title-wrapper {
    color: darkgreen;
    text-align: left;
    margin-bottom: 3%;
  }

  .el-breadcrumb {
    font-size: 16px;
    line-height: 1.45;
    /*padding-left: 200px;*/
  }

  .note-content-wrapper {
    margin-top: 40px;
    padding: 3% 3%;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(228, 241, 235, 0.11);
    word-break: break-all;
    text-align: left;
  }

  .note-info-wrapper {
    /*margin-top: 40px;*/
    padding: 3% 3%;
    margin-left: auto;
    margin-right: auto;
    background-color: rgba(228, 241, 235, 0.11);
    word-break: break-all;
    text-align: left;
    font-size: 14px;
    color: #2a8146;
  }

  .like-button-wrapper {
    color: #2a8146;
    margin-top: 20px;
  }

  .operation-wrapper {
    float: right;
    font-size: larger;
    padding-top: 3px;
  }

  .el-tag--warning {
    margin-right: 4px;
    margin-top: 2px;
  }
</style>
