// stores/user.js
import { defineStore } from 'pinia'
import axios from 'axios'
import ChangePassword from '../account/components/ChangePassword.vue'

export const useUserStore = defineStore('user', {
  state: () => ({
    profile: null,
    user: null,
    isLoggedIn: false,
  }),
  actions: {
    async fetchUserProfile() {
      const res = await axios.post('/user/get-profile')
      this.profile = res.data.data
    },
    async updateUserProfile(data) {
      const res = await axios.post('/user/update-profile', data)
      return res.data
    },
    async fetchUserOrders() {
      const res = await axios.post('/user/get-orders')
      return res.data
    },
    async fetchUserOrder(data) {
      const res = await axios.post('/user/get-order', data)
      return res.data
    },
    async changePassword(data) {
      const res = await axios.post('/user/change-password', data)
      return res.data
    },
  }
})
