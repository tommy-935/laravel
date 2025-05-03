<template>
	<div class="p-4 space-y-6 bg-white shadow rounded-xl">
		<!-- 订单基本信息 -->
		<section>
			<h2 class="text-xl font-semibold mb-4">Order Info</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
				<div><span class="font-medium">Order Number:</span> {{ order.order_num }}</div>
				<div class="flex items-center space-x-2">
					<label class="font-medium text-sm text-gray-700">Status:</label>
					<select v-model="order.status"
						class="border rounded-md px-2 py-1 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
						<option value="pending">Pending</option>
						<option value="processing">Processing</option>
						<option value="shipped">Shipped</option>
						<option value="delivered">Delivered</option>
						<option value="cancelled">Cancelled</option>
					</select>
				</div>

				<div><span class="font-medium">Created At:</span> {{ order.created_at }}</div>
				<div><span class="font-medium">Payment Method:</span> {{ order.payment.payment_method }}</div>
				<div><span class="font-medium">Total:</span> ${{ order.price.total }}</div>
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
					<tr v-for="item in order.products" :key="item.id" class="hover:bg-gray-50">
						<td class="p-2 border"><a target="_blank" :href="`/products/${item.product.uri}`"
								class="text-blue-500 hover:underline">
								{{ item.product_name }}
							</a></td>
						<td class="p-2 border">{{ item.qty }}</td>
						<td class="p-2 border">${{ item.price }}</td>
						<td class="p-2 border">${{ item.item_price }}</td>
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
		<div class="flex justify-end space-x-3">
			<button type="button" @click="$emit('cancel')"
					class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
					Cancel
				</button>
				<button type="submit" @click="saveOrder"
					class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
					Save
				</button>
		</div>
	</div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import AddressForm from './AddressForm.vue'
import { useOrderStore } from '@/store/modules/order'

const emit = defineEmits(['cancel', 'close'])
const props = defineProps({
	id: {
		type: Number,
		default: 0
	}
})

const order = ref({
	order_num: '',
	status: 'processing',
	created_at: '2025-05-01 14:00',
	payment: {
		payment_method: 'Credit Card',
	},
	price: {
		total: 250.00,
	},
	products: [
		{ product_id: 1, product_name: 'Product A', qty: 2, price: 50, item_price: 100, product: {uri: ''} },
	],
	order_user: {
		shipping_first_name: 'John',
		shipping_last_name: 'Smith',
		shipping_address1: '123 Main St',
		shipping_address2: '123 Main St',
		shipping_city: 'Austin',
		shipping_state: 'TX',
		shipping_zip_code: '78701',
		shipping_country: 'United States',
		shipping_phone: '(555) 123-4567',
		shipping_email: '',
		billing_first_name: 'John',
		billing_last_name: 'Smith',
		billing_address1: '123 Main St',
		billing_address2: '123 Main St',
		billing_city: 'Austin',
		billing_state: 'TX',
		billing_zip_code: '78701',
		billing_country: 'United States',
		billing_phone: '(555) 123-4567',
		billing_email: '',
	},
	shipping_address: {
		first_name: 'John',
		last_name: 'Smith',
		address1: '123 Main St',
		address2: '123 Main St',
		city: 'Austin',
		state: 'TX',
		zip_code: '78701',
		country: 'United States',
		phone: '(555) 123-4567',
		email: ''
	},
	billing_address: {
		first_name: 'John',
		last_name: 'Smith',
		address1: '123 Main St',
		address2: '123 Main St',
		city: 'Austin',
		state: 'TX',
		zip_code: '78701',
		country: 'United States',
		phone: '(555) 123-4567',
		email: ''
	}
})

const store = useOrderStore()
const order_data =  store.getOrder(props.id).then((response) => {
	console.log('OrderForm mounted', response)
	order.value = response.data
	order.value.shipping_address = {
		first_name: order.value.order_user.shipping_first_name,
		last_name: order.value.order_user.shipping_last_name,
		address1: order.value.order_user.shipping_address1,
		address2: order.value.order_user.shipping_address2,
		city: order.value.order_user.shipping_city,
		state: order.value.order_user.shipping_state,
		zip_code: order.value.order_user.shipping_zip_code,
		country: order.value.order_user.shipping_country,
		phone: order.value.order_user.shipping_phone,
		email: order.value.order_user.shipping_email
	}
	order.value.billing_address = {
		first_name: order.value.order_user.billing_first_name,
		last_name: order.value.order_user.billing_last_name,
		address1: order.value.order_user.billing_address1,
		address2: order.value.order_user.billing_address2,
		city: order.value.order_user.billing_city,
		state: order.value.order_user.billing_state,
		zip_code: order.value.order_user.billing_zip_code,
		country: order.value.order_user.billing_country,
		phone: order.value.order_user.billing_phone,
		email: order.value.order_user.billing_email
	}
}).catch((error) => {
	console.error('Error fetching order data:', error)
})


const saveOrder = () => {
	console.log('Saving order...', order)
	store.updateOrder(order.value).then((response) => {
		console.log('Order updated successfully:', response)
		emit('close')
	}).catch((error) => {
		console.error('Error updating order:', error)
	})
}
</script>