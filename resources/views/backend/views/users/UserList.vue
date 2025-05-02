<template>
	<div>
		<h2 class="text-2xl font-bold text-gray-800 mb-6">Users</h2>

		<DataTable :data="users" :columns="columns" :search-fields="searchFields" @add="showForm" @edit="editUser"
			@delete="deleteUser" @page-changed="userStore.fetchUsers" />

		<Modal :show="showModal" @close="closeForm">
			<UserForm :user="selectedUser" @cancel="closeForm" @submit="saveUser" />
		</Modal>
	</div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useUserStore } from '@/store/modules/user'
import DataTable from '@/components/ui/DataTable.vue'
import Modal from '@/components/ui/Modal.vue'
import UserForm from './UserForm.vue'

const userStore = useUserStore()

const columns = [
	{ key: 'id', label: 'ID' },
	{ key: 'name', label: 'Name' },
	{ key: 'email', label: 'Email' },
	{ key: 'role_name', label: 'Role' },
	{ key: 'created_at', label: 'Added Date' }
]

const searchFields = ['name', 'email', 'role']

const showModal = ref(false)
const selectedUser = ref(null)

const users = computed(() => userStore.users)

onMounted(() => {
	userStore.fetchUsers()
})

const showForm = () => {
	selectedUser.value = null
	showModal.value = true
}

const editUser = (user) => {
	selectedUser.value = { ...user }
	showModal.value = true
}

const closeForm = () => {
	showModal.value = false
}

const saveUser = async (userData) => {
	if (userData.id) {
		await userStore.updateUser(userData)
	} else {
		await userStore.createUser(userData)
	}
	closeForm()
}

const deleteUser = async (user) => {
	if (confirm(`Delete "${user.name}"?`)) {
		await userStore.deleteUser(user.id)
	}
}
</script>