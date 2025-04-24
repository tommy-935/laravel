<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Terms and Conditions
        </h1>
        <p class="mt-3 text-xl text-gray-500">
          Last updated: {{ currentDate }}
        </p>
      </div>

      <!-- Content -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-6 py-8 sm:p-10">
          <div class="prose max-w-none">
            <!-- Introduction -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
              <p class="text-gray-600">
                These Terms and Conditions ("Terms") govern your use of {{ companyName }} ("we", "us", or "our") website located at {{ websiteUrl }} and all related services, including but not limited to the purchase and use of our WordPress plugins and themes ("Products").
              </p>
              <p class="text-gray-600 mt-4">
                By accessing or using our Products, you agree to be bound by these Terms. If you disagree with any part of these Terms, you may not access our Products.
              </p>
            </section>

            <!-- Accounts -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">2. User Accounts</h2>
              <p class="text-gray-600 mb-4">
                When creating an account with us:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>You must provide accurate and complete information</li>
                <li>You are responsible for maintaining account security</li>
                <li>You must notify us immediately of any unauthorized use</li>
                <li>We reserve the right to suspend or terminate accounts that violate these Terms</li>
              </ul>
            </section>

            <!-- License -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Product Licenses</h2>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">3.1 Grant of License</h3>
              <p class="text-gray-600 mb-4">
                Upon purchase, we grant you a non-exclusive, non-transferable license to:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-6">
                <li>Use the Product on a single WordPress installation (unless multi-site license purchased)</li>
                <li>Receive updates and support for the duration of your active subscription</li>
                <li>Make necessary modifications for your personal use</li>
              </ul>

              <h3 class="text-lg font-semibold text-gray-800 mb-2">3.2 Restrictions</h3>
              <p class="text-gray-600 mb-2">
                You may not:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>Resell, redistribute, or sublicense the Product</li>
                <li>Share license keys with third parties</li>
                <li>Use the Product in violation of GPL licensing terms (where applicable)</li>
                <li>Reverse engineer or decompile the Product</li>
                <li>Use the Product for illegal purposes</li>
              </ul>
            </section>

            <!-- Payments -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Payments and Renewals</h2>
              <p class="text-gray-600 mb-4">
                All Product prices are in {{ currency }}. By purchasing:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>You agree to pay the specified fees</li>
                <li>Annual subscriptions automatically renew unless canceled at least 24 hours before renewal</li>
                <li>We may change prices with 30 days notice to existing customers</li>
                <li>Refunds are governed by our Refund Policy</li>
              </ul>
              <p class="text-gray-600">
                We use third-party payment processors and do not store your full payment details.
              </p>
            </section>

            <!-- Support -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Support Policy</h2>
              <p class="text-gray-600 mb-4">
                Our support includes:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Bug fixes and troubleshooting</li>
                <li>Basic installation guidance</li>
                <li>Compatibility updates for current WordPress versions</li>
              </ul>
              <p class="text-gray-600">
                Support does not include:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>Custom development or modifications</li>
                <li>Support for third-party plugins/theme conflicts</li>
                <li>Support for outdated WordPress versions</li>
              </ul>
            </section>

            <!-- Intellectual Property -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Intellectual Property</h2>
              <p class="text-gray-600 mb-4">
                All Products remain our exclusive property. You receive:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>A license to use the Product as specified</li>
                <li>No transfer of copyright or ownership</li>
                <li>No rights to our trademarks or branding</li>
              </ul>
            </section>

            <!-- Termination -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Termination</h2>
              <p class="text-gray-600 mb-4">
                We may terminate your license if you:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Violate these Terms</li>
                <li>Fail to make required payments</li>
                <li>Use the Product illegally or maliciously</li>
              </ul>
              <p class="text-gray-600">
                Upon termination, you must cease all use of the Product and delete all copies.
              </p>
            </section>

            <!-- Disclaimers -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Disclaimers</h2>
              <p class="text-gray-600 mb-4">
                Our Products are provided "as is" without warranties of:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Merchantability</li>
                <li>Fitness for a particular purpose</li>
                <li>Non-infringement</li>
              </ul>
              <p class="text-gray-600">
                We do not guarantee uninterrupted or error-free operation.
              </p>
            </section>

            <!-- Liability -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Limitation of Liability</h2>
              <p class="text-gray-600">
                In no event shall we be liable for any indirect, incidental, or consequential damages arising from Product use. Our total liability shall not exceed the amount you paid for the Product.
              </p>
            </section>

            <!-- Changes -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Changes to Terms</h2>
              <p class="text-gray-600 mb-4">
                We may modify these Terms at any time. Material changes will be:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>Posted on our website with a new "Last updated" date</li>
                <li>Communicated via email to active customers</li>
              </ul>
            </section>

            <!-- Governing Law -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Governing Law</h2>
              <p class="text-gray-600">
                These Terms shall be governed by the laws of {{ governingLaw }}, without regard to its conflict of law provisions.
              </p>
            </section>

            <!-- Contact -->
            <section>
              <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Contact Information</h2>
              <p class="text-gray-600">
                For questions about these Terms:
              </p>
              <address class="not-italic mt-4 text-gray-600">
                {{ companyName }}<br>
                {{ companyAddress }}<br>
                Email: <a :href="`mailto:${contactEmail}`" class="text-blue-600 hover:underline">{{ contactEmail }}</a>
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
const contactEmail = ref('legal@wppremiumplugins.com');
const companyAddress = ref('123 Developer Street, San Francisco, CA 94107, USA');
const currency = ref('USD');
const governingLaw = ref('California, United States');
</script>

<style scoped>
.prose a {
  @apply transition-colors duration-200;
}
</style>