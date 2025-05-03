<template>
  <div class="border rounded-2xl p-6 shadow-md relative bg-white">
    <div v-if="popular" class="absolute -top-3 -right-3 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
      Most Popular
    </div>

    <h3 class="text-xl font-semibold mb-2">{{ name }}</h3>
    <p class="text-3xl font-bold text-blue-600 mb-4">{{ price }}</p>

    <ul class="text-gray-700 space-y-2 mb-6">
      <li v-for="(feature, i) in features" :key="i">
        <span v-if="feature[planKey]">✔️</span>
        <span v-else>❌</span>
        <span class="ml-2">
          {{ feature.name }}
          <span v-if="feature.note" class="ml-1 relative group cursor-pointer text-sm text-blue-500">
            ⓘ
            <span
              class="absolute hidden group-hover:block bg-black text-white text-xs p-2 rounded shadow-lg z-10 top-6 left-0 w-48"
            >
              {{ feature.note }}
            </span>
          </span>
        </span>
      </li>
    </ul>

    <!-- Pro Plan Button -->
    <a
      v-if="planKey === 'pro'"
      @click="addToCart"
      class="block w-full text-center px-4 py-2 rounded-full transition cursor-pointer"
      :class="popular ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'"
    >
      {{ button.text }}
    </a>

    <!-- Other Plan Buttons -->
    <a
      v-else
      :href="button.link"
      class="block w-full text-center px-4 py-2 rounded-full transition"
      :class="popular ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'"
    >
      {{ button.text }}
    </a>
  </div>
</template>

<script setup>
defineProps({
  name: String,
  price: String,
  features: Array,
  planKey: String,
  popular: Boolean,
  button: Object,
  // Receive 'addToCart' function from parent
  addToCart: Function,
})
</script>
