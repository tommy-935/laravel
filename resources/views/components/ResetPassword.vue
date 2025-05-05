<template>
	<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-100 to-purple-100">
		<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
			<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>
			<p class="text-gray-600 text-center mb-6">
				Please enter your new password below.
			</p>

			<form @submit.prevent="handleReset" class="space-y-5">
				<div>
					<label class="block text-gray-700 font-semibold mb-1">New Password</label>
					<input
						type="password"
						v-model="password"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						placeholder="New password"
						required
					/>
				</div>

				<div>
					<label class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
					<input
						type="password"
						v-model="confirmPassword"
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						placeholder="Confirm new password"
						required
					/>
				</div>

				<button
					type="submit"
					class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
				>
					Reset Password
				</button>

				<p class="text-center text-gray-600 text-sm">
					Back to
					<router-link to="/login" class="text-blue-500 hover:underline">Login</router-link>
				</p>
			</form>
		</div>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const password = ref('');
const confirmPassword = ref('');
const token = route.query.token || ''; // 假设链接中带有 ?token=xxxx

const handleReset = () => {
	if (password.value !== confirmPassword.value) {
		alert("Passwords do not match.");
		return;
	}

	// 实际上这里会请求后端 API，传入 token 和新密码
	console.log("Resetting password with token:", token);
	console.log("New password:", password.value);

	// 模拟成功后跳转
	alert("Password reset successful.");
	router.push('/login');
};
</script>
