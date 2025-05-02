<template>
    <div>
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Orders</h2>
      
      <DataTable
        :data="orders"
        :columns="columns"
        :search-fields="searchFields"
        @edit="editOrder"
        @delete="deleteOrder"
        @page-changed="orderStore.fetchOrders"
      />

      <Modal :show="showModal" @close="closeForm" width="960px">
        <OrderForm
          :product="selectedProduct"
          @cancel="closeForm"
          @submit="saveOrder"
        />
      </Modal>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue'
  import { useOrderStore } from '@/store/modules/order'
  import DataTable from '@/components/ui/DataTable.vue'
  import { useRouter } from 'vue-router'
  import Modal from '@/components/ui/Modal.vue'
  import OrderForm from './OrderForm.vue'
  
  const orderStore = useOrderStore()
  const router = useRouter()
  const showModal = ref(false)
  
  const columns = [
    { key: 'id', label: 'Order ID' },
    { key: 'order_num', label: 'Order Number' },
    { key: 'shipping_email', label: 'User' },
    { key: 'shipping_country', label: 'Country' },
    { key: 'total', label: 'Amount', render: (item) => `${item.currency + item.total}` },
    { key: 'status', label: 'Status' },
    { key: 'created_at', label: 'Added Date' }
  ]

  const closeForm = () => {
    showModal.value = false
  }
  
  const searchFields = ['id', 'user.name', 'status']
  
  const orders = computed(() => orderStore.orders)
  
  onMounted(() => {
    orderStore.fetchOrders(1)
  })
  
  const editOrder = (order) => {
    // router.push(`/orders/${order.id}`)
    showModal.value = true
  }

  const deleteOrder = async (order) => {
    if (confirm(`Delete "${order.order_num}"?`)) {
      await orderStore.deleteOrder(order.id)
    }
  }
  </script>