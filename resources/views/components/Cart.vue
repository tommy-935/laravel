<template v-if="!isCartLoaded">
	<div class="max-w-7xl mx-auto p-4 sm:p-6">
		<!-- Login Prompt -->
		<div v-if="!isLoggedIn" class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded-lg mb-6 text-sm">
			Please log in to save your cart and use coupons.
			<button @click="login" class="ml-4 underline text-blue-600 hover:text-blue-800">Log In</button>
		</div>

		<h1 class="text-2xl sm:text-3xl font-bold mb-6">Shopping Cart</h1>

		<!-- Empty Cart Block -->
		<div v-if="isCartLoaded && !cart.cartItems?.length" class="text-center py-16 bg-white rounded-2xl shadow">
			<svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
			stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
				d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.293 4.293A1 1 0 007 18h10a1 1 0 00.97-.757L20 13M9 21h6" />
			</svg>
			<p class="text-lg font-semibold mb-2">Your cart is empty</p>
			<p class="text-gray-500 mb-4">Looks like you haven't added anything yet.</p>
			<a href="/" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
			Continue Shopping
			</a>
		</div>

		<!-- Responsive Layout -->
		<div class="flex flex-col lg:flex-row gap-8" v-if="isCartLoaded && cart.cartItems?.length">
			<!-- Cart Items -->
			<div class="flex-1 space-y-4">
				<div v-for="item in cart.cartItems" :key="item.id"
					class="grid grid-cols-1 min-[500px]:grid-cols-[auto_12rem_auto_auto_auto] items-start gap-4 bg-white p-4 rounded-2xl shadow text-left">
					<!-- Image -->
					<img :src="'/storage/' + item.product.product_img[0].attachment.uri" alt=""
						class="w-20 h-20 object-cover rounded-xl" />

					<!-- Product Info (Fixed width) -->
					<div class="w-48">
						<h2 class="text-base sm:text-lg font-semibold truncate">{{ item.product.name }}</h2>
						<p class="text-sm text-gray-500">${{ item.price }}</p>
					</div>

					<!-- Quantity Controls -->
					<div v-if="showQuantityControl" class="flex flex-col items-start">
						<div class="flex items-center space-x-2">
							<button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
								@click="decreaseQuantity(item)" :disabled="item.quantity === 1">-</button>
							<span class="w-6 text-center">{{ item.quantity }}</span>
							<button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
								@click="increaseQuantity(item)">+</button>
						</div>
					</div>

					<!-- Total Price -->
					<div class="text-left font-medium text-gray-800">
						${{ item.price * item.quantity }}
					</div>

					<!-- Delete Button -->
					<button class="text-red-500 hover:text-red-700" @click="removeItem(item)">
						<!-- Trash Icon -->
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
						</svg>
					</button>
				</div>
			</div>

			<!-- Cart Summary -->
			<div class="w-full lg:w-[400px] shrink-0">
				<div class="bg-white rounded-2xl p-6 shadow space-y-6">
					<!-- Coupon Input -->
					<div v-if="false" class="flex flex-col sm:flex-row sm:items-end gap-4">
						<div class="flex-1">
							<label class="block mb-1 text-sm font-medium text-gray-700">Coupon Code</label>
							<input v-model="couponCode" class="w-full border border-gray-300 rounded-lg px-4 py-2"
								placeholder="Enter coupon code" />
							<p v-if="couponFeedback" class="text-sm mt-1 text-green-600">{{ couponFeedback }}</p>
							<p v-if="invalidCoupon" class="text-sm mt-1 text-red-600">Invalid coupon code</p>
						</div>
						<button @click="applyCoupon"
							class="h-10 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
							Apply
						</button>
					</div>

					<!-- Price Breakdown -->
					<div class="text-sm space-y-2">
						<div class="flex justify-between">
							<span>Subtotal</span>
							<span>${{ subtotal }}</span>
						</div>
						<div class="flex justify-between">
							<span>Shipping</span>
							<span>${{ shippingFee }}</span>
						</div>
						<div class="flex justify-between">
							<span>Tax ({{ (taxRate * 100).toFixed(0) }}%)</span>
							<span>${{ taxAmount }}</span>
						</div>
						<hr />
						<div class="flex justify-between text-lg font-semibold">
							<span>Total</span>
							<span class="text-blue-600">${{ cart.total }}</span>
						</div>
					</div>

					<!-- Checkout Button -->
					<a href="/checkout"><button
							class="w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition cursor-pointer">
							Proceed to Checkout
						</button></a>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useStore } from 'vuex'
const store = useStore()
const cart = ref({});
const isCartLoaded = ref(false)
// Login State
const isLoggedIn = ref(true)
const login = () => {
	isLoggedIn.value = true
	alert('You are now logged in.')
}

store.dispatch('getCart');
const cartItems = computed(() => store.state.cart.cart);
watch(cartItems, (newCart) => {
	cart.value = newCart;
	isCartLoaded.value = true

}, { immediate: true });

const increaseQuantity = (item) => { 
	item.quantity++
	tiggerUpdate(item)
}
const decreaseQuantity = (item) => { 
	if (item.quantity > 1) {
		item.quantity-- 
		tiggerUpdate(item)
	}
}
const tiggerUpdate = (item) => {
	store.commit('setLoading', true);
	store.dispatch('update', {item_key: item.item_key, quantity: item.quantity})
};

const removeItem = (item) => {
	// loading
	store.commit('setLoading', true);
	store.dispatch('remove', {item_key: item.item_key})
	// store.dispatch('getCart');
	// store.dispatch('updateCart', cart.value)
}
const showQuantityControl = true

// Pricing
const subtotal = computed(() =>
	cart.value.total
)
const shippingFee = ref(0)


const taxRate = ref(0)
const taxAmount = computed(() => subtotal.value * taxRate.value)

// Coupons
const couponCode = ref('')
const couponFeedback = ref('')
const invalidCoupon = ref(false)
const validCoupons = { SAVE10: 0.1, SAVE20: 0.2 }
const discountRate = ref(0)

const applyCoupon = () => {
	const upper = couponCode.value.trim().toUpperCase()
	if (validCoupons[upper]) {
		discountRate.value = validCoupons[upper]
		couponFeedback.value = `Coupon applied: ${upper} (-${validCoupons[upper] * 100}%)`
		invalidCoupon.value = false
	} else {
		discountRate.value = 0
		couponFeedback.value = ''
		invalidCoupon.value = true
	}
}

// Final Total
const finalTotal = computed(() => {
	const discounted = subtotal.value * (1 - discountRate.value)
	return discounted + shippingFee.value + taxAmount.value
})
</script>