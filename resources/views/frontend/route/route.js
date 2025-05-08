import AccountLayout from '_@/views/frontend/account/components/AccountLayout.vue'

const frontendRoutes = [
  {
    path: '/account',
    component: AccountLayout,
    children: [
      { path: '', redirect: '/account/profile' },
      { path: 'profile', component: () => import('_@/views/frontend/account/components/Profile.vue') },
      { path: 'orders', component: () => import('_@/views/frontend/account/components/Orders.vue') },
      { path: 'orders/:id', component: () => import('_@/views/frontend/account/components/OrderDetail.vue') },
      { path: 'password', component: () => import('_@/views/frontend/account/components/ChangePassword.vue') },
      { path: 'addresses', component: () => import('_@/views/frontend/account/components/AddressBook.vue') },
      { path: 'notifications', component: () => import('_@/views/frontend/account/components/Notifications.vue') },
    ]
  }
]

export default frontendRoutes