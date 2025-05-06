<template>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">My Addresses</h1>
        <button
          @click="openAddForm"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Add Address
        </button>
      </div>
  
      <div v-if="addresses.length === 0" class="text-gray-500">
        You haven't added any addresses yet.
      </div>
  
      <div v-else class="space-y-4">
        <div
          v-for="address in addresses"
          :key="address.id"
          class="border p-4 rounded-lg flex justify-between items-start"
        >
          <div>
            <p class="font-medium">{{ address.name }}</p>
            <p class="text-sm text-gray-600">{{ address.phone }}</p>
            <p class="text-sm text-gray-600">
              {{ address.street }}, {{ address.city }}, {{ address.state }}, {{ address.zip }}
            </p>
          </div>
          <div class="space-x-2">
            <button
              class="text-blue-600 hover:underline text-sm"
              @click="editAddress(address)"
            >
              Edit
            </button>
            <button
              class="text-red-600 hover:underline text-sm"
              @click="deleteAddress(address.id)"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
  
      <AddressForm
        v-if="showForm"
        :initial-address="editingAddress"
        @close="closeForm"
        @refresh="fetchAddresses"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'
  import AddressForm from './AddressForm.vue'
  
  const addresses = ref([])
  const showForm = ref(false)
  const editingAddress = ref(null)
  
  const fetchAddresses = async () => {
    const res = await axios.get('/api/account/addresses')
    addresses.value = res.data
  }
  
  const deleteAddress = async (id) => {
    if (confirm('Are you sure you want to delete this address?')) {
      await axios.delete(`/api/account/addresses/${id}`)
      fetchAddresses()
    }
  }
  
  const openAddForm = () => {
    editingAddress.value = null
    showForm.value = true
  }
  
  const editAddress = (address) => {
    editingAddress.value = address
    showForm.value = true
  }
  
  const closeForm = () => {
    showForm.value = false
  }
  
  onMounted(fetchAddresses)
  </script>
  