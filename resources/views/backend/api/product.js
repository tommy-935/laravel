import axios from 'axios'
import { getToken } from '_@/js/lib/common';

export default {
  getProducts(page) {
    const url = page ? `/api/products?page=${page}` : '/api/products';
    return axios.get(url, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  createProduct(data) {
    return axios.post('/api/products', data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    });
  },
  
  updateProduct(id, data) {
    return axios.put(`/api/products/${id}`, data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  deleteProduct(id) {
    return axios.delete(`/api/products/${id}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  }
}