<template>
	<div class="p-6">
		<h3 class="text-lg font-medium text-gray-900 mb-4">
			{{ product ? 'Edit Product' : 'Add Product' }}
		</h3>

		<form @submit.prevent="handleSubmit">
			<!-- 现有表单字段... -->
			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
				<input v-model="form.name" type="text"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
				<select v-model="form.cate_id"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required :disabled="categoriesLoading">
					<option value="" disabled>Select a category</option>
					<option v-for="category in categories" :key="category.id" :value="category.id">
						{{ category.cate_name }}
					</option>
				</select>
				<p v-if="categoriesLoading" class="mt-1 text-sm text-gray-500">Loading categories...</p>
				<p v-if="categoriesError" class="mt-1 text-sm text-red-500">{{ categoriesError }}</p>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
				<input v-model="form.price" type="number" min="0" step="0.01"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Handle</label>
				<input v-model="form.uri" type="text" min="0"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
				<textarea v-model="form.short_desc" rows="3"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
			</div>

			<!-- 新增图片上传区域 -->
			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
				<div class="mt-1 flex items-center">
					<img v-if="imagePreview || (product && product.image)" :src="imagePreview || product.img_uri"
						class="h-32 w-32 object-cover rounded-md mr-4">
					<div class="flex flex-col">
						<input type="file" ref="fileInput" @change="handleFileChange" accept="image/*" class="hidden">
						<button type="button" @click="$refs.fileInput.click()"
							class="px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-2">
							{{ imagePreview || (product && product.image_id) ? 'Change Image' : 'Upload Image' }}
						</button>
						<button v-if="imagePreview || (product && product.image_id)" type="button" @click="removeImage"
							class="px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
							Remove
						</button>
					</div>
				</div>
				<p class="mt-1 text-sm text-gray-500" v-if="uploadProgress > 0 && uploadProgress < 100">
					Uploading: {{ uploadProgress }}%
				</p>
				<p class="mt-1 text-sm text-red-500" v-if="uploadError">
					{{ uploadError }}
				</p>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
				<textarea v-model="form.long_desc" rows="3"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
			</div>

			<!-- 现有按钮... -->
			<div class="flex justify-end space-x-3">
				<button type="button" @click="$emit('cancel')"
					class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
					Cancel
				</button>
				<button type="submit"
					class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
					Save
				</button>
			</div>
		</form>
	</div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import axios from 'axios'
import { getToken } from '_@/js/lib/common';

const props = defineProps({
	product: {
		type: Object,
		default: null
	},
	apiUrl: {
		type: String,
		default: '/api/attachments'
	},
	categoriesApiUrl: {
		type: String,
		default: '/api/categories'
	}
})



const emit = defineEmits(['submit', 'cancel'])

const form = ref({
	name: '',
	price: 0,
	uri: '',
	short_desc: '',
	long_desc: '',
	image: null,
	image_id: 0,
	cate_id: ''
})

const fileInput = ref(null)
const imagePreview = ref('')
const uploadProgress = ref(0)
const uploadError = ref('')

const categories = ref([])
const categoriesLoading = ref(false)
const categoriesError = ref('')

const resetForm = () => {
	form.value = {
		name: '',
		price: 0,
		uri: '',
		short_desc: '',
		long_desc: '',
		image: null,
		image_id: '',
		cate_id: ''
	}
	imagePreview.value = ''
	uploadProgress.value = 0
	uploadError.value = ''
}

onMounted(async () => {
	await fetchCategories()
})

watch(() => props.product, (newVal) => {
	if (newVal) {
		form.value = { ...newVal }
		if (newVal.image_id) {
			imagePreview.value = newVal.image_id
		}
	} else {
		resetForm()
	}
}, { immediate: true })


const fetchCategories = async () => {
	try {
		categoriesLoading.value = true
		categoriesError.value = ''

		const response = await axios.get(props.categoriesApiUrl, {
			headers: {
				'Authorization': `Bearer ${getToken()}`
			}
		})
		console.log('Categories response:', response.data)
		categories.value = response.data.data.data || response.data
	} catch (error) {
		console.error('Failed to fetch categories:', error)
		categoriesError.value = 'Failed to load categories. Please try again later.'
	} finally {
		categoriesLoading.value = false
	}
}

const handleFileChange = (e) => {
	const file = e.target.files[0]
	if (!file) return

	if (!file.type.match('image.*')) {
		uploadError.value = 'Please select an image file'
		return
	}

	if (file.size > 5 * 1024 * 1024) {
		uploadError.value = 'File size must be less than 5MB'
		return
	}

	uploadError.value = ''
	form.value.image = file

	const reader = new FileReader()
	reader.onload = (e) => {
		imagePreview.value = e.target.result
	}
	reader.readAsDataURL(file)
}

const removeImage = () => {
	form.value.image = null
	form.value.image_id = ''
	imagePreview.value = ''
	if (fileInput.value) {
		fileInput.value.value = ''
	}
}

const uploadImage = async () => {
	if (!form.value.image) return null

	const formData = new FormData()
	if(typeof form.value.image === 'string') {
		return ;
	}
	formData.append('file', form.value.image)

	try {
		const response = await axios.post(`${props.apiUrl}`, formData, {
			headers: {
				'Content-Type': 'multipart/form-data',
				'Authorization': `Bearer ${getToken()}`
			},
			onUploadProgress: (progressEvent) => {
				uploadProgress.value = Math.round(
					(progressEvent.loaded * 100) / progressEvent.total
				)
			}
		})
		uploadProgress.value = 0
		return response.data.data.id
	} catch (error) {
		uploadError.value = 'Failed to upload image'
		console.error('Upload error:', error)
		throw error
	}
}

const handleSubmit = async () => {
	try {

		if (form.value.image) {
			const id = await uploadImage()
			form.value.image_id = id
		}

		const submitData = {
			...form.value,
			image: undefined,
			image_id: form.value.image_id || 0,
			cate_id: form.value.cate_id || ''
		}

		emit('submit', submitData)
	} catch (error) {
		console.error('Form submission error:', error)
	}
}
</script>