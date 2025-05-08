// stores/user.js
import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserStore = defineStore('user', {
  state: () => ({
    profile: null
  }),
  actions: {
    async fetchUserProfile() {
      const res = await axios.post('/user/get-profile')
      this.profile = res.data.data
    },
    async updateUserProfile(data) {
      const res = await axios.post('/user/update-profile', data)
      return res.data
    }
  }
})
