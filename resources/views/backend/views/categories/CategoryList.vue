<template>
    <div>
      <h2 class="text-2xl font-bold mb-6">Product Categories</h2>
      
      <DataTable
        :data="categories"
        :columns="columns"
        :search-fields="searchFields"
        @add="showForm"
        @edit="editCategory"
        @delete="delCategory"
        @page-changed="fetchCategories"
      />
      
      <CategoryForm
        v-if="showModal"
        :category="selectedCategory"
        @close="closeForm"
        @save="saveCategory"
      />
    </div>
  </template>
  
  <script>
  import DataTable from '@/components/ui/DataTable.vue'
  import CategoryForm from './CategoryForm.vue'
  import { mapState, mapActions } from 'vuex'
  
  export default {
    components: {
      DataTable,
      CategoryForm
    },
    data() {
      return {
        showModal: false,
        selectedCategory: null,
        columns: [
          { key: 'id', label: 'ID' },
          { key: 'cate_name', label: 'Name' },
          { key: 'slug', label: 'Slug' },
          { key: 'created_at', label: 'Added Date' }
        ],
        searchFields: ['cate_name', 'slug']
      }
    },
    watch: {
      currentPage(newPage) {
        this.fetchCategories(newPage)
      }
    },
    computed: {
      ...mapState('category', ['categories'])
    },
    created() {
      this.fetchCategories(1)
    },
    methods: {
      ...mapActions('category', ['fetchCategories', 'createCategory', 'updateCategory', 'deleteCategory']),
      
      showForm() {
        this.selectedCategory = null
        this.showModal = true
      },
      
      editCategory(category) {
        this.selectedCategory = { ...category }
        this.showModal = true
      },
      
      closeForm() {
        this.showModal = false
      },
      
      async saveCategory(category) {
        if (category.id) {
          await this.updateCategory(category)
        } else {
          await this.createCategory(category)
        }
        this.fetchCategories()
        this.closeForm()
      },
      
      async delCategory(category) {
        if (confirm(`Delete "${category.cate_name}"?`)) {
          await this.deleteCategory(category.id)
        }
      }
    }
  }
  </script>