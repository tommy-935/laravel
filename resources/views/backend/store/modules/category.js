import api from '@/api/category';
import store from '_@/js/store/store';

const state = {
  categories: []
}

const mutations = {
  SET_CATEGORIES(state, categories) {
    store.commit("setLoading", false);
    state.categories = categories.data
  },
  ADD_CATEGORY(state, category) {
    state.categories.data.push(category)
  },
  UPDATE_CATEGORY(state, updatedCategory) {
    const index = state.categories.data.findIndex(c => c.id === updatedCategory.id)
    if (index !== -1) {
      state.categories.data.splice(index, 1, updatedCategory)
    }
  },
  DELETE_CATEGORY(state, id) {
    state.categories.data = state.categories.data.filter(c => c.id !== id)
  }
}

const actions = {
  async fetchCategories({ commit }, page) {
    try {
      store.commit('setLoading', true);
      const response = await api.getCategories(page)
      commit('SET_CATEGORIES', response.data)
    } catch (error) {
      console.error('Get categories failed:', error)
    }
  },
  
  async createCategory({ commit }, categoryData) {
    try {
      const response = await api.createCategory(categoryData)
      commit('ADD_CATEGORY', response.data)
      return response.data
    } catch (error) {
      console.error('Failed:', error)
      throw error
    }
  },
  
  async updateCategory({ commit }, categoryData) {
    try {
      const response = await api.updateCategory(categoryData.id, categoryData)
      commit('UPDATE_CATEGORY', response.data)
      return response.data
    } catch (error) {
      console.error('Failed:', error)
      throw error
    }
  },
  
  async deleteCategory({ commit }, id) {
    try {
      await api.deleteCategory(id)
      commit('DELETE_CATEGORY', id)
    } catch (error) {
      console.error('Failed:', error)
      throw error
    }
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}