<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-[240px_1fr] gap-8">

      <!-- Sidebar Navigation -->
      <aside class="bg-white rounded-2xl shadow p-4 space-y-4">
        <div class="text-xl font-semibold text-gray-800">My Account</div>
        <nav class="space-y-2">
          <button v-for="tab in tabs" :key="tab.key" @click="currentTab = tab.key"
            :class="[currentTab === tab.key ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100', 'w-full text-left px-4 py-2 rounded-lg transition']">
            {{ tab.label }}
          </button>
        </nav>
      </aside>

      <!-- Main Content -->
      <section class="bg-white rounded-2xl shadow p-6">
        <component :is="tabComponent" />
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import AccountInfo from './AccountInfo.vue'
import AccountOrders from './AccountOrders.vue'
import AccountOrderDetail from './AccountOrderDetail.vue'
import ChangePassword from './ChangePassword.vue'

const currentTab = ref('info')

const tabs = [
  { key: 'info', label: 'Personal Info' },
  { key: 'orders', label: 'My Orders' },
  { key: 'order-detail', label: 'Order Details' },
  { key: 'password', label: 'Change Password' },
  { key: 'address', label: 'Shipping Addresses' },
  { key: 'notifications', label: 'Notifications' }
]

const tabComponent = computed(() => {
  switch (currentTab.value) {
    case 'info': return AccountInfo
    case 'orders': return AccountOrders
    case 'order-detail': return AccountOrderDetail
    case 'password': return ChangePassword
    // You can add more here (e.g., address, wishlist, etc.)
    default: return AccountInfo
  }
})
</script>

<style scoped>
/* Optional: Styling tweaks */
</style>
