// stores/user.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore('user', {
  state: () => ({
    profile: null
  }),
  actions: {
    async fetchUserProfile() {
      const res = await axios.get('/api/user/profile')
      this.profile = res.data
    },
    async updateUserProfile(data) {
      const res = await axios.put('/api/user/profile', data)
      this.profile = res.data
    }
  }
})
