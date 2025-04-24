<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Privacy Policy
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
              <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
              <p class="text-gray-600 mb-4">
                At {{ companyName }}, we operate {{ websiteUrl }} ("the Site"), specializing in premium WordPress plugins and themes. We are committed to protecting your privacy and handling your data in an open and transparent manner.
              </p>
              <p class="text-gray-600">
                This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase from us.
              </p>
            </section>

            <!-- Data Collection -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Personal Data</h3>
              <p class="text-gray-600 mb-4">
                When you register, purchase, or interact with our site, we may collect:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-6">
                <li>Contact information (name, email address, phone number)</li>
                <li>Billing information (credit card details processed via secure payment gateways)</li>
                <li>Account credentials (username, encrypted password)</li>
                <li>Purchase history and download records</li>
                <li>Support ticket communications</li>
              </ul>

              <h3 class="text-lg font-semibold text-gray-800 mb-2">Automatically Collected Data</h3>
              <p class="text-gray-600 mb-2">
                Through cookies and similar technologies, we collect:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>IP address and device information</li>
                <li>Browser type and version</li>
                <li>Pages visited and time spent</li>
                <li>Referring website addresses</li>
                <li>License validation checks</li>
              </ul>
            </section>

            <!-- Data Usage -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
              <p class="text-gray-600 mb-4">
                We use collected data to:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Process transactions and deliver purchased products</li>
                <li>Provide customer support and handle refunds</li>
                <li>Verify software licenses and prevent piracy</li>
                <li>Send important account notifications and updates</li>
                <li>Improve our products and user experience</li>
                <li>Conduct security checks and fraud prevention</li>
                <li>Comply with legal obligations (tax, accounting)</li>
              </ul>
              <p class="text-gray-600">
                We will never sell your personal data to third parties.
              </p>
            </section>

            <!-- Data Sharing -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Data Sharing and Disclosure</h2>
              <p class="text-gray-600 mb-4">
                We may share information with:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li><strong>Payment Processors:</strong> Stripe, PayPal (only data necessary to complete transactions)</li>
                <li><strong>Service Providers:</strong> Email delivery (Mailchimp), analytics (Google Analytics), hosting (AWS)</li>
                <li><strong>Developers:</strong> For purchased products requiring support (only with your consent)</li>
                <li><strong>Legal Authorities:</strong> When required by law or to protect our rights</li>
              </ul>
              <p class="text-gray-600">
                All third parties are contractually obligated to maintain confidentiality and security.
              </p>
            </section>

            <!-- Cookies -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Cookies and Tracking</h2>
              <p class="text-gray-600 mb-4">
                We use cookies for:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Session management (keeping you logged in)</li>
                <li>Shopping cart functionality</li>
                <li>License validation and authentication</li>
                <li>Analytics to improve our services</li>
                <li>Advertising (retargeting via Facebook Pixel, Google Ads)</li>
              </ul>
              <p class="text-gray-600">
                You can manage cookies through browser settings, but some site features may not work properly without them.
              </p>
            </section>

            <!-- Data Retention -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Data Retention</h2>
              <p class="text-gray-600">
                We retain your personal data:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mt-2 mb-4">
                <li><strong>Account data:</strong> Until you request deletion (or 3 years after last activity)</li>
                <li><strong>Purchase records:</strong> 7 years for tax/accounting compliance</li>
                <li><strong>Support tickets:</strong> 2 years after resolution</li>
              </ul>
              <p class="text-gray-600">
                License validation data is stored indefinitely to prevent piracy.
              </p>
            </section>

            <!-- User Rights -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Your Rights</h2>
              <p class="text-gray-600 mb-4">
                Depending on your location (GDPR, CCPA, etc.), you may:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>Request access to your personal data</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your data (subject to legal requirements)</li>
                <li>Object to processing of your data</li>
                <li>Request data portability</li>
                <li>Withdraw consent (where applicable)</li>
                <li>Lodge complaints with regulatory authorities</li>
              </ul>
              <p class="text-gray-600">
                To exercise these rights, contact us at <a :href="`mailto:${supportEmail}`" class="text-indigo-600 hover:underline">{{ supportEmail }}</a>.
              </p>
            </section>

            <!-- Security -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Security Measures</h2>
              <p class="text-gray-600 mb-4">
                We implement:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-4">
                <li>SSL/TLS encryption for all data transfers</li>
                <li>Regular security audits and penetration testing</li>
                <li>Two-factor authentication for admin access</li>
                <li>Limited employee access to sensitive data</li>
                <li>Secure payment processing (we never store raw credit card data)</li>
              </ul>
              <p class="text-gray-600">
                Despite our efforts, no system is 100% secure. Please use strong passwords and notify us immediately of any suspected breaches.
              </p>
            </section>

            <!-- International Transfers -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">9. International Data Transfers</h2>
              <p class="text-gray-600">
                Our servers are located in {{ serverLocation }}, but we may transfer data to service providers in other countries. We ensure adequate protection through:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600 mt-2">
                <li>EU Standard Contractual Clauses</li>
                <li>Privacy Shield certification (where applicable)</li>
                <li>Data minimization principles</li>
              </ul>
            </section>

            <!-- Children -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Children's Privacy</h2>
              <p class="text-gray-600">
                Our services are not directed to individuals under 16. We do not knowingly collect data from children. If we become aware of such collection, we will take steps to delete it.
              </p>
            </section>

            <!-- Changes -->
            <section class="mb-10">
              <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Changes to This Policy</h2>
              <p class="text-gray-600 mb-4">
                We may update this policy periodically. Significant changes will be:
              </p>
              <ul class="list-disc pl-6 space-y-2 text-gray-600">
                <li>Posted on our website with a new "Last updated" date</li>
                <li>Communicated via email to account holders (for major changes)</li>
              </ul>
            </section>

            <!-- Contact -->
            <section>
              <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Contact Us</h2>
              <p class="text-gray-600">
                For privacy-related inquiries, please contact:
              </p>
              <address class="not-italic mt-4 text-gray-600">
                {{ companyName }}<br>
                Attn: Data Protection Officer<br>
                {{ companyAddress }}<br>
                Email: <a :href="`mailto:${privacyEmail}`" class="text-indigo-600 hover:underline">{{ privacyEmail }}</a><br>
                Phone: {{ companyPhone }}
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
const privacyEmail = ref('privacy@wppremiumplugins.com');
const companyAddress = ref('123 Developer Street, San Francisco, CA 94107, USA');
const companyPhone = ref('+1 (555) 123-4567');
const serverLocation = ref('the United States');
</script>

<style scoped>
.prose a {
  @apply transition-colors duration-200 ;
}
</style>