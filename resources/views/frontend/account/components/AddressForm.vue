<template>
    <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-xl shadow w-full max-w-md relative">
        <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-500 hover:text-black">
          ✕
        </button>
  
        <h2 class="text-xl font-bold mb-4">
          {{ initialAddress ? 'Edit Address' : 'Add New Address' }}
        </h2>
  
        <form @submit.prevent="submit" class="space-y-4">
          <input v-model="form.name" type="text" placeholder="Name" class="w-full input" />
          <input v-model="form.phone" type="text" placeholder="Phone" class="w-full input" />
          <input v-model="form.street" type="text" placeholder="Street" class="w-full input" />
          <input v-model="form.city" type="text" placeholder="City" class="w-full input" />
          <input v-model="form.state" type="text" placeholder="State" class="w-full input" />
          <input v-model="form.zip" type="text" placeholder="ZIP Code" class="w-full input" />
  
          <button
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition"
          >
            Save
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue'
  import axios from 'axios'
  
  const props = defineProps({
    initialAddress: Object
  })
  const emit = defineEmits(['close', 'refresh'])
  
  const form = ref({
    name: '',
    phone: '',
    street: '',
    city: '',
    state: '',
    zip: ''
  })
  
  watch(() => props.initialAddress, (val) => {
    if (val) form.value = { ...val }
  }, { immediate: true })
  
  const submit = async () => {
    if (props.initialAddress) {
      await axios.put(`/api/account/addresses/${props.initialAddress.id}`, form.value)
    } else {
      await axios.post('/api/account/addresses', form.value)
    }
    emit('refresh')
    emit('close')
  }
  </script>
  
  <style scoped>
  .input {
    @apply border border-gray-300 px-4 py-2 rounded-lg;
  }
  </style>
  