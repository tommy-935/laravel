<template>
	<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
	  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
		<h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Shopping Cart</h2>
  
		<div v-if="typeof cart.cartItems != 'undefined' ? (cart.cartItems.length > 0) : false" class="space-y-4">
		  <div v-for="(item, index) in cart.cartItems" :key="index" class="flex items-center justify-between border-b py-4">
			<div class="flex items-center space-x-4">
			  <img :src="item.product.product_img[0].attachment.uri" alt="Product Image" class="w-16 h-16 object-cover rounded" />
			  <div>
				<h3 class="text-lg font-semibold">{{ item.product.name }}</h3>
				<p class="text-gray-600">${{ item.price }}</p>
			  </div>
			</div>
			<div class="flex items-center space-x-2">
			  <button @click="decreaseQuantity(index)" class="px-2 py-1 bg-gray-300 rounded">-</button>
			  <span>{{ item.quantity }}</span>
			  <button @click="increaseQuantity(index)" class="px-2 py-1 bg-gray-300 rounded">+</button>
			  <button @click="removeItem(index)" class="ml-4 text-red-500 hover:text-red-700">🗑️</button>
			</div>
		  </div>
  
		  <div class="mt-6 text-right text-lg font-semibold">
			Total: ${{ totalPrice }}
		  </div>
  
		  <div class="mt-4">
			<label for="coupon" class="block text-sm font-medium text-gray-700">Coupon Code</label>
			<input
			  id="coupon"
			  v-model="couponCode"
			  type="text"
			  placeholder="Enter coupon code"
			  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
			/>
		  </div>
  
		  <button
			class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition mt-4"
			@click="proceedToCheckout"
		  >
			Proceed to Checkout
		  </button>
		</div>
  
		<div v-else class="text-center space-y-4">
		  <p class="text-gray-500 mb-4">Your cart is empty</p>
		  <router-link to="/">
			<button class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
			  Go to Homepage
			</button>
		  </router-link>
		</div>
	  </div>
	</div>
  </template>
  
  <script setup>
  import { ref, computed, watch } from 'vue';
  import { useStore } from 'vuex';
  const cart = ref({});
  const store = useStore();
  store.dispatch('getCart');
const cartItems = computed(() => store.state.cart.cart);
watch(cartItems, (newCart) => {
	cart.value = newCart;
}, { immediate: true });
console.log(cart);

  const couponCode = ref('');
  
  const increaseQuantity = (index) => {
	store.commit('cart/increaseQuantity', index);
  };
  
  const decreaseQuantity = (index) => {
	store.commit('cart/decreaseQuantity', index);
  };
  
  const removeItem = (index) => {
	store.commit('cart/removeItem', index);
  };
  
  const totalPrice = computed(() => {
	return cart.value.total;
  });
  
  const proceedToCheckout = () => {
	// Implement checkout logic here
	console.log('Proceeding to checkout with coupon code:', couponCode.value);
  };
  </script>
  