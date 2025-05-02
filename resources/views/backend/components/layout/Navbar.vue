<template>
  <header class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-4 py-3">
      <div class="flex items-center">
        <button class="p-1 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <div class="flex items-center space-x-4">
        <!-- 通知按钮 -->
        <div class="relative">
          <button class="p-1 rounded-full text-gray-500 hover:text-gray-600 hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
          </button>
          <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
        </div>

        <!-- 用户头像 + 菜单 -->
        <div class="relative" ref="menuRef">
          <button class="flex items-center space-x-2" @click="toggleMenu">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
              <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 
                  1.79-4 4 1.79 4 4 4zm0 2c-2.67 
                  0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
              </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">Admin</span>
          </button>

          <!-- 动画菜单 -->
          <transition name="fade-scale">
            <div v-if="menuOpen"
              class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-10 origin-top-right">
              <a href="/profile"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
              <button @click="logout"
                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Logout
              </button>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useStore } from 'vuex'

const menuOpen = ref(false)
const menuRef = ref(null)
const store = useStore()

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}

const handleClickOutside = (event) => {
  if (menuRef.value && !menuRef.value.contains(event.target)) {
    menuOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})

const logout = () => {
  menuOpen.value = false
  store.dispatch('logout')
}
</script>

<style scoped>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.15s ease-out;
}
.fade-scale-enter-from {
  opacity: 0;
  transform: scale(95%);
}
.fade-scale-enter-to {
  opacity: 1;
  transform: scale(100%);
}
.fade-scale-leave-from {
  opacity: 1;
  transform: scale(100%);
}
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(95%);
}
</style>
