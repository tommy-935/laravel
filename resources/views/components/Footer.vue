<template>
    <footer class="bg-[#f8f9fa] text-gray-700 py-8 px-4 md:px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-8">
        <!-- Quick Links Section -->
        <div class="flex-1 space-y-4">
          <h3 class="text-lg font-bold uppercase">QUICK LINKS</h3>
          <div>
            <h4 class="font-semibold mb-2">Products</h4>
            <ul class="space-y-1">
              <li><a href="https://wordpress.org/plugins/lymos-smtp-email/" class="hover:text-blue-600">Lymos Smtp Email</a></li>
              <li v-if="false"><a href="#" class="hover:text-blue-600">WooCommerce Smart Coupons</a></li>
            </ul>
          </div>
          <ul class="space-y-1">
            <li><a href="/about-us" class="hover:text-blue-600">About Us</a></li>
            <li><a href="mailto:lymoswp@gmail.com" class="hover:text-blue-600">Contact Us</a></li>
          </ul>
        </div>
  
        <!-- Get In Touch Section -->
        <div class="flex-1 space-y-4">
          <h3 class="text-lg font-bold uppercase">GET IN TOUCH</h3>
          <div>
            <h4 class="font-semibold">Lymoswp</h4>
            <p class="mt-2">Auburn Alabama</p>
            <p>US – 36830</p>
          </div>
          <div>
            <p class="font-semibold mt-4">Also from us:</p>
            <ul class="flex flex-wrap gap-2 mt-2">
              <li><a href="https://profiles.wordpress.org/lymoswp/" class="hover:text-blue-600">Wordpress.org</a></li>
              <li v-if="false">|</li>
              <li v-if="false"><a href="#" class="hover:text-blue-600">None</a></li>
              
            </ul>
          </div>
        </div>
  
        <!-- Partner With Us Section -->
        <div class="flex-1 space-y-4">
          <h3 class="text-lg font-bold uppercase">SOCIAL MEDIA</h3>
          <div v-if="false">
            <h4 class="font-semibold">Earn Up to 30%</h4>
            <a href="#" class="inline-block mt-2 text-blue-600 hover:underline">Join our partner program</a>
          </div>
          <div>
            <p class="font-semibold mt-4">Connect with us:</p>
            <div class="flex items-center space-x-4 mt-2">
              <a href="#" class="w-8 h-8 flex items-center justify-center border rounded-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                </svg>
              </a>
              <a href="#" class="w-8 h-8 flex items-center justify-center border rounded-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Copyright Section with Policy Links -->
    <div class="max-w-7xl mx-auto mt-8 pt-4 border-t border-gray-300">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
  <p class="mb-2 md:mb-0">Copyright © 2025 Lymoswp – All Rights Reserved.</p>
  <div class="flex flex-wrap gap-4 justify-start w-full md:w-auto">
    <a href="/privacy-policy" class="text-sm hover:text-blue-600 hover:underline">Privacy Policy</a>
    <a href="/refund-policy" class="text-sm hover:text-blue-600 hover:underline">Refund Policy</a>
    <a href="/terms-conditions" class="text-sm hover:text-blue-600 hover:underline">Terms & Conditions</a>
  </div>
</div>
    </div>
    </footer>
  </template>
  
  <script setup>
  // 不需要额外的逻辑，纯展示组件
  </script>