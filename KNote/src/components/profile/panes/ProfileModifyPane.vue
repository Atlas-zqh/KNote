<template>
  <div>
    <div class="profile-header-bkg">
      <div class="uploader-wrapper">
        <el-upload
          class="avatar-uploader"
          action="https://jsonplaceholder.typicode.com/posts/"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :before-upload="beforeAvatarUpload">
          <img v-if="imageUrl" :src="imageUrl" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </div>

    </div>

    <div class="pane-out-wrapper">
      <div class="pane-inner-wrapper">
        <el-form :label-position="labelPosition" :model="modifyInfo" :rules="modifyInfoRule" ref="infoForm"
                 label-width="100px">
          <el-form-item label="用户名" prop="username">
            <el-input type="text" v-model="modifyInfo.username" auto-complete="off">
            </el-input>
          </el-form-item>
          <el-form-item label="性别" prop="gender">
            <el-radio-group v-model="modifyInfo.gender">
              <el-radio label="男"></el-radio>
              <el-radio label="女"></el-radio>
              <el-radio label="保密"></el-radio>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="邮箱" prop="email">
            <el-input type="text" v-model="modifyInfo.email" :disabled="true" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item class="submit-button-wrapper">
            <el-button type="primary" @click="submitInfoForm('infoForm')">提交</el-button>
            <el-button @click="resetForm('infoForm')">重置</el-button>
          </el-form-item>
        </el-form>

        <el-form :label-position="labelPosition" :model="modifyPass" :rules="modifyPassRule" ref="passForm"
                 label-width="100px">
          <el-form-item label="原密码" prop="oldPass">
            <el-input type="password" v-model="modifyPass.oldPass" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="密码" prop="pass">
            <el-input type="password" v-model="modifyPass.pass" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="确认密码" prop="checkPass">
            <el-input type="password" v-model="modifyPass.checkPass" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item class="submit-button-wrapper">
            <el-button type="primary" @click="submitPassForm('passForm')">提交</el-button>
            <el-button @click="resetForm('passForm')">重置</el-button>
          </el-form-item>
        </el-form>
      </div>

    </div>
  </div>

</template>

<script>
  import ElFormItem from '../../../../node_modules/element-ui/packages/form/src/form-item.vue'
  import ElInput from '../../../../node_modules/element-ui/packages/input/src/input.vue'
  import ElRadio from '../../../../node_modules/element-ui/packages/radio/src/radio.vue'
  import ElForm from '../../../../node_modules/element-ui/packages/form/src/form.vue'
  import { mapActions } from 'vuex'

  export default {
    components: {
      ElForm,
      ElRadio,
      ElInput,
      ElFormItem
    },
    name: 'profileModifyPane',
    props: ['userInfo'],
    data () {
      var validateOldPass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入原密码'))
        } else {
          callback()
        }
      }
      var validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'))
        } else if (!/^(?![^a-zA-Z]+$)(?!\D+$)/.test(value) || value.length < 6) {
          callback(new Error('密码长度至少六位，且包含一个数字和一个字母'))
        } else {
          callback()
        }
      }
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'))
        } else if (value !== this.modifyPass.pass) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      }
      var validateUsername = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入用户名'))
        } else if (!/^[0-9A-z]+$/.test(value)) {
          callback(new Error('用户名只能包含大小写英文和数字'))
        } else {
          callback()
        }
      }

      return {
        labelPosition: 'top',
        imageUrl: '',
        modifyInfo: {
          gender: this.userInfo.gender,
          username: this.userInfo.name,
          email: this.userInfo.email

        },
        modifyInfoRule: {
          username: [
            {validator: validateUsername, trigger: 'blur'}
          ]
        },
        modifyPass: {
          pass: '',
          checkPass: '',
          oldPass: ''
        },
        modifyPassRule: {
          pass: [
            {validator: validatePass, trigger: 'blur'}
          ],
          checkPass: [
            {validator: validatePass2, trigger: 'blur'}
          ],
          oldPass: [
            {validator: validateOldPass, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleAvatarSuccess (res, file) {
        this.imageUrl = URL.createObjectURL(file.raw)
      },
      beforeAvatarUpload (file) {
        const isJPG = file.type === 'image/jpeg'
        const isLt2M = file.size / 1024 / 1024 < 2

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!')
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!')
        }
        return isJPG && isLt2M
      },
      submitInfoForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.editUserInfo({
              userInfo: this.modifyInfo,
              onSuccess: () => {
                this.$message({
                  message: '修改个人信息成功 😄',
                  type: 'success'
                })
              },
              onError: (msg) => {
                this.$refs[formName].resetFields()
                this.$message.error(msg)
              }
            })
          } else {
            this.$refs[formName].resetFields()
            this.$message.error('修改失败 🙁 请检查输入')
          }
        })
      },
      submitPassForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.editUserPass({
              password: this.modifyPass,
              onSuccess: () => {
                this.$refs[formName].resetFields()
                this.$message({
                  message: '修改密码成功 😄',
                  type: 'success'
                })
              },
              onError: (msg) => {
                this.$refs[formName].resetFields()
                this.$message.error(msg)
              }
            })
          } else {
            this.$refs[formName].resetFields()
            this.$message.error('修改失败 🙁 请检查输入')
          }
        })
      },
      resetForm (formName) {
        this.$refs[formName].resetFields()
      },
      ...mapActions('auth', [
        'editUserInfo', 'editUserPass'
      ])
    }
  }
</script>

<style scoped>
  @import "../../style/ProfilePaneOutWrapper.css";
  @import "../../../assets/icon/iconfont.css";

  .pane-inner-wrapper {
    padding-top: 5%;
    padding-bottom: 3%;
    margin-left: 30%;
    margin-right: 30%;
    text-align: left;
  }

  .profile-header-bkg {
    background-image: linear-gradient(to bottom, rgba(246, 246, 246, 0.7) 0%, rgba(246, 246, 246, 0.7) 100%), url('../../../assets/user-bkg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;

    width: 81%;
    min-width: 800px;
    height: 250px;
    margin-left: auto;
    margin-right: auto;
  }

  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .avatar-uploader .el-upload:hover {
    border-color: #20a0ff;
  }

  .avatar-uploader-icon {
    /*padding-top: 70%;*/
    font-size: 28px;
    color: rgba(238, 246, 242, 0);
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
    background-image: url("../../../assets/user-photo.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border-radius: 50%;
    box-shadow: #666666 2px 2px 2px;
  }

  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }

  .uploader-wrapper {
    padding-top: 120px;
  }

  .submit-button-wrapper {
    margin-top: 20px;
    text-align: center;
  }
</style>
