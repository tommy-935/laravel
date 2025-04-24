<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Refund Policy
        </h1>
        <p class="mt-3 text-xl text-gray-500">
          Last updated: {{ currentDate }}
        </p>
      </div>

      <!-- Policy Content -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-6 py-8 sm:p-10">
          <div class="prose max-w-none">
            <!-- Introduction -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Our 14-Day Money Back Guarantee</h2>
              <p class="text-gray-600">
                At {{ companyName }}, we stand behind our premium WordPress plugins and themes. If you're not completely satisfied with your purchase, we offer a full refund within <strong>14 days</strong> of your original purchase date.
              </p>
            </section>

            <!-- Eligibility -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Refund Eligibility</h2>
              <p class="text-gray-600 mb-4">
                To qualify for a refund:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Your request must be made within 14 days of purchase</li>
                <li>The product must not have been significantly used (we reserve the right to check usage logs)</li>
                <li>You must provide a valid reason for your refund request</li>
                <li>You must allow us to attempt to resolve any technical issues first</li>
              </ul>
              <p class="text-gray-600">
                Refunds will not be granted after 14 days or if the product has been extensively used in a live environment.
              </p>
            </section>

            <!-- Non-Refundable Items -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Non-Refundable Items</h2>
              <p class="text-gray-600 mb-2">
                The following are not eligible for refunds:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>Renewal payments for license keys</li>
                <li>Products purchased during sale periods (unless defective)</li>
                <li>Custom development services</li>
                <li>Products where the license key has been shared or resold</li>
              </ul>
            </section>

            <!-- How to Request -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">4. How to Request a Refund</h2>
              <p class="text-gray-600 mb-4">
                To request a refund:
              </p>
              <ol class="list-decimal pl-6 space-y-2 text-gray-600 mb-4">
                <li>Contact our support team at <a :href="`mailto:${supportEmail}`" class="text-indigo-600 hover:underline">{{ supportEmail }}</a> within 14 days of purchase</li>
                <li>Include your order number and reason for the refund request</li>
                <li>Allow 1-2 business days for processing</li>
              </ol>
              <p class="text-gray-600">
                We may ask for additional information to help improve our products.
              </p>
            </section>

            <!-- Processing -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Refund Processing</h2>
              <p class="text-gray-600 mb-4">
                Approved refunds will be processed within 5-10 business days to your original payment method. The timeframe for the refund to appear in your account depends on your payment provider:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>Credit/Debit Cards: 3-5 business days</li>
                <li>PayPal: Immediately to 24 hours</li>
                <li>Bank Transfers: 5-10 business days</li>
              </ul>
            </section>

            <!-- License Deactivation -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">6. License Deactivation</h2>
              <p class="text-gray-600">
                Upon refund approval, your license key will be deactivated and the product should be removed from all sites. Continued use after refund constitutes a violation of our terms.
              </p>
            </section>

            <!-- Exceptions -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Exceptions</h2>
              <p class="text-gray-600 mb-4">
                We may make exceptions to this policy in cases of:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Duplicate purchases</li>
                <li>Unauthorized transactions</li>
                <li>Defective products we cannot fix</li>
              </ul>
              <p class="text-gray-600">
                All exceptions are granted at our sole discretion.
              </p>
            </section>

            <!-- Contact -->
            <section>
              <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Contact Us</h2>
              <p class="text-gray-600">
                For any questions about our refund policy:
              </p>
              <address class="not-italic mt-4 text-gray-600">
                {{ companyName }}<br>
                Email: <a :href="`mailto:${supportEmail}`" class="text-indigo-600 hover:underline">{{ supportEmail }}</a><br>
                Support Portal: <a :href="websiteUrl + '/support'" class="text-indigo-600 hover:underline">{{ websiteUrl }}/support</a>
              </address>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const currentDate = ref(new Date().toLocaleDateString('en-US', {
  year: 'numeric',
  month: 'long',
  day: 'numeric'
}));

// Customize these values
const companyName = ref('WP Premium Plugins');
const websiteUrl = ref('https://wppremiumplugins.com');
const supportEmail = ref('support@wppremiumplugins.com');
</script>

<style scoped>
.prose a {
  @apply transition-colors duration-200;
}
</style>