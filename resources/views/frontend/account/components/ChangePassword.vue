<template>
    <div class="max-w-md bg-white rounded-xl ">
      <h1 class="text-2xl font-bold mb-4">Change Password</h1>
  
      <form @submit.prevent="submit">
        <div class="space-y-4">
          <!-- Current Password -->
          <div>
            <label class="block text-sm font-medium mb-1">Current Password</label>
            <input
              v-model="form.current_password"
              type="password"
              class="w-full border border-gray-300 rounded-lg px-4 py-2"
            />
            <p v-if="errors.current_password" class="text-sm text-red-500 mt-1">
              {{ errors.current_password }}
            </p>
          </div>
  
          <!-- New Password -->
          <div>
            <label class="block text-sm font-medium mb-1">New Password</label>
            <input
              v-model="form.new_password"
              type="password"
              class="w-full border border-gray-300 rounded-lg px-4 py-2"
            />
            <p v-if="errors.new_password" class="text-sm text-red-500 mt-1">
              {{ errors.new_password }}
            </p>
          </div>
  
          <!-- Confirm Password -->
          <div>
            <label class="block text-sm font-medium mb-1">Confirm New Password</label>
            <input
              v-model="form.new_password_confirmation"
              type="password"
              class="w-full border border-gray-300 rounded-lg px-4 py-2"
            />
            <p v-if="errors.new_password_confirmation" class="text-sm text-red-500 mt-1">
              {{ errors.new_password_confirmation }}
            </p>
          </div>
  
          <button
            type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
          >
            Change Password
          </button>
  
          <p v-if="successMessage" class="text-green-600 text-sm mt-2 text-center">
            {{ successMessage }}
          </p>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  import { useUserStore } from '_@/views/frontend/stores/user'
  import { useStore } from 'vuex'
  
  const userStore = useUserStore()
  const store = useStore()
  const form = ref({
    current_password: '',
    new_password: '',
    new_password_confirmation: ''
  })
  
  const errors = ref({})
  const successMessage = ref('')
  
  const submit = async () => {
    errors.value = {}
    successMessage.value = ''
  
    if (form.value.new_password !== form.value.new_password_confirmation) {
      errors.value.new_password_confirmation = 'Passwords do not match'
      return
    }
  
    try {
      const res = await userStore.changePassword(form.value)
      successMessage.value = 'Password updated successfully'
      form.value = { current_password: '', new_password: '', new_password_confirmation: '' }
    } catch (err) {
      if (err.response && err.response.data.errors) {
        errors.value = err.response.data.errors
      } else {
        errors.value.current_password = 'Incorrect current password'
      }
    }
  }
  </script>
  