<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Profile</h1>
  
      <form @submit.prevent="updateProfile" class="space-y-4 max-w-lg">
        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input v-model="form.name" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
        </div>
  
        <div>
  <label class="block text-sm font-medium text-gray-700">Email</label>
  <input 
    v-model="form.email" 
    type="email" 
    disabled
    class="
      w-full border border-gray-300 rounded-lg px-4 py-2
      bg-gray-100 text-gray-500 cursor-not-allowed
      focus:outline-none focus:ring-0 focus:border-gray-300
      hover:bg-gray-100
    "
  />
</div>
  
        <div v-if="false">
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input v-model="form.phone" type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
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
  import { useUserStore } from '_@/views/frontend/stores/user'
  import { useStore } from 'vuex'
  
  const userStore = useUserStore()
  const form = ref({ name: '', email: '', phone: '' })
  const store = useStore()
  
  onMounted(async () => {
    await userStore.fetchUserProfile()
    form.value = { ...userStore.profile }
  })
  
  const updateProfile = async () => {
    store.commit('setLoading', true);
    const res = await userStore.updateUserProfile(form.value)
    store.commit('setLoading', false);

    console.log(res)
    if(res.success) {
      alert('Profile updated successfully!')
    }else {
      alert('Failed to update profile')
    }
  }
  </script>
  