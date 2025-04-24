<template>
    <div class="flex h-screen bg-gray-100">
      <Sidebar />
      
      <div class="flex-1 flex flex-col overflow-hidden">
        <Navbar />
        
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
          <router-view />
        </main>
      </div>
    </div>
  </template>
  
  <script>
  import Sidebar from './Sidebar.vue'
  import Navbar from './Navbar.vue'
  import { useRoute } from 'vue-router'
  
  export default {
    components: {
      Sidebar,
      Navbar
    },
    setup() {
      const route = useRoute()

      return {
        route
      }
    }
  }
  </script>