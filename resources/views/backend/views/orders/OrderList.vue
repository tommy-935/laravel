<template>
    <div>
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Orders</h2>
      
      <DataTable
        :data="orders"
        :columns="columns"
        :search-fields="searchFields"
        @edit="editOrder"
        @add="showForm"
        @delete="deleteOrder"
        @page-changed="orderStore.fetchOrders"
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
    { key: 'order_num', label: 'Order Number' },
    { key: 'shipping_email', label: 'User' },
    { key: 'shipping_country', label: 'Country' },
    { key: 'total', label: 'Amount', render: (item) => `${item.currency + item.total}` },
    { key: 'status', label: 'Status' },
    { key: 'created_at', label: 'Added Date' }
  ]
  
  const searchFields = ['id', 'user.name', 'status']
  
  const orders = computed(() => orderStore.orders)
  
  onMounted(() => {
    orderStore.fetchOrders(1)
  })
  
  const editOrder = (order) => {
    // router.push(`/orders/${order.id}`)
  }

  const deleteOrder = async (order) => {
    if (confirm(`Delete "${order.order_num}"?`)) {
      await orderStore.deleteOrder(order.id)
    }
  }
  </script>