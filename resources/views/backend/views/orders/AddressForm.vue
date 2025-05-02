<template>
    <div class="space-y-3">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <input
          v-model="modelValue.first_name"
          placeholder="First Name"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input
          v-model="modelValue.last_name"
          placeholder="Last Name"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
  
      <input
        v-model="modelValue.address1"
        placeholder="Address"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
  
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <input
          v-model="modelValue.city"
          placeholder="City"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input
          v-model="modelValue.state"
          placeholder="State"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
  
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <input
          v-model="modelValue.zip_code"
          placeholder="Zip Code"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input
          v-model="modelValue.country"
          placeholder="Country"
          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
  
      <input
        v-model="modelValue.phone"
        placeholder="Phone"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
  
      <input
        v-model="modelValue.email"
        type="email"
        placeholder="Email"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
    </div>
  </template>
  
  <script setup>
  defineProps({
    modelValue: {
      type: Object,
      required: true
    }
  })
  
  defineEmits(['update:modelValue'])
  </script>
  