import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '@/views/Dashboard.vue'


const routes = [
  
    {
      path: '/admin',
      component: Dashboard,
    },
    
      {
        path: '/admin/categories',
        name: 'Categories',
        component: () => import('@/views/categories/CategoryList.vue')
      },
      {
        path: '/admin/login',
        name: 'AdminLogin',
        component: () => import('@/views/users/Login.vue')
      },
      {
        path: '/admin/products',
        name: 'Products',
        component: () => import('@/views/products/ProductList.vue')
      },
      {
        path: '/admin/users',
        name: 'Users',
        component: () => import('@/views/users/UserList.vue')
      },
      {
        path: '/admin/orders',
        name: 'Orders',
        component: () => import('@/views/orders/OrderList.vue')
      },
      {
        path: '/404',
        name: 'NotFound',
        component: () => import('@/views/NotFound.vue')
      }
      
    
];

const router = createRouter({
  history: createWebHistory(),  
  routes
});

router.beforeEach((to, from, next) => {
  const app_user = window.APP_USER;
  if (to.path.startsWith('/admin') && to.name !== 'AdminLogin') {
    if (app_user == null || app_user.roles[0].role_id !== "1") {
      return next({ name: 'NotFound' })  // 非管理员跳转登录页或错误页
    }
  }

  next()
})


export default router