<template>
    <nav class="flex items-center space-x-2">
      <button
        @click="goToPage(currentPage - 1)"
        :disabled="currentPage === 1"
        class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Prev
      </button>
      
      <template v-for="page in pages" :key="page">
        <button
          v-if="page === '...'"
          disabled
          class="px-3 py-1 text-gray-500"
        >
          ...
        </button>
        <button
          v-else
          @click="goToPage(page)"
          :class="{
            'bg-blue-600 text-white': page === currentPage,
            'hover:bg-gray-100': page !== currentPage
          }"
          class="px-3 py-1 rounded-md text-sm font-medium"
        >
          {{ page }}
        </button>
      </template>
      
      <button
        @click="goToPage(currentPage + 1)"
        :disabled="currentPage === totalPages"
        class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Next
      </button>
    </nav>
  </template>
  
  <script setup>
  import { computed } from 'vue'
  
  const props = defineProps({
    currentPage: {
      type: Number,
      required: true
    },
    totalItems: {
      type: Number,
      required: true
    },
    perPage: {
      type: Number,
      default: 10
    }
  })
  
  const emit = defineEmits(['page-changed'])
  
  const totalPages = computed(() => Math.ceil(props.totalItems / props.perPage))
  
  const pages = computed(() => {
    const range = []
    const delta = 2
    const left = props.currentPage - delta
    const right = props.currentPage + delta + 1
    let prev = 0
  
    for (let i = 1; i <= totalPages.value; i++) {
      if (i === 1 || i === totalPages.value || (i >= left && i < right)) {
        if (prev !== i - 1) range.push('...')
        range.push(i)
        prev = i
      }
    }
  
    return range
  })
  
  const goToPage = (page) => {
    if (page < 1 || page > totalPages.value || page === props.currentPage) return
    emit('page-changed', page, props.currentPage)
  }
  </script>