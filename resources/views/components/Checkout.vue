<template>
	<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-7xl mx-auto">
			<h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

			<div class="flex flex-col lg:flex-row gap-8">
				<!-- Left Column - Billing Details -->
				<div class="lg:w-1/2">
					<div class="bg-white shadow rounded-lg p-6">
						<h2 class="text-xl font-semibold mb-6">Billing Details</h2>

						<form @submit.prevent="handleSubmit">
							<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
								<div>
									<label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First
										Name</label>
									<input v-model="form.first_name" type="text" id="first_name"
										class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
										required />
								</div>
								<div>
									<label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last
										Name</label>
									<input v-model="form.last_name" type="text" id="last_name"
										class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
										required />
								</div>
							</div>

							<div class="mb-4">
								<label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
									Address</label>
								<input v-model="form.email" type="email" id="email"
									class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
									required />
							</div>

							<div class="mb-4">
								<label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
									Number</label>
								<input v-model="form.phone" type="tel" id="phone"
									class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
									required />
							</div>

							<div class="mb-4">
								<label for="country"
									class="block text-sm font-medium text-gray-700 mb-1">Country</label>
								<select v-model="form.country" id="country"
									class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
									required>
									<option value="">Select Country</option>
									<option value="US">United States</option>
									<option value="CA">Canada</option>
									<option value="UK">United Kingdom</option>
									<option value="AU">Australia</option>
									<!-- Add more countries as needed -->
								</select>
							</div>

							<div class="mb-4">
								<label for="address1" class="block text-sm font-medium text-gray-700 mb-1">Street
									Address 1</label>
								<input v-model="form.address1" type="text" id="address1"
									class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
									required />
							</div>

							<div class="mb-4">
								<label for="address2" class="block text-sm font-medium text-gray-700 mb-1">Street
									Address 2</label>
								<input v-model="form.address1" type="text" id="address2"
									class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
									required />
							</div>

							<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
								<div>
									<label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
									<input v-model="form.city" type="text" id="city"
										class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
										required />
								</div>
								<div>
									<label for="state"
										class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
									<input v-model="form.state" type="text" id="state"
										class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
										required />
								</div>
								<div>
									<label for="zip_code"
										class="block text-sm font-medium text-gray-700 mb-1">ZIP/Postal Code</label>
									<input v-model="form.zip_code" type="text" id="zip_code"
										class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
										required />
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Right Column - Order Summary & Payment -->
				<div class="lg:w-1/2">
					<!-- Order Summary -->
					<div class="bg-white shadow rounded-lg p-6 mb-6">
						<h2 class="text-xl font-semibold mb-6">Your Order</h2>

						<div class="border-b border-gray-200 pb-4 mb-4">
							<div class="flex justify-between mb-2">
								<span class="font-medium">Product</span>
								<span class="font-medium">Subtotal</span>
							</div>

							<div v-for="item in cartItems" :key="item.id" class="flex justify-between py-2">
								<span>{{ item.product.name }} × {{ item.quantity }}</span>
								<span>${{ item.price * item.quantity }}</span>
							</div>
						</div>

						<div class="border-b border-gray-200 pb-4 mb-4">
							<div class="flex justify-between py-2">
								<span>Subtotal</span>
								<span>${{ subtotal }}</span>
							</div>
							<div class="flex justify-between py-2">
								<span>Shipping</span>
								<span>${{ shippingCost }}</span>
							</div>
						</div>

						<div class="flex justify-between text-lg font-bold">
							<span>Total</span>
							<span>${{ total }}</span>
						</div>
					</div>

					<!-- Payment Methods -->
					<div class="bg-white shadow rounded-lg p-6">
						<h2 class="text-xl font-semibold mb-6">Payment Methods</h2>

						<div class="space-y-4">
							<!-- Credit Card (Stripe) -->
							<div class="border border-gray-200 rounded-md p-4">
								<div class="flex items-center mb-3">
									<input v-model="paymentMethod" type="radio" id="stripe" value="stripe"
										class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" />
									<label for="stripe" class="ml-3 block text-sm font-medium text-gray-700">
										Credit Card (Stripe)
									</label>
								</div>

								<div v-if="paymentMethod === 'stripe'" class="mt-4 space-y-4">
									<StripePayment v-if="stripeLoaded && clientSecret"
										:publishable-key="stripePublishableKey" :client-secret="clientSecret"
										:amount="total" @payment-success="handlePaymentSuccess"
										@payment-error="handlePaymentError" />
									<div v-else class="text-sm text-gray-500">
										loading payment...
									</div>
								</div>
							</div>

							<!-- PayPal -->
							<div class="border border-gray-200 rounded-md p-4">
								<div class="flex items-center">
									<input v-model="paymentMethod" type="radio" id="payment-paypal" value="paypal"
										class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" />
									<label for="payment-paypal" class="ml-3 block text-sm font-medium text-gray-700">
										PayPal
									</label>
								</div>
								<div v-if="paymentMethod === 'paypal'" class="mt-4">
									<PayPalPayment :amount="total" currency="USD" :client-id="paypalClientId" :form="form"
										intent="capture" @payment-approved="handlePayPalApproved"
										@payment-completed="handlePayPalCompleted" @payment-error="handlePayPalError" />
								</div>
							</div>

							<!-- Apple Pay -->
							<div class="border border-gray-200 rounded-md p-4">
								<div class="flex items-center">
									<input v-model="paymentMethod" type="radio" id="apple_pay" value="apple_pay"
										class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" />
									<label for="apple_pay" class="ml-3 block text-sm font-medium text-gray-700">
										Apple Pay
									</label>
								</div>
								<div v-if="paymentMethod === 'apple_pay'" class="mt-4">
									<ApplePayPayment :amount="total" currency="USD"
										:merchant-identifier="applePayMerchantId" country-code="US"
										:label="'购买 (' + storeName + ')'" @payment-authorized="handleApplePayAuthorized"
										@payment-completed="handleApplePayCompleted"
										@payment-error="handleApplePayError" />
								</div>
							</div>
						</div>

						<!-- Terms & Place Order Button -->
						<div class="mt-8">
							<div class="flex items-center">
								<input id="terms" type="checkbox"
									class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
									required />
								<label for="terms" class="ml-2 block text-sm text-gray-700">
									I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms and
										Conditions</a>
								</label>
							</div>

							<button @click="handleCheckout"
								class="w-full mt-6 bg-indigo-600 py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								Place Order
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue';
import { mapActions } from 'vuex';
import { loadStripe } from '@stripe/stripe-js'
import StripePayment from './StripePayment.vue'
import PayPalPayment from './PayPalPayment.vue'
import ApplePayPayment from './ApplePayPayment.vue'
import { useStore } from 'vuex';

