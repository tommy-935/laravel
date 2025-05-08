<template>
    <div class="space-y-6">
      <h2 class="text-xl font-semibold">Notifications</h2>
  
      <div v-if="notifications.length === 0" class="text-gray-500 text-sm">
        You have no notifications.
      </div>
  
      <ul class="space-y-3">
        <li
          v-for="n in notifications"
          :key="n.id"
          :class="[
            'p-4 rounded-xl shadow bg-white flex justify-between items-start gap-4',
            n.read ? 'opacity-70' : 'border-l-4 border-blue-500'
          ]"
        >
          <div class="flex-1">
            <p class="text-sm text-gray-800">{{ n.message }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ formatTime(n.timestamp) }}</p>
          </div>
          <div class="flex flex-col items-end space-y-2">
            <button
              v-if="!n.read"
              @click="markAsRead(n.id)"
              class="text-xs text-blue-600 hover:underline"
            >
              Mark as Read
            </button>
            <button
              @click="removeNotification(n.id)"
              class="text-red-500 hover:text-red-700"
              title="Delete"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
              </svg>
            </button>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const notifications = ref([
    {
      id: 1,
      message: 'Your order #12345 has been shipped.',
      timestamp: '2025-05-07T14:32:00',
      read: false,
    },
    {
      id: 2,
      message: 'Password changed successfully.',
      timestamp: '2025-05-06T09:21:00',
      read: true,
    },
  ])
  
  const formatTime = (ts) => {
    const date = new Date(ts)
    return date.toLocaleString()
  }
  
  const markAsRead = (id) => {
    const item = notifications.value.find((n) => n.id === id)
    if (item) item.read = true
  }
  
  const removeNotification = (id) => {
    notifications.value = notifications.value.filter((n) => n.id !== id)
  }
  </script>
  