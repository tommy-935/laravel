<template>
    <div class="paypal-payment">
      <!-- PayPal -->
      <div ref="paypalButton" class="paypal-button-container"></div>
      
      <!-- statusMessage -->
      <div v-if="statusMessage" class="mt-4 p-3 rounded" :class="statusClass">
        {{ statusMessage }}
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onBeforeUnmount } from 'vue'
  
  const props = defineProps({
    amount: {
      type: Number,
      required: true
    },
    currency: {
      type: String,
      default: 'USD'
    },
    clientId: {
      type: String,
      required: true
    },
    intent: {
      type: String,
      default: 'capture', // or 'authorize'
      validator: value => ['capture', 'authorize'].includes(value)
    }
  })
  
  const emit = defineEmits(['payment-approved', 'payment-completed', 'payment-error'])
  
  const paypalButton = ref(null)
  const statusMessage = ref('')
  const statusClass = ref('bg-blue-100 text-blue-800')
  let paypalButtons = null
  
  // load PayPal SDK
  const loadPayPalSDK = () => {
    return new Promise((resolve) => {
      const script = document.createElement('script')
      script.src = `https://www.paypal.com/sdk/js?client-id=${props.clientId}&currency=${props.currency}`
      script.onload = resolve
      document.body.appendChild(script)
    })
  }
  
  // init PayPal button
  const initializePayPal = async () => {
    try {
      statusMessage.value = 'loading PayPal...'
      
      // load SDK
      await loadPayPalSDK()
      
      // check if SDK is loaded
      if (!window.paypal) {
        throw new Error('PayPal SDK can not be loaded')
      }
      
      statusMessage.value = 'now initializing PayPal...'
      
      // render PayPal button
      paypalButtons = window.paypal.Buttons({
        style: {
          layout: 'vertical',
          color: 'gold',
          shape: 'rect',
          label: 'paypal'
        },
        
        // create order
        createOrder: (data, actions) => {
          // create order in backend
          fetch('/checkout/process', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              amount: props.amount,
              currency: props.currency,
              intent: props.intent
            })
          }).then(response => response.json())
          .then(result => {
              if (result.status) {
                  alert('success verify');
                  const data = result.data;
                  return actions.order.create({
                    purchase_units: [{
                      amount: {
                        value: data.amount,
                        currency_code: data.currency
                      },
                      order_id: data.order_id
                    }]
                  })
              } else {
                  alert('verify failed');
              }
          }).catch((error) => {
              console.error('PayPal verification failed:', error);
          })
          
        },
        
        // deal with payment approval
        onApprove: (data, actions) => {
          statusMessage.value = 'processing payment...'
          statusClass.value = 'bg-blue-100 text-blue-800'
          
          emit('payment-approved', data)
          
          return actions.order.capture().then((details) => {
            statusMessage.value = 'payment processed successfully!'
            statusClass.value = 'bg-green-100 text-green-800'
            // check order and update order status in backend
            fetch('/paypal/capture', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    orderID: data.orderID
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.status) {
                  emit('payment-completed', details, result.data)
                } else {
                    alert('verify failed');
                }
            });
            
          })
        },
        
        // error
        onError: (err) => {
          console.error('PayPal error:', err)
          statusMessage.value = `failed: ${err.message || 'nokown error'}`
          statusClass.value = 'bg-red-100 text-red-800'
          emit('payment-error', err)
        },
        
        // cancel
        onCancel: (data) => {
          statusMessage.value = 'canceled'
          statusClass.value = 'bg-yellow-100 text-yellow-800'
        }
      })
      
      if (paypalButton.value && paypalButtons) {
        paypalButtons.render(paypalButton.value)
        statusMessage.value = ''
      }
    } catch (error) {
      console.error('PayPal initialization failed:', error)
      statusMessage.value = `can not load PayPal: ${error.message}`
      statusClass.value = 'bg-red-100 text-red-800'
    }
  }
  
  onMounted(() => {
    initializePayPal()
  })
  
  onBeforeUnmount(() => {
    if (paypalButton.value) {
      paypalButton.value.innerHTML = ''
    }
  })
  </script>
  
  <style>
  .paypal-button-container {
    min-height: 40px; 
    margin: 1rem 0;
  }
  </style>