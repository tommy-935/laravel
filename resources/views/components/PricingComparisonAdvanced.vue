<template>
    <section class="max-w-7xl mx-auto px-4 py-16">
      <h2 class="text-3xl font-bold text-center mb-10">{{ title }}</h2>
  
      <!-- Billing Cycle Toggle -->
<div v-if="billingOptions.length >= 1" class="flex justify-center mb-8">
  <template v-for="(option, index) in billingOptions" :key="option">
    <button
      @click="billingCycle = option"
      :class="[
        'px-4 py-2 border',
        index === 0 && billingOptions.length > 1 ? 'rounded-l-full' : '',
        index === billingOptions.length - 1 && billingOptions.length > 1 ? 'rounded-r-full' : '',
        billingOptions.length === 1 ? 'rounded-full' : '',
        index > 0 ? 'border-l-0' : '',
        billingCycle === option ? activeTab : inactiveTab
      ]"
    >
      {{ formatLabel(option) }}
    </button>
  </template>
</div>

      <!-- Pricing Cards -->
      <div
        :class="[
          'grid gap-6',
          teamEnabled ? 'md:grid-cols-3' : 'md:grid-cols-2',
        ]"
      >
        <PricingCard
          name="Free"
          :price="plans.free.price"
          :features="features"
          planKey="free"
          :button="{ text: 'Get Free', link: freeLink }"
        />
  
        <PricingCard
          name="Pro"
          :price="getPlanPrice(plans.pro)"
          :features="features"
          planKey="pro"
          :popular="true"
          :button="{ text: 'Upgrade to Pro', link: proLink }"
          :addToCart="addToCart"
        />
  
        <PricingCard
          v-if="teamEnabled"
          name="Team"
          :price="getPlanPrice(plans.team)"
          :features="features"
          planKey="team"
          :button="{ text: 'Contact Sales', link: teamLink }"
        />
      </div>
    </section>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import PricingCard from './PricingCard.vue'
  const formatLabel = (key) => {
  switch (key) {
    case 'monthly': return 'Monthly'
    case 'yearly': return 'Yearly'
    case 'onetime': return 'One-Time'
    default: return key
  }
}

  const props = defineProps({
    title: { type: String, default: 'Compare Plans' },
    features: { type: Array, required: true },
    plans: { type: Object, required: true },
    billingOptions: {
      type: Array,
      default: () => ['monthly', 'yearly', 'onetime'],
    },
    teamEnabled: { type: Boolean, default: true },
    freeLink: { type: String, default: '/download' },
    proLink: { type: String, default: '/pro' },
    teamLink: { type: String, default: '/contact' },
    addToCart: { type: Function, default: () => {} },
  })
  
  const billingCycle = ref(
  props.billingOptions.find(opt => ['monthly', 'yearly'].includes(opt)) || props.billingOptions[0]
)

const getPlanPrice = (plan) => {
  if (plan[billingCycle.value]) {
    return plan[billingCycle.value]
  }
  return '$--'
}
  
  const activeTab = 'bg-blue-600 text-white'
  const inactiveTab = 'bg-white text-gray-700'
  </script>
  