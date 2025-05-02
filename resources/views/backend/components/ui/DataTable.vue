<template>
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="p-4 border-b border-gray-200 flex justify-between items-center">
        <SearchInput v-model="searchQuery" placeholder="Search..." />
        <button 
          @click="$emit('add')"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Add
        </button>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th 
                v-for="column in columns" 
                :key="column.key"
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                {{ column.label }}
              </th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Action</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in paginatedData.data" :key="item?.id || index">
              <td 
                v-for="column in columns" 
                :key="column.key"
                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
              >
              <template v-if="column.render">
                {{ column.render(item) }}
              </template>
              <template v-else-if="column.type !== 'image'">
                {{ item[column.key] }}
              </template>

                
                <template v-else-if="column.type === 'image'">
                  <img 
                    v-if="item[column.key]"
                    :src="getImageUrl(item[column.key])"
                    :alt="column.altText ? column.altText(item) : 'Image'"
                    class="h-10 w-10 object-cover"
                  >
                  <span v-else class="text-gray-400">No image</span>
                </template>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button 
                  @click="$emit('edit', item)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  Edit
                </button>
                <button 
                  @click="$emit('delete', item)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="px-4 py-3 border-t border-gray-200">
        <Pagination 
          :current-page="currentPage"
          :total-items="typeof filteredData !== 'undefined' && filteredData.total ? filteredData.total : 0"
          :per-page="perPage"
          @page-changed="handlePageChange"
        />
      </div>
    </div>
    <Loading />
  </template>
  
  <script>
  import SearchInput from './SearchInput.vue'
  import Pagination from './Pagination.vue'
  import Loading from "_@/views/components/Loading.vue";

  
  export default {
    emits: ['add', 'edit', 'delete', 'pageChanged'],
    components: {
      SearchInput,
      Pagination,
      Loading
    },
    props: {
      data: {
        type: Object,
        required: true
      },
      columns: {
        type: Array,
        required: true
      },
      searchFields: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        searchQuery: '',
        currentPage: 1,
        perPage: 10
      }
    },
    computed: {
      filteredData() {
        
        this.currentPage = this.data.current_page ? this.data.current_page : 1;
        this.perPage = this.data.per_page ? this.data.per_page : 10;
        if (!this.searchQuery) return this.data
        
        const query = this.searchQuery.toLowerCase()
        return this.data.data.filter(item => 
          this.searchFields.some(field => 
            String(item[field]).toLowerCase().includes(query)
        ));
      },
      
      paginatedData() {
        if(typeof this.filteredData === "undefined"){
          return [];
        } 
        if(this.filteredData.length === 0){
          return [];
        } 
        return this.filteredData;
      }
    },
    methods: {
      handlePageChange(newPage, oldPage) {
        if (newPage === oldPage) return;
        this.currentPage = newPage
        this.$emit('page-changed', this.currentPage)
      },
      getImageUrl (path){
        if (!path) return '';
        return path;
      }
    },
    watch: {
      // filteredData() {
      //   this.currentPage = 1
      // },

    }
  }
  </script>