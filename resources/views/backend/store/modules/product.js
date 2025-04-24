import { defineStore } from 'pinia'
import api from '@/api/product'
import store from '_@/js/store/store';

export const useProductStore = defineStore('product', {
  state: () => ({
    products: []
  }),
  
  actions: {
    async fetchProducts(page) {
      try {
        store.commit("setLoading", true);
        const response = await api.getProducts(page)
        store.commit("setLoading", false);
        this.products = response.data.data
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    },
    
    async createProduct(productData) {
      try {
        const response = await api.createProduct(productData);
        this.fetchProducts()
        return true;
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    },
    
    async updateProduct(productData) {
      try {
        const response = await api.updateProduct(productData.id, productData)
        const index = this.products.findIndex(p => p.id === productData.id)
        if (index !== -1) {
          this.products.splice(index, 1, response.data)
        }
        return response.data
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    },
    
    async deleteProduct(id) {
      try {
        await api.deleteProduct(id);
        this.fetchProducts()
      } catch (error) {
        console.error('Failed:', error)
        throw error
      }
    }
  }
})