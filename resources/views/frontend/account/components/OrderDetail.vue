<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Order #{{ order.order_num }}</h1>
  
      <div class="bg-white rounded-lg p-6 shadow space-y-6">
        <!-- Order Info -->
        <div class="space-y-1 text-sm text-gray-600">
          <p><strong>Status:</strong> <span class="text-gray-800">{{ order.status }}</span></p>
          <p><strong>Placed on:</strong> {{ formatDate(order.created_at) }}</p>
          <p><strong>Total:</strong> ${{ order.price.total }}</p>
        </div>
  
        <!-- Shipping Info -->
        <div>
          <h2 class="text-lg font-semibold mb-2">Shipping Information</h2>
          <p class="text-sm text-gray-700">
            <p>{{ order.order_user.shipping_first_name }}</p>
                <p>{{ order.order_user.shipping_address1 }}</p>
                <p>{{ order.order_user.shipping_city }}, {{ order.order_user.shipping_state }} {{ order.order_user.shipping_zip_ode }}</p>
                <p>{{ order.order_user.shipping_country }}</p>
                <p class="mt-2">Phone: {{ order.order_user.shipping_phone }}</p>
          </p>
        </div>
  
        <!-- Items -->
        <div>
          <h2 class="text-lg font-semibold mb-2">Items</h2>
          <div v-for="item in order.products" :key="item.id" class="flex items-center gap-4 border-t py-4">
            <img :src="'/storage/' + item.product.product_img[0].attachment.uri" class="w-16 h-16 object-cover rounded-lg" />
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-800">{{ item.product_name }}</p>
              <p class="text-sm text-gray-500">Qty: {{ item.qty }}</p>
            </div>
            <div class="text-sm font-semibold text-gray-700">${{ item.item_price }}</div>
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
  import { useUserStore } from '_@/views/frontend/stores/user'
  import { useStore } from 'vuex'
  
  const route = useRoute()
  const userStore = useUserStore()
  const store = useStore()
  const order = ref({ id: '', products: [], price: {}, order_user: {} })
  
  const fetchOrderDetail = async () => {
    const res = await userStore.fetchUserOrder({ key: route.params.key })
    order.value = res.data
  }
  
  const formatDate = (date) => new Date(date).toLocaleDateString()
  
  onMounted(fetchOrderDetail)
  </script>
  