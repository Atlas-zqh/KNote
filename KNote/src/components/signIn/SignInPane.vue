<template>
  <div>
    <modal name="sign-in"
           height="600"
           width="500"
           :clickToClose="false">

      <div class="sign-in-pane-wrapper">
        <div class="img-wrapper">
          <img src="../../assets/logo_with_word_vertical.png" class="vertical_logo"/>
        </div>
        <el-tabs v-model="activeName" @tab-click="handleClick">
          <el-tab-pane label="登录" name="sign-in">
            <div class="sign-in-form-wrapper">
              <el-form :model="ruleForm2" :rules="rules2" ref="ruleForm2" label-width="100px" class="ruleForm">
                <el-form-item label="用户名" prop="username">
                  <el-input v-model="ruleForm2.username" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="pass">
                  <el-input type="password" v-model="ruleForm2.pass" auto-complete="off"></el-input>
                </el-form-item>
                <div class="button-wrapper">
                  <el-form-item>
                    <el-button type="primary" @click="submitForm('ruleForm2')">提交</el-button>
                    <el-button @click="cancel('ruleForm2')">取消</el-button>
                  </el-form-item>
                </div>
              </el-form>
            </div>

          </el-tab-pane>
          <el-tab-pane label="注册" name="sign-up">
            <div class="sign-up-form-wrapper">
              <el-form :model="ruleForm2" :rules="rules2" ref="ruleForm2" label-width="100px" class="ruleForm">
                <el-form-item label="用户名" prop="username">
                  <el-input v-model="ruleForm2.username" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="pass">
                  <el-input type="password" v-model="ruleForm2.pass" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="确认密码" prop="checkPass">
                  <el-input type="password" v-model="ruleForm2.checkPass" auto-complete="off"></el-input>
                </el-form-item>
                <div class="button-wrapper">
                  <el-form-item>
                    <el-button type="primary" @click="submitForm('ruleForm2')">提交</el-button>
                    <el-button @click="cancel('ruleForm2')">取消</el-button>
                  </el-form-item>
                </div>
              </el-form>
            </div>
          </el-tab-pane>

        </el-tabs>

      </div>
    </modal>
  </div>
</template>

<script>
  import { Form, FormItem, Button, Tabs, TabPane } from 'element-ui'
  import ElInput from '../../../node_modules/element-ui/packages/input/src/input.vue'

  export default {
    name: 'signInPane',
    components: {
      ElInput,
      elForm: Form,
      elFormItem: FormItem,
      elButton: Button,
      elTabs: Tabs,
      elTabPane: TabPane
    },
    data () {
      var validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'))
        } else {
          if (this.ruleForm2.checkPass !== '') {
            this.$refs.ruleForm2.validateField('checkPass')
          }
          callback()
        }
      }
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'))
        } else if (value !== this.ruleForm2.pass) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      }

      var checkUserName = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入用户名'))
        } else {
          callback()
        }
      }

      return {
        activeName: 'sign-in',
        ruleForm2: {
          pass: '',
          checkPass: '',
          username: ''
        },
        rules2: {
          pass: [
            {validator: validatePass, trigger: 'blur'}
          ],
          checkPass: [
            {validator: validatePass2, trigger: 'blur'}
          ],
          username: [
            {validator: checkUserName, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      sign_up () {
        this.$modal.hide('sign-in')
      },
      submitForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            alert('submit!')
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      cancel (formName) {
        this.$refs[formName].resetFields()
        this.$modal.hide('sign-in')
      },

      handleClick (tab, event) {
        console.log(tab, event)
      }
    }
  }
</script>

<style scoped>
  .sign-in-pane-wrapper {
    width: 100%;
    height: 100%;
    padding: 45px;
    /*text-align: center ;*/
    /*padding-top: 330px;*/
    /*padding-left: 70px;*/
    background-image: linear-gradient(to top, #dfe9f3 0%, white 100%);
  }

  .img-wrapper {
    text-align: center;
    padding-top: 20px;
  }

  .sign-up-form-wrapper {
    padding-top: 30px;
    width: 90%;
    /*text-align: center;*/
  }

  .sign-in-form-wrapper {
    width: 90%;
    padding-top: 50px;
  }

  .sign-in-pane-wrapper .vertical_logo {
    width: 180px;
    height: 165px;
  }

  .button-wrapper {
    float: right;
  }

  .sign-in-pane-wrapper /deep/ .el-tabs__header {
    padding-top: 30px;
    width: 30%;
    margin: 0 auto;
    text-align: center;
  }


</style>
