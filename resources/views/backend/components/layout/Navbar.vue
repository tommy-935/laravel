<template>
    <header class="bg-white border-b border-gray-200">
      <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center">
          <button class="p-1 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
        
        <div class="flex items-center space-x-4">
          <div class="relative">
            <button class="p-1 rounded-full text-gray-500 hover:text-gray-600 hover:bg-gray-100">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
            </button>
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
          </div>
          
          <div class="relative">
            <button class="flex items-center space-x-2">
              <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/40" alt="User avatar">
              <span class="text-sm font-medium text-gray-700">Admin</span>
            </button>
          </div>
        </div>
      </div>
    </header>
  </template>
  
  <script setup>
  </script>