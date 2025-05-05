<template>
	<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-100 to-blue-100">
		<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
			<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create Account</h2>

			<form @submit.prevent="handleRegister" class="space-y-5">
				<div>
					<label class="block text-gray-700 font-semibold mb-1">Name</label>
					<input
						type="text"
						v-model="name"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
						placeholder="Your name"
						required
					/>
				</div>

				<div>
					<label class="block text-gray-700 font-semibold mb-1">Email</label>
					<input
						type="email"
						v-model="email"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
						placeholder="Your email"
						required
					/>
				</div>

				<div>
					<label class="block text-gray-700 font-semibold mb-1">Password</label>
					<input
						type="password"
						v-model="password"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
						placeholder="Password"
						required
					/>
				</div>

				<div>
					<label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
					<input
						type="password"
						v-model="confirmPassword"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
						placeholder="Confirm password"
						required
					/>
				</div>

				<div class="flex items-start space-x-2">
					<input
						type="checkbox"
						v-model="agree"
						id="agree"
						class="mt-1"
					/>
					<label for="agree" class="text-sm text-gray-600">
						I agree to the
						<a href="/terms" target="_blank" class="text-green-600 hover:underline">Terms of Service</a>
						and
						<a href="/privacy" target="_blank" class="text-green-600 hover:underline">Privacy Policy</a>.
					</label>
				</div>

				<button
					type="submit"
					:disabled="!agree"
					class="w-full py-2 px-4 rounded-lg transition duration-200"
					:class="agree
						? 'bg-green-600 text-white hover:bg-green-700'
						: 'bg-gray-400 text-white cursor-not-allowed'"
				>
					Register
				</button>

				<p class="text-center text-gray-600 text-sm">
					Already have an account?
					<router-link to="/login" class="text-green-600 hover:underline">Login</router-link>
				</p>
			</form>
		</div>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const router = useRouter();
const store = useStore();

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const agree = ref(false);

const handleRegister = () => {
	if (password.value !== confirmPassword.value) {
		alert("Passwords do not match.");
		return;
	}

	const form = {
		name: name.value,
		email: email.value,
		password: password.value,
		password_confirmation: confirmPassword.value,
	};
	store.commit('setLoading', true);
	store.dispatch('register', form)
};
</script>
