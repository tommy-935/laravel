<template>
  <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <!-- Success header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
          <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Payment Successful!</h1>
        <p class="mt-2 text-gray-600">Your order #{{ order.order_num }} has been confirmed</p>
        <p class="text-gray-600">We've sent the receipt to your email</p>
      </div>

      <!-- Main content -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row">
          <!-- Left column - Addresses -->
          <div class="p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-200 md:w-1/2">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Address Information</h2>
            
            <!-- Shipping address -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Shipping Address</h3>
              <div class="text-sm text-gray-700">
                <p>{{ order.order_user.shipping_first_name }}</p>
                <p>{{ order.order_user.shipping_address1 }}</p>
                <p>{{ order.order_user.shipping_city }}, {{ order.order_user.shipping_state }} {{ order.order_user.shipping_zip_ode }}</p>
                <p>{{ order.order_user.shipping_country }}</p>
                <p class="mt-2">Phone: {{ order.order_user.shipping_phone }}</p>
              </div>
            </div>
            
            <!-- Billing address -->
            <div>
              <h3 class="text-sm font-medium text-gray-500 mb-2">Billing Address</h3>
              <div class="text-sm text-gray-700">
                <p>{{ order.order_user.billing_first_name }}</p>
                <p>{{ order.order_user.billing_address1 }}</p>
                <p>{{ order.order_user.billing_city }}, {{ order.order_user.billing_state }} {{ order.order_user.billing_zip_ode }}</p>
                <p>{{ order.order_user.billing_country }}</p>
                <p class="mt-2">Phone: {{ order.order_user.billing_phone }}</p>
              </div>
            </div>
          </div>

          <!-- Right column - Order summary -->
          <div class="p-6 md:p-8 md:w-1/2">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
            
            <!-- Order items -->
            <div class="divide-y divide-gray-200">
              <div v-for="item in order.products" :key="item.id" class="py-4 flex">
                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                  <img :src="item.image" :alt="item.name" class="h-full w-full object-cover object-center">
                </div>
                <div class="ml-4 flex flex-1 flex-col">
                  <div>
                    <h3 class="text-sm font-medium text-gray-900">{{ item.product_name }}</h3>
                    <p v-if="false" class="mt-1 text-sm text-gray-500">{{ item.variant }}</p>
                  </div>
                  <div class="flex flex-1 items-end justify-between text-sm">
                    <p class="text-gray-500">Qty {{ item.qty }}</p>
                    <p class="font-medium text-gray-900">${{ item.item_price }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment summary -->
            <div class="mt-6 border-t border-gray-200 pt-6">
              <div class="flex justify-between text-base font-medium text-gray-900">
                <p>Subtotal</p>
                <p>${{ order.price.sub_total }}</p>
              </div>
              <div v-if="false" class="flex justify-between text-base font-medium text-gray-900 mt-2">
                <p>Shipping</p>
                <p>${{ order.shipping }}</p>
              </div>
              <div v-if="false" class="flex justify-between text-base font-medium text-gray-900 mt-2">
                <p>Tax</p>
                <p>${{ order.tax }}</p>
              </div>
              <div class="flex justify-between text-base font-medium text-gray-900 mt-4 pt-4 border-t border-gray-200">
                <p>Total</p>
                <p>${{ order.price.total }}</p>
              </div>
            </div>

            <!-- Payment method -->
            <div class="mt-6 border-t border-gray-200 pt-6">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Payment Method</h3>
              <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                  <img :src="paymentMethodIcon" :alt="order.paymentMethod" class="h-5 w-5">
                </div>
                <p class="text-sm font-medium text-gray-700">
                  {{ order.payment.payment_method }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4" v-if="false">
        <button
          type="button"
          class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          Continue Shopping
        </button>
        <button
          type="button"
          class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
          View Order Details
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

const store = useStore()
const router = useRouter()
const orderKey = router.currentRoute.value.params.key
store.dispatch('getCheckout', {key: orderKey}).then(() => {
    watch(
      () => store.state.checkout.order,
      (newVal) => {
        if (newVal) {
          order.value = newVal
          console.log('Checkout order:', newVal)

        } else {
          // router.push({ name: 'home' })
        }
      },
      { immediate: true }
    )
   // order.value = store.state.checkout.order

  
})

const order = ref({
  order_num: 'W086438695',
  products: [
    {
      id: 1,
      name: 'Basic Tee',
      variant: 'Sienna',
      quantity: 1,
      price: '32.00',
      image: 'https://tailwindui.com/img/ecommerce-images/confirmation-page-01-product-01.jpg'
    },
    {
      id: 2,
      name: 'Nomad Tumbler',
      variant: 'White',
      quantity: 1,
      price: '35.00',
      image: 'https://tailwindui.com/img/ecommerce-images/confirmation-page-01-product-02.jpg'
    }
  ],
  price: {
    subtotal: '67.00',
    total: '80.32',
  },
  paymentMethod: 'Visa',
  paymentLast4: '4242',
  order_user: {
    shipping_first_name: 'John Smith',
    shipping_lase_name: 'John Smith',
    shipping_address1: '123 Main St',
    shipping_city: 'Austin',
    shipping_state: 'TX',
    shipping_zip_code: '78701',
    shipping_country: 'United States',
    shipping_phone: '(555) 123-4567',
    billing_first_name: 'John Smith',
    billing_lase_name: 'John Smith',
    billing_address1: '123 Main St',
    billing_city: 'Austin',
    billing_state: 'TX',
    billing_zip_code: '78701',
    billing_country: 'United States',
    billing_phone: '(555) 123-4567'
  }
})

const paymentMethodIcon = ref(
  order.value.paymentMethod === 'Visa' 
    ? 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg'
    : 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg'
)
</script>