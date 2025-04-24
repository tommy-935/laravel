import axios from 'axios'
import { getToken } from '_@/js/lib/common';

export default {
  getCategories(page) {
    const url = page ? `/api/categories?page=${page}` : '/api/categories';
    return axios.get(url, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  createCategory(data) {
    return axios.post('/api/categories', data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    });
  },
  
  updateCategory(id, data) {
    return axios.put(`/api/categories/${id}`, data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  deleteCategory(id) {
    return axios.delete(`/api/categories/${id}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  }
}