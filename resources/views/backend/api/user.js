import axios from 'axios'
import { getToken } from '_@/js/lib/common';

export default {
  getUsers(page) {
    const url = page ? `/api/users?page=${page}` : '/api/users';
    return axios.get(url, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  createUser(data) {
    return axios.post('/api/users', data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    });
  },
  
  updateUser(id, data) {
    return axios.put(`/api/users/${id}`, data, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  },
  
  deleteUser(id) {
    return axios.delete(`/api/users/${id}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${getToken()}`
      }
    })
  }
}