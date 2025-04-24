<template>
    <div>
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Orders</h2>
      
      <DataTable
        :data="orders"
        :columns="columns"
        :search-fields="searchFields"
        @edit="viewOrder"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue'
  import { useOrderStore } from '@/store/modules/order'
  import DataTable from '@/components/ui/DataTable.vue'
  import { useRouter } from 'vue-router'
  
  const orderStore = useOrderStore()
  const router = useRouter()
  
  const columns = [
    { key: 'id', label: 'Order ID' },
    { key: 'user.name', label: 'User' },
    { key: 'total_amount', label: 'Amount' },
    { key: 'status', label: 'Statue' },
    { key: 'created_at', label: 'Added Date' }
  ]
  
  const searchFields = ['id', 'user.name', 'status']
  
  const orders = computed(() => orderStore.orders)
  
  onMounted(() => {
    orderStore.fetchOrders()
  })
  
  const viewOrder = (order) => {
    router.push(`/orders/${order.id}`)
  }
  </script>