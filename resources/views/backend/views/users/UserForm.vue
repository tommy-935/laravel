<template>
	<div class="p-6">
		<h3 class="text-lg font-medium text-gray-900 mb-4">
			{{ user ? 'Edit User' : 'Add User' }}
		</h3>

		<form @submit.prevent="handleSubmit">
			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
				<input v-model="form.name" type="text"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
				<input v-model="form.email" type="email"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
				<input v-model="form.password" type="password"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required>
			</div>

			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
				<select v-model="form.role_id"
					class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
					required :disabled="rolesLoading">
					<option value="" disabled>Select a role</option>
					<option v-for="role in roles" :key="role.id" :value="role.id">
						{{ role.name }}
					</option>
				</select>
				<p v-if="rolesLoading" class="mt-1 text-sm text-gray-500">Loading roles...</p>
				<p v-if="rolesError" class="mt-1 text-sm text-red-500">{{ rolesError }}</p>
			</div>

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
import { getToken } from '_@/js/lib/common';


const props = defineProps({
	user: {
		type: Object,
		default: null
	},
	rolesApiUrl: {
		type: String,
		default: '/api/roles'
	}
})

const roles = ref([])
const rolesLoading = ref(false)
const rolesError = ref('')

onMounted(async () => {
	await fetchRoles()
})

const emit = defineEmits(['submit', 'cancel'])

const form = ref({
	name: '',
	email: '',
	password: '',
	role_id: 0
})

const fetchRoles = async () => {
	try {
		rolesLoading.value = true
		rolesError.value = ''

		const response = await axios.get(props.rolesApiUrl, {
			headers: {
				'Authorization': `Bearer ${getToken()}`
			}
		})
		console.log('Roles response:', response.data)
		roles.value = response.data.data.data || response.data
	} catch (error) {
		console.error('Failed to fetch roles:', error)
		rolesError.value = 'Failed to load roles. Please try again later.'
	} finally {
		rolesLoading.value = false
	}
}

watch(() => props.user, (newVal) => {
	if (newVal) {
		form.value = { ...newVal }
	} else {
		form.value = {
			name: '',
			email: '',
			password: '',
			role_id: 0
		}
	}
}, { immediate: true })

const handleSubmit = () => {
	emit('submit', form.value)
}
</script>