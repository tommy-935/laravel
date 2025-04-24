<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl text-center">
        <h2 class="text-3xl font-bold text-green-600 mb-4">Order Placed Successfully!</h2>
        <p class="text-gray-700 mb-6">Thank you, {{ fullName }}! Your order has been confirmed.</p>
        
        <div class="text-lg font-semibold text-gray-800">Order Summary</div>
        <ul class="my-4 text-gray-600">
          <li v-for="(item, index) in cart" :key="index" class="mb-2">
            {{ item.name }} - ${{ item.price.toFixed(2) }} x {{ item.quantity }}
          </li>
        </ul>
        
        <div class="text-xl font-bold text-gray-800 mb-6">
          Total: ${{ totalPrice.toFixed(2) }}
        </div>
        
        <router-link to="/" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
          Back to Home
        </router-link>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const fullName = ref('John Doe'); // Mocked for the success page
  const cart = ref([
    { name: 'Product 1', price: 19.99, quantity: 1 },
    { name: 'Product 2', price: 29.99, quantity: 2 }
  ]);
  
  const totalPrice = computed(() => {
    return cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0);
  });
  </script>
  