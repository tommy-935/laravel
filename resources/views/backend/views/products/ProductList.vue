<template>
    <div>
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Products</h2>
      
      <DataTable
        :data="products"
        :columns="columns"
        :search-fields="searchFields"
        @add="showForm"
        @edit="editProduct"
        @delete="deleteProduct"
        @page-changed="productStore.fetchProducts"
      />
      
      <Modal :show="showModal" @close="closeForm">
        <ProductForm
          :product="selectedProduct"
          @cancel="closeForm"
          @submit="saveProduct"
        />
      </Modal>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue'
  import { useProductStore } from '@/store/modules/product'
  import DataTable from '@/components/ui/DataTable.vue'
  import Modal from '@/components/ui/Modal.vue'
  import ProductForm from './ProductForm.vue'
  
  const productStore = useProductStore() 
  
  const columns = [
    { key: 'id', label: 'ID' },
    { key: 'img_uri', label: 'Image', type: "image" },
    { key: 'name', label: 'Name' },
    { key: 'uri', label: 'URI' },
    { key: 'cate_name', label: 'Category' },
    { key: 'price', label: 'Price' },
    { key: 'added_date', label: 'Added Date' }
  ]
  
  const searchFields = ['name', 'price']
  
  const showModal = ref(false)
  const selectedProduct = ref(null)
  
  const products = computed(() => productStore.products)
  onMounted(() => {
    productStore.fetchProducts(1)
  });

  
  const showForm = () => {
    selectedProduct.value = null
    showModal.value = true
  }
  
  const editProduct = (product) => {
    selectedProduct.value = { ...product }
    showModal.value = true
  }
  
  const closeForm = () => {
    showModal.value = false
  }
  
  const saveProduct = async (productData) => {
    if (productData.id) {
      const res = await productStore.updateProduct(productData)
      console.log("tttt", res)
    } else {
      await productStore.createProduct(productData)
    }
    closeForm()
  }
  
  const deleteProduct = async (product) => {
    if (confirm(`Delete "${product.name}"?`)) {
      await productStore.deleteProduct(product.id)
    }
  }
  </script>