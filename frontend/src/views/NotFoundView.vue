<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center max-w-md mx-auto px-4">
      <div class="mb-8">
        <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
        </div>
        <h1 class="text-6xl font-bold text-primary-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Page Not Found</h2>
        <p class="text-gray-600 mb-8">
          Looks like this page got lost! Don't worry, we'll help you find your way back.
        </p>
      </div>

      <div class="space-y-4">
        <router-link to="/" class="btn-primary w-full">
          Go Home
        </router-link>
        <router-link to="/connect" class="btn-outline w-full">
          Contact Us
        </router-link>
      </div>

      <div class="mt-12 text-sm text-gray-500">
        <p>Or try one of these popular pages:</p>
        <div class="flex flex-wrap justify-center gap-4 mt-4">
          <router-link to="/about" class="text-primary-600 hover:text-primary-700">
            About
          </router-link>
          <router-link to="/how-it-works" class="text-primary-600 hover:text-primary-700">
            How It Works
          </router-link>
          <router-link to="/schools" class="text-primary-600 hover:text-primary-700">
            Schools
          </router-link>
          <router-link to="/parents" class="text-primary-600 hover:text-primary-700">
            Parents
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFoundView'
}
</script> 