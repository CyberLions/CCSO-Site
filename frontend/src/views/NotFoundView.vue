<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="home-about">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="row top-about featured-section">
          <h2 class="section-title">&lt;404 - Page Not Found/&gt;</h2>
          <div class="text-center max-w-2xl mx-auto">
            <div class="mb-8">
              <div class="w-32 h-32 bg-gradient-to-br from-yaleblue to-argentinianblue rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl border-4 border-naplesyellow">
                <svg class="w-16 h-16 text-seasalt" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
              </div>
              <h1 class="text-8xl font-bold text-naplesyellow mb-4 font-mono">404</h1>
              <h2 class="text-3xl font-semibold text-seasalt mb-4">Page Not Found</h2>
              <p class="text-seasalt text-lg mb-8 leading-relaxed">
                Looks like this page got lost in the digital void! Don't worry, we'll help you navigate back to safety.
              </p>
            </div>

            <div class="space-y-4 mb-12">
              <router-link to="/" class="btn-primary w-full max-w-xs mx-auto">
                <HomeIcon class="w-5 h-5 mr-2" />
                Return Home
              </router-link>
              <router-link to="/about" class="btn-outline w-full max-w-xs mx-auto">
                <InformationCircleIcon class="w-5 h-5 mr-2" />
                About Us
              </router-link>
            </div>

            <div class="mt-12">
              <p class="text-seasalt text-sm mb-4">Or explore these popular destinations:</p>
              <div class="flex flex-wrap justify-center gap-6">
                <router-link to="/resources" class="text-argentinianblue hover:text-naplesyellow transition-colors duration-200 font-medium">
                  Resources
                </router-link>
                <router-link to="/competitions" class="text-argentinianblue hover:text-naplesyellow transition-colors duration-200 font-medium">
                  Competitions
                </router-link>
                <router-link to="/sponsors" class="text-argentinianblue hover:text-naplesyellow transition-colors duration-200 font-medium">
                  Sponsors
                </router-link>
                <router-link to="/get-involved" class="text-argentinianblue hover:text-naplesyellow transition-colors duration-200 font-medium">
                  Get Involved
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { HomeIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

export default {
  name: 'NotFoundView',
  components: {
    HomeIcon,
    InformationCircleIcon
  }
}
</script> 