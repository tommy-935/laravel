<template>
    <div class="stripe-payment">
      <!-- Stripe form -->
      <div ref="cardElement" class="stripe-card-element"></div>
      
      <!-- error message -->
      <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>
      
      <!-- submit -->
      <button
        @click="submitPayment"
        :disabled="processing"
        class="mt-4 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 disabled:bg-gray-400"
      >
        <span v-if="processing">process...</span>
        <span v-else>Pay ${{ amount }}</span>
      </button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onBeforeUnmount } from 'vue'
  import { loadStripe } from '@stripe/stripe-js'
  
  const props = defineProps({
    publishableKey: {
      type: String,
      required: true
    },
    clientSecret: {
      type: String,
      required: true
    },
    amount: {
      type: Number,
      required: true
    }
  })
  
  const emit = defineEmits(['payment-success', 'payment-error'])
  
  const cardElement = ref(null)
  const stripe = ref(null)
  const elements = ref(null)
  const card = ref(null)
  const errorMessage = ref('')
  const processing = ref(false)
  
  // init Stripe
  const initializeStripe = async () => {
    try {
      stripe.value = await loadStripe(props.publishableKey)
      const elementsInstance = stripe.value.elements({
        locale: 'en'
      })
      elements.value = elementsInstance
      
      // element
      const cardOptions = {
        hidePostalCode: true,
        style: {
          base: {
            fontSize: '16px',
            color: '#32325d',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a'
          }
        }
      }
      
      card.value = elementsInstance.create('card', cardOptions)
      card.value.mount(cardElement.value)
      
      // on change
      card.value.on('change', (event) => {
        errorMessage.value = event.error?.message || ''
      })
    } catch (error) {
      console.error('Failed to initialize Stripe:', error)
      errorMessage.value = 'init failed please try again'
    }
  }
  
  // submit 
  const submitPayment = async () => {
    if (processing.value) return
    
    processing.value = true
    errorMessage.value = ''
    
    try {
      const { error, paymentIntent } = await stripe.value.confirmCardPayment(
        props.clientSecret,
        {
          payment_method: {
            card: card.value
          }
        }
      )
      
      if (error) {
        errorMessage.value = error.message
        emit('payment-error', error)
      } else if (paymentIntent.status === 'succeeded') {
        emit('payment-success', paymentIntent)
      }
    } catch (error) {
      console.error('Payment error:', error)
      errorMessage.value = 'pay failed please try again'
      emit('payment-error', error)
    } finally {
      processing.value = false
    }
  }
  
  onMounted(() => {
    initializeStripe()
  })
  
  onBeforeUnmount(() => {
    if (card.value) {
      card.value.unmount()
    }
  })
  </script>
  
  <style>
  .stripe-card-element {
    padding: 10px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    margin-bottom: 10px;
  }
  </style>