export default {
	data() {
		return {
		}
	},
	components: {
		StripePayment,
		PayPalPayment,
		ApplePayPayment
	},
	setup() {
		// Form data
		const form = ref({
			first_name: '66',
			last_name: '66',
			email: '66@fi.com',
			phone: '234444',
			country: 'US',
			address1: 'fff',
			address2: 'fff',
			city: 'Aluran',
			state: 'sss',
			zip_code: '36830'
		});

		// Payment method
		const paymentMethod = ref('stripe');

		// Sample cart items
		const cartItems = ref([
			{
				id: 1, name: 'Product 1',
				price: 29.99, quantity: 2,
				product: {
					name: 'Product 1',
					price: 29.99,
				}
			}

		]);

		const total = ref(0);


		// Stripe status
		const stripePublishableKey = 'pk_test_51RIVv3R6LbXe1U6xPvOBMmFz7349yW8U667oMsySLfG17bUJSaZUcaRcprl9XWliEHcCwQVWrB41kO5BNHKKFsJa00ti8qzl9M' // key
		const paypalClientId = 'AalPHAuvErzOQ2sGnn7mmaC-3swvG3ba68iRpdr0WaRL5I0uy8xpBLYR_Pzr4c0P5D8zfGpnSBcjNLeL' // PayPal Client ID

		const stripeLoaded = ref(false)
		const clientSecret = ref('')

		// mount Stripe
		onMounted(async () => {
			try {
				await function () {
					loadStripe(stripePublishableKey)
					stripeLoaded.value = true;
					const store = useStore();
					store.dispatch('getCart')
					const cart = computed(() => store.state.cart.cart);
					watch(cart, (newCart) => {
						cartItems.value = newCart.cartItems;
						total.value = newCart.total;
					});

				}();

				
			} catch (error) {
				console.error('Failed to load Stripe:', error)
			}
		})

		watch(total, (newTotal) => {
			// use backend API get clientSecret
				// API fetch
				fetchPaymentIntent()
		})

		// fetch payment intent
		const fetchPaymentIntent = async () => {
			console.log('toal', total.value);
			// get backend API
			const response = await axios.post('/api/create-payment-intent', { amount: total.value * 100 })

			// response
			clientSecret.value = response.data.clientSecret // 
		}

		const handlePaymentSuccess = (paymentIntent) => {
			console.log('Payment succeeded:', paymentIntent)
			// success callback submit order
			const data = {
				paymentIntentId: paymentIntent.id,
				amount: paymentIntent.amount,
				currency: paymentIntent.currency,
				status: paymentIntent.status,
				payment_method: paymentMethod.value,
			};
			const address = {
				billing_address: form.value,
				shipping_address: form.value,
			};
			const params = { ...data, ...address };
			console.log('params', params);
			axios.post('/checkout/process', params)
				.then(response => {
					console.log('Payment processed successfully:', response.data)
					// success callback
					if(response.data.success) {
						// Redirect to success page or show confirmation
						window.location.href = response.data.data.redirect_url;
					} else {
						// Handle error
						console.error('Payment processing failed:', response.data.message)
					}	
				})
				.catch(error => {
					console.error('Failed to process payment:', error)
					// failed callback
				});
		}

		const handlePaymentError = (error) => {
			console.error('Payment failed:', error)
			// failed callback
		}


		// PayPal configure

		const handlePayPalApproved = (data) => {
			console.log('PayPal payment approved:', data)
			// paying logic
			
		}

		const handlePayPalCompleted = (details, data) => {
			console.log('PayPal payment completed:', details)
			if(data.redirect_url){
				window.location.href = data.redirect_url;
			}
		}

		const handlePayPalError = (error) => {
			console.error('PayPal payment error:', error)
		}


		// Apple Pay configure
		const storeName = 'store name'
		const applePayMerchantId = 'merchant.com.yourdomain' // Merchant ID

		const handleApplePayAuthorized = (payment) => {
			console.log('Apple Pay authorized:', payment)
			// paying logic
		}

		const handleApplePayCompleted = (payment) => {
			console.log('Apple Pay completed:', payment)
		}

		const handleApplePayError = (error) => {
			console.error('Apple Pay error:', error)
		}



		// Calculate order totals
		const subtotal = total;

		const shippingCost = computed(() => {
			return 0; // Flat rate shipping for demo
		});



		// Handle form submission
		const handleSubmit = () => {
			console.log('Form submitted:', form.value);
			console.log('Payment method:', paymentMethod.value);
			// Here you would typically:
			// 1. Validate the form
			// 2. Process payment with the selected method
			// 3. Submit order to your backend
			// 4. Redirect to success page or show confirmation

		};

		return {
			form,
			paymentMethod,
			cartItems,
			subtotal,
			shippingCost,
			total,
			handleSubmit,
			stripeLoaded,
			clientSecret,
			stripePublishableKey,
			handlePaymentSuccess,
			handlePaymentError,
			paypalClientId,
			handlePayPalApproved,
			handlePayPalCompleted,
			handlePayPalError,
			fetchPaymentIntent,
			storeName,
			applePayMerchantId,
			handleApplePayAuthorized,
			handleApplePayCompleted,
			handleApplePayError,
			stripeLoaded,
		};
	},
	methods: {
		...mapActions(['checkout', 'getCart']),
		handleCheckout() {
			console.log('Form submitted:', this.form);
			console.log('Payment method:', this.paymentMethod);
			this.checkout(this.form);
			// Here you would typically:
			// 1. Validate the form
			// 2. Process payment with the selected method
			// 3. Submit order to your backend
			// 4. Redirect to success page or show confirmation

		}
		,
		getCartInfo() {
			this.getCart();
			const cart = computed(() => this.store.state.cart.cart);
			console.log("cart", cart);
		}
	}
};
</script>