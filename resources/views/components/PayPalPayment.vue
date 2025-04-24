<template>
    <div class="paypal-payment">
      <!-- PayPal 按钮容器 -->
      <div ref="paypalButton" class="paypal-button-container"></div>
      
      <!-- 状态消息 -->
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
      default: 'capture', // 或 'authorize'
      validator: value => ['capture', 'authorize'].includes(value)
    }
  })
  
  const emit = defineEmits(['payment-approved', 'payment-completed', 'payment-error'])
  
  const paypalButton = ref(null)
  const statusMessage = ref('')
  const statusClass = ref('bg-blue-100 text-blue-800')
  let paypalButtons = null
  
  // 加载 PayPal SDK
  const loadPayPalSDK = () => {
    return new Promise((resolve) => {
      const script = document.createElement('script')
      script.src = `https://www.paypal.com/sdk/js?client-id=${props.clientId}&currency=${props.currency}`
      script.onload = resolve
      document.body.appendChild(script)
    })
  }
  
  // 初始化 PayPal 按钮
  const initializePayPal = async () => {
    try {
      statusMessage.value = '正在加载 PayPal...'
      
      // 加载 SDK
      await loadPayPalSDK()
      
      // 检查是否已加载
      if (!window.paypal) {
        throw new Error('PayPal SDK 未能正确加载')
      }
      
      statusMessage.value = '正在准备支付...'
      
      // 渲染按钮
      paypalButtons = window.paypal.Buttons({
        style: {
          layout: 'vertical',
          color: 'gold',
          shape: 'rect',
          label: 'paypal'
        },
        
        // 创建订单
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: props.amount.toFixed(2),
                currency_code: props.currency
              }
            }]
          })
        },
        
        // 批准后处理
        onApprove: (data, actions) => {
          statusMessage.value = '正在处理支付...'
          statusClass.value = 'bg-blue-100 text-blue-800'
          
          emit('payment-approved', data)
          
          return actions.order.capture().then((details) => {
            statusMessage.value = '支付成功!'
            statusClass.value = 'bg-green-100 text-green-800'
            emit('payment-completed', details)
          })
        },
        
        // 错误处理
        onError: (err) => {
          console.error('PayPal error:', err)
          statusMessage.value = `支付错误: ${err.message || '未知错误'}`
          statusClass.value = 'bg-red-100 text-red-800'
          emit('payment-error', err)
        },
        
        // 取消处理
        onCancel: (data) => {
          statusMessage.value = '您已取消支付'
          statusClass.value = 'bg-yellow-100 text-yellow-800'
        }
      })
      
      if (paypalButton.value && paypalButtons) {
        paypalButtons.render(paypalButton.value)
        statusMessage.value = ''
      }
    } catch (error) {
      console.error('PayPal initialization failed:', error)
      statusMessage.value = `无法加载 PayPal: ${error.message}`
      statusClass.value = 'bg-red-100 text-red-800'
    }
  }
  
  // 生命周期钩子
  onMounted(() => {
    initializePayPal()
  })
  
  onBeforeUnmount(() => {
    // 清理 PayPal 按钮
    if (paypalButton.value) {
      paypalButton.value.innerHTML = ''
    }
  })
  </script>
  
  <style>
  .paypal-button-container {
    min-height: 40px; /* 确保有足够空间显示按钮 */
    margin: 1rem 0;
  }
  </style>