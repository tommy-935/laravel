import { createRouter, createWebHistory } from 'vue-router'
import AccountLayout from '@/views/account/AccountLayout.vue'

const routes = [
  {
    path: '/account',
    component: AccountLayout,
    children: [
      { path: '', redirect: 'profile' },
      { path: 'profile', component: () => import('@/views/account/Profile.vue') },
      { path: 'orders', component: () => import('@/views/account/Orders.vue') },
      { path: 'orders/:id', component: () => import('@/views/account/OrderDetail.vue') },
      { path: 'password', component: () => import('@/views/account/ChangePassword.vue') },
      { path: 'addresses', component: () => import('@/views/account/AddressBook.vue') },
      { path: 'notifications', component: () => import('@/views/account/Notifications.vue') },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
