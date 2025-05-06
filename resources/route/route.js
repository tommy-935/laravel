import { createRouter, createWebHistory, useRoute } from 'vue-router'

// 导入组件
import Home from '../views/pages/Home.vue'
import Register from '../views/pages/Register.vue'
import Login from '../views/pages/Login.vue'
import Categories from '../views/pages/Categories.vue'
import Product from '../views/pages/Product.vue'
import Cart from '../views/pages/Cart.vue'
import Checkout from '../views/pages/Checkout.vue'
import PrivacyPolicy from "../views/pages/PrivacyPolicy.vue"
import RefundPolicy from "../views/pages/RefundPolicy.vue"
import TermsConditions from "../views/pages/TermsConditions.vue"
import Aboutus from "../views/pages/Aboutus.vue"
import ForgotPassword from '../views/pages/ForgotPassword.vue'
import ResetPassword from '../views/pages/ResetPassword.vue'


const routes = [
	
	{
		path: '/',
		component: Home,
	  },
	  {
		path: '/register',
		name: 'Register',
		component: Register
	},
	{
		path: '/login',
		name: 'Login',
		component: Login
	},
	{
		path: '/forgot-password',
		name: 'ForgotPassword',
		component: ForgotPassword
	},
	{
		path: '/reset-password',
		name: 'ResetPassword',
		component: ResetPassword
	},
	{
		path: '/categories/:slug',
		name: 'Categories',
		component: Categories
	},
	{
		path: '/products/:handle',
		name: 'Product',
		component: Product
	}
	,
	{
		path: '/shipping-cart',
		name: 'Cart',
		component: Cart
	}
	,
	{
		path: '/checkout',
		name: 'Checkout',
		component: Checkout
	},
	{
		path: '/checkout/key/:key',
		name: 'Success',
		component: () => import('../views/pages/Success.vue')
	},
	{
		path: '/privacy-policy',
		name: 'PrivacyPolicy',
		component: PrivacyPolicy
	},
	{	
		path: '/refund-policy',
		name: 'RefundPolicy',
		component: RefundPolicy
	},
	{	
		path: '/terms-conditions',
		name: 'TermsConditions',
		component: TermsConditions
	},
	{	
		path: '/about-us',
		name: 'Aboutus',
		component: Aboutus
	},
	/*
	 use views/frontend/account  
	{	
		path: '/account',
		name: 'Account',
		component: Account
	},
	*/
]

const router = createRouter({
	history: createWebHistory(),  // 使用 HTML5 History 模式
	routes
});


export default router