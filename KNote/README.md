# KNote

> A Vue.js project

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# run unit tests
npm run unit

# run e2e tests
npm run e2e

# run all tests
npm test
```

For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).

## Features

- 账户管理：用户账户删改查（管理员权限）
- 用户注册登录：注册账号，登陆，账户信息设置
- 笔记管理：笔记的增删改查（支持模糊搜索）
- 笔记本管理：笔记本的增删改查（支持模糊搜索）
- 用户管理：用户组之间相互关注 以及分享笔记及笔记本的读权限，写权限（bonus）
- 导入：图片，录音，文字等格式内容的导入。
- 网页截屏：网页剪辑插件保存网页选定区域，可添加高亮，箭头注释等标注。
- 标签管理：对笔记或笔记本添加标签描述，可通过标签搜索笔记。
- 保存笔记到本地：支持pdf下载。
- 朋友圈（笔记分享后支持点赞）：排名激励机制
- 拥有写权限的用户可同时编辑一个笔记，协同写作。
