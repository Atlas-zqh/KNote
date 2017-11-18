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
        <el-tabs v-model="activeName">
          <el-tab-pane label="登录" name="sign-in">
            <div class="sign-in-form-wrapper">
              <el-form :model="loginForm" :rules="loginRule" ref="loginForm" label-width="100px" class="ruleForm">
                <el-form-item label="邮箱" prop="loginEmail">
                  <el-input v-model="loginForm.loginEmail" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="loginPass">
                  <el-input type="password" v-model="loginForm.loginPass" auto-complete="off"></el-input>
                </el-form-item>
                <div class="button-wrapper">
                  <el-form-item>
                    <el-button type="primary" @click="submitLoginForm('loginForm')">登录</el-button>
                    <el-button @click="cancel('loginForm')">取消</el-button>
                  </el-form-item>
                </div>
              </el-form>
            </div>

          </el-tab-pane>
          <el-tab-pane label="注册" name="sign-up">
            <div class="sign-up-form-wrapper">
              <el-form :model="signUpForm" :rules="signUpRule" ref="signUpForm" label-width="100px" class="ruleForm">
                <el-form-item label="邮箱" prop="email">
                  <el-input v-model="signUpForm.email" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="用户名" prop="username">
                  <el-input v-model="signUpForm.username" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="pass">
                  <el-input type="password" v-model="signUpForm.pass" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="确认密码" prop="checkPass">
                  <el-input type="password" v-model="signUpForm.checkPass" auto-complete="off"></el-input>
                </el-form-item>

                <div class="button-wrapper">
                  <el-form-item>
                    <el-button type="primary" @click="submitRegisterForm('signUpForm')">注册</el-button>
                    <el-button @click="cancel('signUpForm')">取消</el-button>
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
        } else if (!/^(?![^a-zA-Z]+$)(?!\D+$)/.test(value) || value.length < 6) {
          callback(new Error('密码长度至少六位，且包含一个数字和一个字母'))
        } else {
          if (this.signUpForm.checkPass !== '') {
            this.$refs.signUpForm.validateField('checkPass')
          }
          callback()
        }
      }
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'))
        } else if (value !== this.signUpForm.pass) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      }

      var checkUserName = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入用户名'))
        } else if (!/^[0-9A-z]+$/.test(value)) {
          callback(new Error('用户名只能包含大小写英文和数字'))
        } else {
          callback()
        }
      }

      var checkEmail = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入邮箱'))
        } else if (!/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/.test(value)) {
          callback(new Error('电子邮箱格式不正确'))
        } else {
          callback()
        }
      }

      var checkLoginPass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'))
        } else if (!/^(?![^a-zA-Z]+$)(?!\D+$)/.test(value) || value.length < 6) {
          callback(new Error('密码长度至少六位，且包含一个数字和一个字母'))
        } else {
          callback()
        }
      }

      return {
        activeName: 'sign-in',
        signUpForm: {
          pass: '',
          checkPass: '',
          username: '',
          email: ''
        },
        signUpRule: {
          pass: [
            {validator: validatePass, trigger: 'blur'}
          ],
          checkPass: [
            {validator: validatePass2, trigger: 'blur'}
          ],
          username: [
            {validator: checkUserName, trigger: 'blur'}
          ],
          email: [
            {validator: checkEmail, trigger: 'blur'}
          ]
        },
        loginForm: {
          loginEmail: '',
          loginPass: ''
        },
        loginRule: {
          loginEmail: [
            {validator: checkEmail, trigger: 'blur'}
          ],
          loginPass: [
            {validator: checkLoginPass, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      submitLoginForm (formName) {
        this.$refs[formName].validate((valid) => {
          console.log(formName)
          console.log(this.loginForm.loginPass)
          console.log(this.loginForm.loginEmail)
          if (valid) {
            this.$message({
              message: '登录成功',
              type: 'success'
            })
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      submitRegisterForm (formName) {
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
//        console.log('close successfully')
        this.$modal.hide('sign-in')
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
    padding-top: 20px;
    width: 90%;
    /*text-align: center;*/
  }

  .sign-in-form-wrapper {
    width: 90%;
    padding-top: 70px;
  }

  .sign-in-pane-wrapper .vertical_logo {
    width: 180px;
    height: 165px;
  }

  .button-wrapper {
    float: right;
  }

  .sign-in-pane-wrapper /deep/ .el-tabs__header {
    padding-top: 15px;
    width: 30%;
    margin: 0 auto;
    text-align: center;
  }


</style>
