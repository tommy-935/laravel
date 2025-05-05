<template>
	<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-100 to-blue-100">
		<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
			<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Forgot Password</h2>
			<p class="text-gray-600 text-center mb-6">
				Enter your email and we’ll send you a link to reset your password.
			</p>

			<form @submit.prevent="handleSubmit" class="space-y-5">
				<div>
					<label class="block text-gray-700 font-semibold mb-1">Email</label>
					<input
						type="email"
						v-model="email"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
						placeholder="Enter your email"
						required
					/>
				</div>

				<button
					type="submit"
					class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-200"
				>
					Send Reset Link
				</button>

				<p class="text-center text-gray-600 text-sm">
					Remembered your password?
					<router-link to="/login" class="text-purple-500 hover:underline">Back to login</router-link>
				</p>
			</form>
		</div>
	</div>
</template>

<script setup>
import { ref } from 'vue';

const email = ref('');

const handleSubmit = () => {
	// 这里可以调用实际的重置密码接口
	console.log('Reset link requested for:', email.value);

	// 模拟提示
	alert(`A reset link has been sent to ${email.value}`);
};
</script>
