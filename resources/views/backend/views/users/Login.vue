<template>
	<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-100 to-purple-100">
		<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
			<h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Welcome Back</h2>

			<form @submit.prevent="handleSubmit" class="space-y-5">
				<div>
					<label class="block text-gray-700 font-semibold mb-1">Email</label>
					<input
						type="email"
						v-model="email"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						placeholder="Enter your email"
						required
					/>
				</div>

				<div>
					<label class="block text-gray-700 font-semibold mb-1">Password</label>
					<input
						type="password"
						v-model="password"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						placeholder="Enter your password"
						required
					/>
				</div>

				<div class="text-right" v-if="false">
					<router-link to="/forgot-password" class="text-sm text-blue-500 hover:underline">
						Forgot Password?
					</router-link>
				</div>

				<button
					type="submit"
					class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
				>
					Login
				</button>

				<p class="text-center text-gray-600 text-sm" v-if="false">
					Don't have an account?
					<router-link to="/register" class="text-blue-500 hover:underline">Register</router-link>
				</p>
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
	store.dispatch('admin_login', form)
};
</script>