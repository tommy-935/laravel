<template>
	<div class="min-h-screen flex items-center justify-center bg-gray-100">
		<div class="bg-white p-8 rounded-lg shadow-lg w-96">
			<h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login</h2>

			<form @submit.prevent="handleSubmit">
				<div class="mb-4">
					<label class="block text-gray-700 font-medium mb-2">Email</label>
					<input type="email" v-model="email"
						class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						placeholder="Enter your email" required />
				</div>

				<div class="mb-4">
					<label class="block text-gray-700 font-medium mb-2">Password</label>
					<input type="password" v-model="password"
						class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						placeholder="Enter your password" required />
				</div>

				<button type="submit"
					class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
					Login
				</button>
			</form>
		</div>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const email = ref('');
const password = ref('');

const handleSubmit = () => {
	const form = {
		email: email.value,
		password: password.value
	};
	store.commit('setLoading', true);
	store.dispatch('login', form)
};
</script>