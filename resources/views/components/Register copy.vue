<template>
	<div class="container mx-auto p-4 max-w-md">
		<h2 class="text-2xl font-bold mb-4 text-center">Register</h2>
		<form @submit.prevent="handleRegister" class="bg-white p-6 rounded-lg shadow-md">
			<div class="mb-4">
				<label class="block text-gray-700">Username</label>
				<input v-model="form.name" type="text"
					class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
			</div>
			<div class="mb-4">
				<label class="block text-gray-700">Email</label>
				<input v-model="form.email" type="email"
					class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
			</div>
			<div class="mb-4">
				<label class="block text-gray-700">Password</label>
				<input v-model="form.password" type="password"
					class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
			</div>
			<div class="mb-4">
				<label class="block text-gray-700">Confirmed Password</label>
				<input v-model="form.password_confirmation" type="password"
					class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
			</div>
			<button type="submit"
				class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition">Register</button>
		</form>
	</div>
</template>

<script>
import {mapActions, useStore} from "vuex";
import {computed} from "vue";


export default {
	data() {
		return {
			form: {
				name: "",
				email: "",
				password: "",
				password_confirmation: ""
			}
		};
	},
	setup(){
		const store = useStore();

		return {
			store
		};
	},
	methods: {
		...mapActions([
            "register"
        ]),
		handleRegister() {			
			this.store.commit('setLoading', true);
			this.register(this.form);
		},
	}
};
</script>

<style scoped>
.container {
	max-width: 400px;
}
</style>