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
      }
    
];

const router = createRouter({
  history: createWebHistory(),  
  routes
});




export default router