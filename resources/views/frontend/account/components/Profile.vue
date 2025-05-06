<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Profile</h1>
  
      <form @submit.prevent="updateProfile" class="space-y-4 max-w-lg">
        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input v-model="form.name" type="text" class="mt-1 w-full border px-4 py-2 rounded-lg" />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input v-model="form.email" type="email" class="mt-1 w-full border px-4 py-2 rounded-lg" />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input v-model="form.phone" type="text" class="mt-1 w-full border px-4 py-2 rounded-lg" />
        </div>
  
        <button
          type="submit"
          class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Save Changes
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useUserStore } from '@/stores/user'
  
  const userStore = useUserStore()
  const form = ref({ name: '', email: '', phone: '' })
  
  onMounted(async () => {
    await userStore.fetchUserProfile()
    form.value = { ...userStore.profile }
  })
  
  const updateProfile = async () => {
    await userStore.updateUserProfile(form.value)
    alert('Profile updated successfully!')
  }
  </script>
  