<template>
    <div v-if="loading" class="fixed inset-0 bg-gray-900 opacity-50 flex items-center justify-center z-200">
      <svg class="w-16 h-16 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
      </svg>
    </div>
  </template>
  
  
<script>
import { ref, computed } from 'vue';
import { useStore } from "vuex";


export default {
    data() {
      return {

      };
	},
    setup(){
      const store = useStore();
      const loading = computed(() => store.state.loading);
      return {
        store,
        loading
      }
    }
}
</script>