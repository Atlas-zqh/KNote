<template>
  <div class="foot">
    <br/>
    <h1 style="margin-top: 40px; font-size: 40px; margin-bottom: 15px">一起<br/>用KNote记录更多</h1>
    <el-button v-if="this.user==null" type="primary" style="margin-top: 0" @click="showSignInPane">快速登录</el-button>
    <el-button v-else type="primary" style="margin-top: 0" @click="jumpToWorkbench">进入工作台</el-button>
  </div>
</template>

<script>
  import ElButton from '../../../node_modules/element-ui/packages/button/src/button.vue'
  import { mapState } from 'vuex'
  import router from '../../router'

  export default {
    components: {ElButton},
    name: 'mainMediumBar',
    computed: {
      ...mapState('auth', {
        user: state => state.user
      })
    },
    methods: {
      jumpToWorkbench () {
        router.push({name: 'workbench', params: {userId: this.user.id}})
      },
      showSignInPane () {
        this.$modal.show('sign-in')
      }
    }
  }
</script>

<style scoped>
  .foot {
    width: 100%;
    height: 300px;
    background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
  }

</style>
