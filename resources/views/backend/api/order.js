import axios from 'axios'
import { getToken } from '_@/js/lib/common';

export default {
  getOrders(page) {
    const url = page ? `/api/orders?page=${page}` : '/api/orders';
    return axios.get(url, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  createOrder(data) {
    return axios.post('/api/orders', data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    });
  },
  
  updateOrder(id, data) {
    return axios.put(`/api/orders/${id}`, data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  deleteOrder(id) {
    return axios.delete(`/api/orders/${id}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  }
}