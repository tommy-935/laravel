<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">My Orders</h1>
  
      <div v-if="orders.length === 0" class="text-gray-500">
        You haven’t placed any orders yet.
      </div>
  
      <div v-else class="space-y-4">
        <div
          v-for="order in orders"
          :key="order.id"
          class="border border-gray-200 rounded-lg p-4 shadow-sm bg-white"
        >
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
              <p class="text-gray-700 font-semibold">Order #{{ order.id }}</p>
              <p class="text-sm text-gray-500">Placed on {{ formatDate(order.created_at) }}</p>
            </div>
            <div class="mt-2 sm:mt-0 text-sm text-gray-600">
              Total: <span class="font-medium text-gray-800">${{ order.total }}</span>
            </div>
          </div>
  
          <div class="mt-4 text-right">
            <RouterLink
              :to="`/account/orders/${order.id}`"
              class="text-blue-600 hover:underline text-sm font-medium"
            >
              View Details →
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  
  const orders = ref([])
  
  const fetchOrders = async () => {
    const res = await axios.get('/api/account/orders')
    orders.value = res.data
  }
  
  const formatDate = (date) => {
    return new Date(date).toLocaleDateString()
  }
  
  onMounted(fetchOrders)
  </script>
  