<template>
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input
        v-model="value"
        type="text"
        :placeholder="placeholder"
        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
      />
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  
  const props = defineProps({
    placeholder: {
      type: String,
      default: 'Search'
    },
    modelValue: {
      type: String,
      required: true
    }
  });
  const emit = defineEmits(['update:modelValue']);
  const value = computed({
    get: () => {
      return props.modelValue;
    },
    set: (val) => {
      emit('update:modelValue', val);
    }
  })
  </script>