<template>
	<div class="p-4 space-y-6 bg-white shadow rounded-xl">
	  <!-- 订单基本信息 -->
	  <section>
		<h2 class="text-xl font-semibold mb-4">Order Info</h2>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
		  <div><span class="font-medium">Order Number:</span> {{ order.id }}</div>
		  <div class="flex items-center space-x-2">
  <label class="font-medium text-sm text-gray-700">Status:</label>
  <select
    v-model="order.status"
    class="border rounded-md px-2 py-1 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
  >
    <option value="Pending">Pending</option>
    <option value="Processing">Processing</option>
    <option value="Shipped">Shipped</option>
    <option value="Delivered">Delivered</option>
    <option value="Cancelled">Cancelled</option>
  </select>
</div>

		  <div><span class="font-medium">Created At:</span> {{ order.created_at }}</div>
		  <div><span class="font-medium">Payment Method:</span> {{ order.payment_method }}</div>
		  <div><span class="font-medium">Total:</span> ${{ order.total }}</div>
		</div>
	  </section>
  
	  <!-- 商品信息 -->
	  <section>
		<h2 class="text-xl font-semibold mb-4">Products</h2>
		<table class="w-full table-auto border text-sm">
		  <thead>
			<tr class="bg-gray-100 text-left">
			  <th class="p-2 border">Product</th>
			  <th class="p-2 border">Quantity</th>
			  <th class="p-2 border">Price</th>
			  <th class="p-2 border">Subtotal</th>
			</tr>
		  </thead>
		  <tbody>
			<tr v-for="item in order.items" :key="item.id" class="hover:bg-gray-50">
			  <td class="p-2 border"><a :href="`/products/${item.product_id}`" class="text-blue-500 hover:underline">
              {{ item.name }}
            </a></td>
			  <td class="p-2 border">{{ item.quantity }}</td>
			  <td class="p-2 border">${{ item.price }}</td>
			  <td class="p-2 border">${{ item.quantity * item.price }}</td>
			</tr>
		  </tbody>
		</table>
	  </section>
  
	  <!-- 地址信息 -->
	  <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
		<div>
		  <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
		  <AddressForm v-model="order.shipping_address" />
		</div>
		<div>
		  <h2 class="text-xl font-semibold mb-4">Billing Address</h2>
		  <AddressForm v-model="order.billing_address" />
		</div>
	  </section>
  
	  <!-- 保存按钮 -->
	  <div class="flex justify-end">
		<button
		  class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md"
		  @click="saveOrder"
		>
		  Save Changes
		</button>
	  </div>
	</div>
  </template>
  
  <script setup>
  import { reactive } from 'vue'
  import AddressForm from './AddressForm.vue'
  
  const order = reactive({
	id: 'ORD-20230501-001',
	status: 'Processing',
	created_at: '2025-05-01 14:00',
	payment_method: 'Credit Card',
	total: 250.00,
	items: [
	  { id: 1, name: 'Product A', quantity: 2, price: 50 },
	  { id: 2, name: 'Product B', quantity: 1, price: 150 }
	],
	shipping_address: {
	  first_name: 'John',
	  last_name: 'Smith',
	  address1: '123 Main St',
	  city: 'Austin',
	  state: 'TX',
	  zip_code: '78701',
	  country: 'United States',
	  phone: '(555) 123-4567'
	},
	billing_address: {
	  first_name: 'John',
	  last_name: 'Smith',
	  address1: '123 Main St',
	  city: 'Austin',
	  state: 'TX',
	  zip_code: '78701',
	  country: 'United States',
	  phone: '(555) 123-4567'
	}
  })
  
  const saveOrder = () => {
	console.log('Saving order...', order)
	// 你可以发 POST 请求保存
  }
  </script>
  