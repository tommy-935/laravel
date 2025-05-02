<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
          <!-- Mobile menu button (only on mobile) -->
          <div class="flex md:hidden">
            <button @click="toggleMobileMenu" class="text-gray-500 hover:text-green-600 focus:outline-none">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
          </div>
  
          <!-- Left side navigation -->
          <div class="flex items-center space-x-8">
            <!-- Logo with Homepage Link -->
          <div class="flex-shrink-0 mr-0 md:mr-8">
            <a href="/" class="text-2xl font-bold text-green-600 hover:text-green-700 transition-colors">
              LymosWP
            </a>
          </div>
  
            <!-- Primary navigation - desktop (hidden on mobile) -->
            <nav class="hidden md:flex space-x-6">
              <!-- Find Work dropdown -->
              <div class="relative">
                <div 
                  @mouseenter="openDropdown('findWork')" 
                  @mouseleave="startCloseTimer('findWork')"
                  class="relative h-full"
                >
                  <button class="flex items-center space-x-1 text-gray-700 hover:text-green-600 focus:outline-none h-full">
                    <span>wordpress</span>
                    <svg 
                      class="w-4 h-4 transition-transform duration-200" 
                      :class="{ 'rotate-180': activeDropdown === 'findWork' }"
                      fill="none" 
                      stroke="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </button>
                  <div 
                    v-show="activeDropdown === 'findWork'"
                    @mouseenter="cancelCloseTimer"
                    @mouseleave="startCloseTimer('findWork')"
                    class="absolute left-0 top-full mt-1 w-56 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-100 transition-opacity duration-200"
                    :class="{ 'opacity-100': activeDropdown === 'findWork', 'opacity-0': activeDropdown !== 'findWork' }"
                  >
                    <div class="px-4 py-2 border-b border-gray-100">
                      <span class="text-sm font-medium text-gray-500">wordpress</span>
                    </div>
                    <a v-if="false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Search</a>
                    <a v-if="false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Jobs</a>
                  </div>
                </div>
              </div>
  
              <!-- Deliver Work dropdown -->
              <div class="relative">
                <div 
                  @mouseenter="openDropdown('deliverWork')" 
                  @mouseleave="startCloseTimer('deliverWork')"
                  class="relative h-full"
                >
                  <button class="flex items-center space-x-1 text-gray-700 hover:text-green-600 focus:outline-none h-full">
                    <span>shopify</span>
                    <svg 
                      class="w-4 h-4 transition-transform duration-200" 
                      :class="{ 'rotate-180': activeDropdown === 'deliverWork' }"
                      fill="none" 
                      stroke="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </button>
                  <div 
                    v-show="activeDropdown === 'deliverWork'"
                    @mouseenter="cancelCloseTimer"
                    @mouseleave="startCloseTimer('deliverWork')"
                    class="absolute left-0 top-full mt-1 w-56 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-100 transition-opacity duration-200"
                    :class="{ 'opacity-100': activeDropdown === 'deliverWork', 'opacity-0': activeDropdown !== 'deliverWork' }"
                  >
                    <div class="px-4 py-2 border-b border-gray-100">
                      <span class="text-sm font-medium text-gray-500">shopify</span>
                    </div>
                    <a v-if="false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Manage financial</a>
                    <a v-if="false" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Messages</a>
                  </div>
                </div>
              </div>
  
              <!-- Financial Overview dropdown -->
              <div class="relative">
                <div 
                  @mouseenter="openDropdown('financial')" 
                  @mouseleave="startCloseTimer('financial')"
                  class="relative h-full"
                >
                  <button class="flex items-center space-x-1 text-gray-700 hover:text-green-600 focus:outline-none h-full">
                    <span>support</span>
                    <svg 
                      class="w-4 h-4 transition-transform duration-200" 
                      :class="{ 'rotate-180': activeDropdown === 'financial' }"
                      fill="none" 
                      stroke="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </button>
                  <div v-if="false"
                    v-show="activeDropdown === 'financial'"
                    @mouseenter="cancelCloseTimer"
                    @mouseleave="startCloseTimer('financial')"
                    class="absolute left-0 top-full mt-1 w-64 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-100 transition-opacity duration-200"
                    :class="{ 'opacity-100': activeDropdown === 'financial', 'opacity-0': activeDropdown !== 'financial' }"
                  >
                    <div class="px-4 py-2 border-b border-gray-100">
                      <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-500">Financial Overview</span>
                        <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded-full">Action required</span>
                      </div>
                    </div>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Your reports</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Billings and earnings</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600">Transactions and invoices</a>
                  </div>
                </div>
              </div>
            </nav>
          </div>
  
          <!-- Right side buttons -->
          <div class="flex items-center space-x-4">
            <!-- Search input (visible when searchActive) -->
            <div v-if="searchActive" class="relative hidden md:block">
              <input 
                type="text" 
                placeholder="Search..." 
                class="pl-4 pr-10 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                v-model="searchQuery"
                @keyup.enter="performSearch"
              >
              <button @click="toggleSearch" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
  
            <!-- Search button (visible when not searchActive) -->
            <button v-else @click="toggleSearch" class="text-gray-500 hover:text-green-600 hidden md:block">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
  
            <!-- Conditional rendering based on login state -->
            <template v-if="isLoggedIn && false">
              <!-- User avatar dropdown -->
              <div class="relative">
                <div 
                  @mouseenter="openDropdown('user')" 
                  @mouseleave="startCloseTimer('user')"
                  class="relative"
                >
                  <button class="flex items-center space-x-1 focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium">
                      {{ userInitials }}
                    </div>
                  </button>
                  <div 
                    v-show="activeDropdown === 'user'"
                    @mouseenter="cancelCloseTimer"
                    @mouseleave="startCloseTimer('user')"
                    class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-100 transition-opacity duration-200"
                    :class="{ 'opacity-100': activeDropdown === 'user', 'opacity-0': activeDropdown !== 'user' }"
                  >
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                  </div>
                </div>
              </div>
            </template>
            <template v-else>
              <!-- Login/Register buttons -->
              <a v-if="false" href="#" class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-green-600 hidden sm:block">Log In</a>
              <a v-if="false" href="#" class="px-3 py-1.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md hidden sm:block">Sign Up</a>
            </template>
          </div>
        </div>
      </div>
  
      <!-- Mobile menu overlay (shown when mobileMenuOpen) -->
      <transition name="fade">
        <div v-show="mobileMenuOpen" class="fixed inset-0 z-40 md:hidden">
          <!-- Overlay background -->
          <div class="absolute inset-0 bg-black bg-opacity-50" @click="toggleMobileMenu"></div>
          
          <!-- Mobile menu panel -->
          <div class="absolute top-0 left-0 h-full w-4/5 max-w-sm bg-white shadow-lg transform transition-transform duration-300 ease-in-out" :class="{ 'translate-x-0': mobileMenuOpen, '-translate-x-full': !mobileMenuOpen }">
            <div class="flex flex-col h-full overflow-y-auto">
              <!-- Mobile menu header -->
              <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                <span class="text-xl font-bold text-green-600">LymosWP</span>
                <button @click="toggleMobileMenu" class="text-gray-500 hover:text-green-600 focus:outline-none">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
  
              <!-- Mobile menu content -->
              <div class="flex-1 px-4 py-3 space-y-2">
                <!-- Search input for mobile -->
                <div class="relative mb-4">
                  <input 
                    type="text" 
                    placeholder="Search..." 
                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    v-model="searchQuery"
                    @keyup.enter="performSearch"
                  >
                  <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                  </button>
                </div>
  
                <!-- Mobile menu items -->
                <div class="space-y-1">
                  <button @click="toggleMobileDropdown('findWork')" class="w-full flex justify-between items-center px-3 py-2 text-left text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>wordpress</span>
                    <svg 
                      class="w-4 h-4 transform transition-transform duration-200" 
                      :class="{ 'rotate-180': mobileDropdownOpen === 'findWork' }"
                      fill="none" 
                      stroke="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </button>
                  <div v-if="false" v-show="mobileDropdownOpen === 'findWork'" class="ml-4 space-y-1">
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Search</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Jobs</a>
                  </div>
  
                  <button @click="toggleMobileDropdown('deliverWork')" class="w-full flex justify-between items-center px-3 py-2 text-left text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>shopify</span>
                    <svg 
                      class="w-4 h-4 transform transition-transform duration-200" 
                      :class="{ 'rotate-180': mobileDropdownOpen === 'deliverWork' }"
                      fill="none" 
                      stroke="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </button>
                  <div v-if="false" v-show="mobileDropdownOpen === 'deliverWork'" class="ml-4 space-y-1">
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Manage financial</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Messages</a>
                  </div>
  
                  <button @click="toggleMobileDropdown('financial')" class="w-full flex justify-between items-center px-3 py-2 text-left text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>support</span>
                    <svg 
                      class="w-4 h-4 transform transition-transform duration-200" 
                      :class="{ 'rotate-180': mobileDropdownOpen === 'financial' }"
                      fill="none" 
                      stroke="currentColor" 
                      viewBox="0 0 24 24" 
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </button>
                  <div v-if="false" v-show="mobileDropdownOpen === 'financial'" class="ml-4 space-y-1">
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Your reports</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Billings and earnings</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Transactions and invoices</a>
                  </div>
                </div>
              </div>
  
              <!-- Mobile login/signup buttons -->
              <div v-if="!isLoggedIn" class="px-4 py-3 border-t border-gray-200">
                <div class="flex space-x-2">
                  <a href="#" class="flex-1 px-3 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">Log In</a>
                  <a href="#" class="flex-1 px-3 py-2 text-center text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">Sign Up</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </header>
    <CookieBanner v-if="false" />
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import CookieBanner from './CookieBanner.vue';
  
  // User state
  const isLoggedIn = ref(true);
  const user = ref({
    name: 'John Doe',
    email: 'john@example.com'
  });
  
  // UI state
  const activeDropdown = ref(null);
  const mobileMenuOpen = ref(false);
  const mobileDropdownOpen = ref(null);
  const searchActive = ref(false);
  const searchQuery = ref('');
  let closeTimer = null;
  
  // Compute user initials for avatar
  const userInitials = computed(() => {
    if (!user.value.name) return '?';
    return user.value.name.split(' ').map(n => n[0]).join('').toUpperCase();
  });
  
  // Dropdown functions
  const openDropdown = (name) => {
    cancelCloseTimer();
    activeDropdown.value = name;
  };
  
  const startCloseTimer = (name) => {
    closeTimer = setTimeout(() => {
      if (activeDropdown.value === name) {
        activeDropdown.value = null;
      }
    }, 150); // Reduced delay for better responsiveness
  };
  
  const cancelCloseTimer = () => {
    if (closeTimer) {
      clearTimeout(closeTimer);
      closeTimer = null;
    }
  };
  
  const toggleMobileDropdown = (name) => {
    mobileDropdownOpen.value = mobileDropdownOpen.value === name ? null : name;
  };
  
  const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
    if (!mobileMenuOpen.value) {
      mobileDropdownOpen.value = null;
    }
  };
  
  // Search functions
  const toggleSearch = () => {
    searchActive.value = !searchActive.value;
    if (!searchActive.value) {
      searchQuery.value = '';
    }
  };
  
  const performSearch = () => {
    if (searchQuery.value.trim()) {
      console.log('Searching for:', searchQuery.value);
      // Implement your search logic here
    }
  };
  </script>
  
  <style scoped>
  /* Smooth transitions */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  
  /* Dropdown menu styling */
  .dropdown-enter-active,
  .dropdown-leave-active {
    transition: all 0.2s ease;
  }
  .dropdown-enter-from,
  .dropdown-leave-to {
    opacity: 0;
    transform: translateY(-5px);
  }
  
  /* Arrow icon transition */
  .rotate-180 {
    transform: rotate(180deg);
  }
  </style>