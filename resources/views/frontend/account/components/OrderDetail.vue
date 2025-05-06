<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Order #{{ order.id }}</h1>
  
      <div class="bg-white rounded-lg p-6 shadow space-y-6">
        <!-- Order Info -->
        <div class="space-y-1 text-sm text-gray-600">
          <p><strong>Status:</strong> <span class="text-gray-800">{{ order.status }}</span></p>
          <p><strong>Placed on:</strong> {{ formatDate(order.created_at) }}</p>
          <p><strong>Total:</strong> ${{ order.total }}</p>
        </div>
  
        <!-- Shipping Info -->
        <div>
          <h2 class="text-lg font-semibold mb-2">Shipping Information</h2>
          <p class="text-sm text-gray-700">
            {{ order.shipping_name }}<br />
            {{ order.shipping_address }}<br />
            {{ order.shipping_phone }}
          </p>
        </div>
  
        <!-- Items -->
        <div>
          <h2 class="text-lg font-semibold mb-2">Items</h2>
          <div v-for="item in order.items" :key="item.id" class="flex items-center gap-4 border-t py-4">
            <img :src="item.image" class="w-16 h-16 object-cover rounded-lg" />
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-800">{{ item.name }}</p>
              <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
            </div>
            <div class="text-sm font-semibold text-gray-700">${{ item.total_price }}</div>
          </div>
        </div>
      </div>
  
      <RouterLink
        to="/account/orders"
        class="mt-6 inline-block text-sm text-blue-600 hover:underline"
      >
        ← Back to Orders
      </RouterLink>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import axios from 'axios'
  
  const route = useRoute()
  const order = ref({ id: '', items: [] })
  
  const fetchOrderDetail = async () => {
    const res = await axios.get(`/api/account/orders/${route.params.id}`)
    order.value = res.data
  }
  
  const formatDate = (date) => new Date(date).toLocaleDateString()
  
  onMounted(fetchOrderDetail)
  </script>
  