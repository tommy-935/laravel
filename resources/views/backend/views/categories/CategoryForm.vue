<template>
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
          <h3 class="text-lg font-medium mb-4">
            {{ category !== null ? 'Edit Category' : 'Add Category' }}
          </h3>
          
          <form @submit.prevent="submit">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
              <input
                v-model="form.cate_name"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                required
              >
            </div>
            
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
              <input
                v-model="form.slug"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                required
              >
            </div>
            
            <div class="flex justify-end space-x-3">
              <button
                type="button"
                @click="$emit('close')"
                class="px-4 py-2 border border-gray-300 rounded-md"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      category: {
        type: Object,
        default: null
      }
    },
    data() {
      return {
        form: {
          cate_name: '',
          slug: ''
        }
      }
    },
    watch: {
      category: {
        immediate: true,
        handler(val) {
          if (val) {
            this.form = { ...val }
          } else {
            this.form = {
              cate_name: '',
              slug: ''
            }
          }
        }
      }
    },
    methods: {
      submit() {
        this.$emit('save', this.form)
      }
    }
  }
  </script>