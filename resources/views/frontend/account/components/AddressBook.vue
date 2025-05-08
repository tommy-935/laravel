<template>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">Address Book</h2>
        <button @click="openForm" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
          Add New Address
        </button>
      </div>
  
      <div v-if="addresses.length === 0" class="text-gray-500 text-sm">
        You have no saved addresses.
      </div>
  
      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div v-for="address in addresses" :key="address.id" class="p-4 bg-white rounded-xl shadow space-y-2">
          <div>
            <p class="font-medium">{{ address.name }}</p>
            <p class="text-sm text-gray-600">{{ address.phone }}</p>
            <p class="text-sm text-gray-600">{{ address.full_address }}</p>
          </div>
          <div class="flex space-x-2 text-sm mt-2">
            <button @click="editAddress(address)" class="text-blue-600 hover:underline">Edit</button>
            <button @click="removeAddress(address.id)" class="text-red-600 hover:underline">Delete</button>
          </div>
        </div>
      </div>
  
      <!-- Modal Form -->
      <div v-if="showForm" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md space-y-4 shadow-lg">
          <h3 class="text-lg font-semibold">{{ editingAddress ? 'Edit Address' : 'Add New Address' }}</h3>
          <form @submit.prevent="saveAddress">
            <div class="space-y-3">
              <input
                v-model="form.name"
                type="text"
                placeholder="Full Name"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
              <input
                v-model="form.phone"
                type="text"
                placeholder="Phone Number"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
              <textarea
                v-model="form.full_address"
                placeholder="Full Address"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 h-24"
                required
              />
            </div>
            <div class="flex justify-end space-x-3 mt-4">
              <button @click.prevent="closeForm" class="px-4 py-2 text-gray-600 hover:text-black">Cancel</button>
              <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const addresses = ref([
    { id: 1, name: 'John Doe', phone: '1234567890', full_address: '123 Main St, Springfield' },
  ])
  
  const showForm = ref(false)
  const editingAddress = ref(null)
  const form = ref({ name: '', phone: '', full_address: '' })
  
  const openForm = () => {
    editingAddress.value = null
    form.value = { name: '', phone: '', full_address: '' }
    showForm.value = true
  }
  
  const closeForm = () => {
    showForm.value = false
  }
  
  const editAddress = (address) => {
    editingAddress.value = address
    form.value = { ...address }
    showForm.value = true
  }
  
  const saveAddress = () => {
    if (editingAddress.value) {
      Object.assign(editingAddress.value, form.value)
    } else {
      addresses.value.push({
        id: Date.now(),
        ...form.value,
      })
    }
    closeForm()
  }
  
  const removeAddress = (id) => {
    addresses.value = addresses.value.filter(a => a.id !== id)
  }
  </script>
  