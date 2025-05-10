<template>
  <div v-if="isLoginPage || is404">
    <router-view />
  </div>
  <div v-else class="flex h-screen bg-gray-100">
    <Sidebar />
    <div class="flex-1 flex flex-col overflow-hidden">
      <Navbar />
      <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import Sidebar from './Sidebar.vue'
import Navbar from './Navbar.vue'

const route = useRoute()

const isLoginPage = computed(() => route.path === '/admin/login')
const is404 = computed(() => route.path === '/404')
</script>
