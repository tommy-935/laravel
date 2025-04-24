import { defineStore } from 'pinia'
import api from '@/api/user'
import store from '_@/js/store/store';

export const useUserStore = defineStore('user', {
  state: () => ({
    users: []
  }),
  
  actions: {
    async fetchUsers(page) {
      try {
        store.commit("setLoading", true);
        const response = await api.getUsers(page)
        store.commit("setLoading", false);
        this.users = response.data.data
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    },
    
    async createUser(userData) {
      try {
        const response = await api.createUser(userData);
        this.fetchUsers()
        return true;
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    },
    
    async updateUser(userData) {
      try {
        const response = await api.updateUser(userData.id, userData)
        const index = this.users.findIndex(p => p.id === userData.id)
        if (index !== -1) {
          this.users.splice(index, 1, response.data)
        }
        return response.data
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    },
    
    async deleteUser(id) {
      try {
        await api.deleteUser(id);
        this.fetchUsers()
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    }
  }
})