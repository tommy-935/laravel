<template>
	<div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
		<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
			<h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Shipping Cart</h2>

			<div v-if="typeof cart.cartItems != 'undefined' ? (cart.cartItems.length > 0) : false" class="space-y-4">
				<div v-for="(item, index) in cart.cartItems" :key="index"
					class="flex justify-between items-center border-b py-4">
					<div>
						<h3 class="text-lg font-semibold">{{ item.product.name }}</h3>
						<p class="text-gray-600">${{ item.price }}</p>
					</div>
					<div class="flex items-center">
						<button @click="decreaseQuantity(index)" class="px-2 py-1 bg-gray-300 rounded">-</button>
						<span class="px-4">{{ item.quantity }}</span>
						<button @click="increaseQuantity(index)" class="px-2 py-1 bg-gray-300 rounded">+</button>
					</div>
				</div>
				<div class="mt-6 text-right text-lg font-semibold">
					Total: ${{ totalPrice }}
				</div>
				<a href="/checkout">
				<button
					class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition mt-4" href="/checkout">Checkout</button>
				</a>
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

/*
const cart = ref([
  { name: 'Product 1', price: 19.99, quantity: 1 },
  { name: 'Product 2', price: 29.99, quantity: 2 }
]);
*/
const cart = ref({});
const store = useStore();
store.dispatch('getCart');
const cartItems = computed(() => store.state.cart.cart);
watch(cartItems, (newCart) => {
	cart.value = newCart;
}, { immediate: true });
console.log(cart);

const increaseQuantity = (index) => {
	return ;
	cart.value[index].quantity++;
};

const decreaseQuantity = (index) => {
	return ;
	if (cart.value[index].quantity > 1) {
		cart.value[index].quantity--;
	} else {
		cart.value.splice(index, 1);
	}
};

const totalPrice = computed(() => {
	return cart.value.total;
});
</script>