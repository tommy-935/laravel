<template>
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
      <div class="grid grid-cols-1 md:grid-cols-[250px_1fr] gap-6">
        <!-- Sidebar -->
        <aside class="bg-white rounded-2xl shadow p-4 space-y-2">
          <h2 class="text-xl font-semibold mb-4">My Account</h2>
          <nav class="space-y-2 text-sm">
            <RouterLink
              v-for="link in links"
              :key="link.path"
              :to="link.path"
              class="block px-3 py-2 rounded-md hover:bg-gray-100"
              :class="{ 'bg-blue-50 text-blue-600 font-medium': $route.path.includes(link.path) }"
            >
              {{ link.label }}
            </RouterLink>
          </nav>
        </aside>
  
        <!-- Main Content -->
        <section class="bg-white rounded-2xl shadow p-6 min-h-[500px]">
          <RouterView />
        </section>
      </div>
    </div>
  </template>
  
  <script setup>
  const links = [
    { label: 'Profile', path: '/account/profile' },
    { label: 'Orders', path: '/account/orders' },
    { label: 'Addresses', path: '/account/addresses' },
    { label: 'Notifications', path: '/account/notifications' },
    { label: 'Change Password', path: '/account/password' }
  ]
  </script>
  