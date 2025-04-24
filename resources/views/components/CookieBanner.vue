<template>
  <div v-if="showBanner" class="fixed inset-x-0 bottom-0 z-50 bg-white shadow-lg border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex-1">
          <h2 class="text-lg font-bold text-gray-900 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1 -mt-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
            </svg>
            We use cookies
          </h2>
          
          <p class="text-sm text-gray-600">
            We use cookies to improve your experience.
            <a :href="policyUrl" class="text-blue-600 hover:text-blue-800 underline">
              Learn more about our privacy policy
            </a>.
          </p>

          <div v-if="showDetails" class="mt-4 space-y-3">
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  id="cookie-necessary"
                  v-model="categories.necessary"
                  type="checkbox"
                  disabled
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
              </div>
              <div class="ml-3 text-sm">
                <label for="cookie-necessary" class="font-medium text-gray-700">
                  Necessary Cookies
                </label>
                <p class="text-gray-500">These cookies are required for the website to function.</p>
              </div>
            </div>

            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  id="cookie-analytics"
                  v-model="categories.analytics"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
              </div>
              <div class="ml-3 text-sm">
                <label for="cookie-analytics" class="font-medium text-gray-700">
                  Analytics Cookies
                </label>
                <p class="text-gray-500">These cookies help us analyze traffic and improve our website.</p>
              </div>
            </div>

            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  id="cookie-marketing"
                  v-model="categories.marketing"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
              </div>
              <div class="ml-3 text-sm">
                <label for="cookie-marketing" class="font-medium text-gray-700">
                  Marketing Cookies
                </label>
                <p class="text-gray-500">These cookies help us deliver targeted advertisements.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
          <template v-if="!showDetails">
            <button
              @click="acceptAll"
              class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Accept All
            </button>
            <button
              @click="showDetails = true"
              class="px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Customize Preferences
            </button>
          </template>

          <template v-else>
            <button
              @click="savePreferences"
              class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Save Preferences
            </button>
            <button
              @click="rejectAll"
              class="px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-md border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Reject All
            </button>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  policyUrl: {
    type: String,
    default: '/privacy-policy#cookies'
  }
});

const showBanner = ref(false);
const showDetails = ref(false);
const categories = ref({
  necessary: true,
  analytics: false,
  marketing: false
});

onMounted(async () => {
  try {

    const response = await axios.get('/api/cookie-consent');
    if (response.data.consent) {
      categories.value = response.data.consent.categories;
    } else {
      showBanner.value = true;
    }
  } catch (error) {
    console.error('Error checking cookie consent:', error);
    showBanner.value = true;
  }
});

const acceptAll = () => {
  categories.value = {
    necessary: true,
    analytics: true,
    marketing: true
  };
  savePreferences();
};

const rejectAll = () => {
  categories.value = {
    necessary: true, // Necessary cookies cannot be rejected
    analytics: false,
    marketing: false
  };
  savePreferences();
};

const savePreferences = async () => {
  try {
    const response = await axios.post(route('cookie-consent.store'), categories.value);
    if (response.data.success) {
      showBanner.value = false;
      window.location.reload(); // Reload to apply consent settings
    }
  } catch (error) {
    console.error('Error saving cookie preferences:', error);
  }
};
</script>
