<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">User Profile</h2>
        
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
          <p class="text-gray-600">Name: {{ user.name }}</p>
          <p class="text-gray-600">Email: {{ user.email }}</p>
        </div>
        
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800">My Orders</h3>
          <ul>
            <li v-for="order in orders" :key="order.id" class="border-b py-2">
              <span class="font-semibold">Order #{{ order.id }}</span> - ${{ order.total.toFixed(2) }}
              <button @click="viewOrder(order)" class="ml-4 text-blue-500">View Details</button>
            </li>
          </ul>
        </div>
        
        <div v-if="selectedOrder" class="mb-6">
          <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
          <p class="text-gray-600">Order ID: {{ selectedOrder.id }}</p>
          <p class="text-gray-600">Total: ${{ selectedOrder.total.toFixed(2) }}</p>
          <ul class="mt-2">
            <li v-for="item in selectedOrder.items" :key="item.name" class="text-gray-600">
              {{ item.name }} - ${{ item.price.toFixed(2) }} x {{ item.quantity }}
            </li>
          </ul>
          <button @click="selectedOrder = null" class="mt-2 text-red-500">Close</button>
        </div>
        
        <div>
          <h3 class="text-lg font-semibold text-gray-800">Change Password</h3>
          <input v-model="newPassword" type="password" placeholder="New Password" 
                 class="w-full px-4 py-2 border rounded-lg my-2" />
          <button @click="changePassword" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
            Update Password
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const user = ref({ name: 'John Doe', email: 'john@example.com' });
  const orders = ref([
    { id: 1, total: 49.99, items: [{ name: 'Product A', price: 19.99, quantity: 1 }, { name: 'Product B', price: 30, quantity: 1 }] },
    { id: 2, total: 29.99, items: [{ name: 'Product C', price: 29.99, quantity: 1 }] }
  ]);
  const selectedOrder = ref(null);
  const newPassword = ref('');
  
  const viewOrder = (order) => {
    selectedOrder.value = order;
  };
  
  const changePassword = () => {
    alert('Password updated successfully!');
  };
  </script>
  