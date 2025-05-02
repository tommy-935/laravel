<template>
    <div class="w-64 bg-gray-800 text-gray-100 flex flex-col">
      <div class="p-4 border-b border-gray-700">
        <h1 class="text-xl font-semibold">Admin Panel</h1>
      </div>
      
      <nav class="flex-1 overflow-y-auto">
        <div class="p-4">
          <ul class="space-y-2">
            <li>
              <router-link 
                to="/admin" 
                class="flex items-center p-2 rounded hover:bg-gray-700"
                active-class="bg-gray-700"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
              </router-link>
            </li>
            
            <li>
              <router-link 
                to="/admin/categories" 
                class="flex items-center p-2 rounded hover:bg-gray-700"
                active-class="bg-gray-700"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Categories
              </router-link>
            </li>
            
            <li>
              <router-link 
                to="/admin/products" 
                class="flex items-center p-2 rounded hover:bg-gray-700"
                active-class="bg-gray-700"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Products
              </router-link>
            </li>

            <li>
              <router-link 
                to="/admin/orders" 
                class="flex items-center p-2 rounded hover:bg-gray-700"
                active-class="bg-gray-700"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Orders
              </router-link>
            </li>
            
            <li>
              <router-link 
                to="/admin/users" 
                class="flex items-center p-2 rounded hover:bg-gray-700"
                active-class="bg-gray-700"
              >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Users
              </router-link>
            </li>
            
            
          </ul>
        </div>
      </nav>
    </div>
  </template>