<template>
    <div class="apple-pay-payment">
      <!-- Apple Pay 按钮容器 -->
      <button
        v-if="applePayAvailable"
        ref="applePayButton"
        class="apple-pay-button"
        @click="handleApplePayClick"
      ></button>
      
      <!-- 状态消息 -->
      <div v-if="statusMessage" class="mt-4 p-3 rounded" :class="statusClass">
        {{ statusMessage }}
      </div>
      
      <!-- 不支持 Apple Pay 的提示 -->
      <div v-if="!applePayAvailable" class="text-sm text-gray-500 mt-2">
        Apple Pay 不可用。请确保您使用的是 Safari 浏览器并已设置 Apple Pay。
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  
  const props = defineProps({
    amount: {
      type: Number,
      required: true
    },
    currency: {
      type: String,
      default: 'USD'
    },
    merchantIdentifier: {
      type: String,
      required: true
    },
    countryCode: {
      type: String,
      default: 'US'
    },
    label: {
      type: String,
      default: 'Buy with'
    }
  })
  
  const emit = defineEmits(['payment-authorized', 'payment-completed', 'payment-error'])
  
  const applePayButton = ref(null)
  const applePayAvailable = ref(false)
  const statusMessage = ref('')
  const statusClass = ref('bg-blue-100 text-blue-800')
  const paymentSession = ref(null)
  
  // 检查 Apple Pay 是否可用
  const checkApplePayAvailability = () => {
    if (!window.ApplePaySession) {
      return false
    }
    
    return ApplePaySession.canMakePaymentsWithActiveCard(props.merchantIdentifier)
      .then(canMakePayments => {
        applePayAvailable.value = canMakePayments
        return canMakePayments
      })
      .catch(error => {
        console.error('Apple Pay availability check failed:', error)
        return false
      })
  }
  
  // 初始化 Apple Pay
  const initializeApplePay = async () => {
    try {
      const isAvailable = await checkApplePayAvailability()
      
      if (isAvailable && applePayButton.value) {
        // 设置 Apple Pay 按钮样式
        applePayButton.value.style.display = 'inline-block'
        applePayButton.value.style.webkitAppearance = '-apple-pay-button'
        applePayButton.value.style.appearance = '-apple-pay-button'
        applePayButton.value.style.applePayButtonType = 'buy'
        applePayButton.value.style.applePayButtonStyle = 'black'
        applePayButton.value.style.height = '40px'
        applePayButton.value.style.width = '200px'
      }
    } catch (error) {
      console.error('Apple Pay initialization failed:', error)
      statusMessage.value = `无法初始化 Apple Pay: ${error.message}`
      statusClass.value = 'bg-red-100 text-red-800'
    }
  }
  
  // 处理 Apple Pay 按钮点击
  const handleApplePayClick = () => {
    if (!applePayAvailable.value) return
    
    statusMessage.value = '正在准备 Apple Pay...'
    statusClass.value = 'bg-blue-100 text-blue-800'
    
    // 创建支付请求
    const paymentRequest = {
      countryCode: props.countryCode,
      currencyCode: props.currency,
      merchantCapabilities: ['supports3DS', 'supportsCredit', 'supportsDebit'],
      supportedNetworks: ['visa', 'masterCard', 'amex', 'discover'],
      total: {
        label: props.label,
        amount: props.amount.toFixed(2)
      },
      // 可选: 添加行项目
      lineItems: [
        {
          label: '小计',
          amount: (props.amount * 0.9).toFixed(2) // 示例折扣
        },
        {
          label: '税费',
          amount: (props.amount * 0.1).toFixed(2)
        }
      ],
      // 可选: 添加配送方式
      shippingMethods: [
        {
          label: '标准配送',
          amount: '0.00',
          identifier: 'standard',
          detail: '3-5个工作日送达'
        },
        {
          label: '快递',
          amount: '5.99',
          identifier: 'express',
          detail: '1-2个工作日送达'
        }
      ]
    }
    
    // 创建 Apple Pay 会话
    paymentSession.value = new ApplePaySession(3, paymentRequest)
    
    // 设置会话事件处理器
    setupApplePaySessionHandlers()
    
    // 开始会话
    paymentSession.value.begin()
  }
  
  // 设置 Apple Pay 会话处理器
  const setupApplePaySessionHandlers = () => {
    if (!paymentSession.value) return
    
    // 验证商户
    paymentSession.value.onvalidatemerchant = (event) => {
      validateMerchant(event.validationURL)
        .then(merchantSession => {
          paymentSession.value.completeMerchantValidation(merchantSession)
        })
        .catch(error => {
          console.error('Merchant validation failed:', error)
          paymentSession.value.abort()
          statusMessage.value = '商户验证失败'
          statusClass.value = 'bg-red-100 text-red-800'
        })
    }
    
    // 支付授权
    paymentSession.value.onpaymentauthorized = (event) => {
      emit('payment-authorized', event.payment)
      
      // 这里应该调用你的后端API处理支付
      processPayment(event.payment)
        .then(() => {
          paymentSession.value.completePayment(ApplePaySession.STATUS_SUCCESS)
          statusMessage.value = '支付成功!'
          statusClass.value = 'bg-green-100 text-green-800'
          emit('payment-completed', event.payment)
        })
        .catch(error => {
          console.error('Payment processing failed:', error)
          paymentSession.value.completePayment(ApplePaySession.STATUS_FAILURE)
          statusMessage.value = `支付失败: ${error.message}`
          statusClass.value = 'bg-red-100 text-red-800'
          emit('payment-error', error)
        })
    }
    
    // 选择配送方法
    paymentSession.value.onshippingmethodselected = (event) => {
      // 根据选择的配送方式更新总额
      const newTotal = {
        label: props.label,
        amount: (props.amount + parseFloat(event.shippingMethod.amount)).toFixed(2)
      }
      
      const newLineItems = [
        {
          label: '小计',
          amount: (props.amount * 0.9).toFixed(2)
        },
        {
          label: '税费',
          amount: (props.amount * 0.1).toFixed(2)
        },
        {
          label: event.shippingMethod.label,
          amount: event.shippingMethod.amount
        }
      ]
      
      paymentSession.value.completeShippingMethodSelection(
        ApplePaySession.STATUS_SUCCESS,
        newTotal,
        newLineItems
      )
    }
    
    // 取消
    paymentSession.value.oncancel = () => {
      statusMessage.value = '您已取消支付'
      statusClass.value = 'bg-yellow-100 text-yellow-800'
    }
  }
  
  // 模拟商户验证 (实际项目中应调用后端API)
  const validateMerchant = (validationURL) => {
    return new Promise((resolve) => {
      // 这里应该调用你的后端API验证商户
      // 示例: return axios.post('/api/validate-apple-pay-merchant', { validationURL })
      
      // 模拟响应
      resolve({
        merchantSessionIdentifier: 'merchant_session_identifier',
        displayName: 'Your Store',
        initiative: 'web',
        initiativeContext: window.location.hostname,
        signature: 'signature',
        nonce: 'nonce',
        merchantIdentifier: props.merchantIdentifier,
        domainName: window.location.hostname,
        epochTimestamp: Date.now(),
        expiresAt: Date.now() + 3600000, // 1小时后过期
        operationalAnalyticsIdentifier: 'op_analytics_id'
      })
    })
  }
  
  // 模拟支付处理 (实际项目中应调用后端API)
  const processPayment = (payment) => {
    return new Promise((resolve) => {
      // 这里应该调用你的后端API处理支付
      // 示例: return axios.post('/api/process-apple-pay', { payment })
      
      // 模拟处理
      setTimeout(resolve, 1000)
    })
  }
  
  // 生命周期钩子
  onMounted(() => {
    initializeApplePay()
  })
  </script>
  
  <style>
  .apple-pay-button {
    display: none; /* 初始隐藏，确认可用后再显示 */
    cursor: pointer;
    margin: 10px 0;
  }
  
  /* Apple Pay 按钮样式选项:
     -apple-pay-button-type: plain | buy | donate | check-out | book | subscribe
     -apple-pay-button-style: white | white-outline | black
  */
  </style>