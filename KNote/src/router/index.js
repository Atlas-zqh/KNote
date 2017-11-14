import Vue from 'vue'
import Router from 'vue-router'
import MainPage from '@/pages/MainPage.vue'
import workbench from '@/pages/Workbench.vue'
import userProfile from '@/pages/UserProfile.vue'
import notebooks from '@/pages/Notebooks.vue'
import friendsPage from '@/pages/Friends.vue'
import profileNotes from '@/pages/ProfileNotes.vue'
import noteView from '@/pages/NoteView.vue'
import profileEdit from '@/pages/ProfileEdit.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'MainPage',
      component: MainPage
    },
    {
      path: '/workbench',
      name: 'workbench',
      component: workbench
    },
    {
      path: '/profile',
      name: 'userProfile',
      component: userProfile
    },
    {
      path: '/profile/notebooks',
      name: 'notebooks',
      component: notebooks
    },
    {
      path: '/profile/notes',
      name: 'notes',
      component: profileNotes
    },
    {
      path: '/profile/friends',
      name: 'friends',
      component: friendsPage
    },
    {
      path: '/profile/noteview',
      name: 'noteview',
      component: noteView
    },
    {
      path: '/profile/edit',
      name: 'profileEdit',
      component: profileEdit
    }
  ]
})
