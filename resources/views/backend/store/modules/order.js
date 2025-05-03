import { defineStore } from 'pinia'
import api from '@/api/order'
import store from '_@/js/store/store';

export const useOrderStore = defineStore('order', {
	state: () => ({
		orders: []
	}),

	actions: {
		async fetchOrders(page) {
			try {
				store.commit("setLoading", true);
				const response = await api.getOrders(page)
				store.commit("setLoading", false);
				this.orders = response.data.data
			} catch (error) {
				console.error('Failed:', error)
				throw error
			}
		},

		async createOrder(orderData) {
			try {
				const response = await api.createOrder(orderData);
				this.fetchOrders()
				return true;
			} catch (error) {
				console.error('Failed:', error)
				throw error
			}
		},

		async updateOrder(orderData) {
			try {
				const response = await api.updateOrder(orderData.id, orderData)
				this.fetchOrders()
				return response.data
			} catch (error) {
				console.error('Failed:', error)
				throw error
			}
		},

		async getOrder(id) {
			try {
				const response = await api.getOrder(id)
				return response.data
			} catch (error) {
				console.error('Failed:', error)
				throw error
			}
		},

		async deleteOrder(id) {
			try {
				await api.deleteOrder(id);
				this.fetchOrders()
			} catch (error) {
				console.error('Failed:', error)
				throw error
			}
		}
	}
})