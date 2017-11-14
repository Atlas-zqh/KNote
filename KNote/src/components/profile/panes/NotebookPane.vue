<template>
  <div class="pane-out-wrapper">
    <div class="pane-inner-wrapper">
      <div class="cur-location-wrapper">
        <i class="el-icon-ali-file"></i>
        笔记本
      </div>
      <el-row class="notebook-row-wrapper" :gutter="50">
        <el-col :span="6">
          <div @click="handleClick">
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
      </el-row>
      <el-row class="notebook-row-wrapper" :gutter="50">
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
        <el-col :span="6">
          <div>
            <el-card>
              <div class="text item">
                <div class="notebook-name-wrapper">
                  {{noteBookTitle}}
                </div>
                <div class="notebook-info-wrapper">
                  共 {{noteCount}} 篇笔记
                </div>
                <div class="notebook-info-wrapper">
                  最新修改于
                </div>
                <div class="notebook-info-wrapper">
                  {{updateTime}}
                </div>
              </div>
            </el-card>
          </div>
        </el-col>
      </el-row>
    </div>
  </div>
</template>

<script>
  import router from '../../../router'

  export default {
    components: {},
    name: 'notebookPane',
    data () {
      return {
        noteBookTitle: '2017游记',
        noteCount: '20',
        updateTime: '2017/11/12 20:08'
      }
    },
    methods: {
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
