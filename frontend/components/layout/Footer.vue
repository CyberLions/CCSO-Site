<template>
  <footer class="footer text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Contact Section -->
        <div class="text-center">
          <div class="flex flex-col items-center justify-center mb-4">
            <div class="w-20 h-20 rounded-lg flex items-center justify-center mb-3">
              <img src="@/assets/icons/icon.png" alt="CCSO Logo" class="w-20 h-20 rounded-lg" />
            </div>
            <div class="text-center">
              <h3 class="text-xl font-bold text-white">CCSO</h3>
              <p class="text-gray-300 text-sm">Competitive Cyber Security Organization</p>
            </div>
          </div>
          <div class="space-y-2">
            <div class="flex items-center justify-center space-x-2">
              <MapPinIcon class="w-4 h-4 text-blue-400" />
              <span class="text-sm">
                288 N. Burrowes Rd.<br/>
                State College, PA 16802
              </span>
            </div>
            <div class="flex items-center justify-center space-x-2">
              <PhoneIcon class="w-4 h-4 text-blue-400" />
              <a href="tel:8148658947" class="text-sm hover:text-blue-400 transition-colors">
                (814) 865-8947
              </a>
            </div>
            <div class="flex items-center justify-center space-x-2">
              <EnvelopeIcon class="w-4 h-4 text-blue-400" />
              <a href="mailto:ccso@psu.edu" class="text-sm hover:text-blue-400 transition-colors">
                ccso@psu.edu
              </a>
            </div>
          </div>
        </div>

        <!-- Resources -->
        <div class="text-center">
          <h4 class="text-lg font-semibold mb-4 text-white">Resources</h4>
          <ul class="space-y-2">
            <li>
              <NuxtLink to="/sponsors" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">
                Sponsors
              </NuxtLink>
            </li>
            <li>
              <NuxtLink to="/sponsor-us" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">
                Sponsor Us
              </NuxtLink>
            </li>
            <li>
              <NuxtLink to="/competitions" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">
                Competitions
              </NuxtLink>
            </li>
            <li>
              <NuxtLink to="/resources" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">
                Helpful Sites
              </NuxtLink>
            </li>
            <li>
              <NuxtLink to="/resources" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">
                CPTC Guide
              </NuxtLink>
            </li>
            <li>
              <NuxtLink to="/events/mixer" class="text-gray-300 hover:text-blue-400 transition-colors duration-200">
                Networking Mixer
              </NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Social & Get Involved -->
        <div class="text-center flex flex-col items-center">
          <div class="mb-6">
            <NuxtLink
              to="/get-involved"
              class="inline-block gbm-button text-white font-semibold px-6 py-2 rounded-lg transition-colors duration-200 mb-4 text-lg uppercase"
            >
              Attend a GBM
            </NuxtLink>
          </div>
          <div class="flex space-x-4 justify-center">
            <a 
              href="https://discord.gg/NhN5RpBXkm" 
              target="_blank" 
              rel="noopener noreferrer"
              class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200"
            >
              <DiscordIcon :size="20" class="text-white" />
            </a>
            <a 
              href="https://www.linkedin.com/company/ccsopsu/" 
              target="_blank" 
              rel="noopener noreferrer"
              class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200"
            >
              <LinkedInIcon :size="20" class="text-white" />
            </a>
            <a 
              href="https://github.com/CyberLions" 
              target="_blank" 
              rel="noopener noreferrer"
              class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200"
            >
              <GitHubIcon :size="20" class="text-white" />
            </a>
            <a 
              href="https://www.instagram.com/ccsopsu/" 
              target="_blank" 
              rel="noopener noreferrer"
              class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200"
            >
              <InstagramIcon :size="20" class="text-white" />
            </a>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm">
          Copyright © CCSO {{ new Date().getFullYear() }} - All rights reserved
        </p>
        <p class="text-gray-400 text-sm mt-2 md:mt-0">
          Designed & Developed by 
          <a 
            href="https://www.linkedin.com/in/isabella-masso/" 
            target="_blank" 
            rel="noopener noreferrer"
            class="text-blue-400 hover:text-blue-300 transition-colors"
          >
            Isabella Masso
          </a>
          and
          <a 
            href="https://www.linkedin.com/in/aiden-johnson-cs/" 
            target="_blank" 
            rel="noopener noreferrer"
            class="text-blue-400 hover:text-blue-300 transition-colors"
          >
            Aiden Johnson 
          </a>
        </p>
      </div>
    </div>
  </footer>
</template>

<script>
import { 
  MapPinIcon, 
  EnvelopeIcon, 
  PhoneIcon
} from '@heroicons/vue/24/outline'
import DiscordIcon from '@/components/icons/DiscordIcon.vue'
import LinkedInIcon from '@/components/icons/LinkedInIcon.vue'
import GitHubIcon from '@/components/icons/GitHubIcon.vue'
import InstagramIcon from '@/components/icons/InstagramIcon.vue'

export default {
  name: 'Footer',
  components: {
    MapPinIcon,
    EnvelopeIcon,
    PhoneIcon,
    DiscordIcon,
    LinkedInIcon,
    GitHubIcon,
    InstagramIcon
  }
}
</script>

<style scoped>
.footer {
  position: relative;
  padding: 40px 0;
  background-color: rgba(14, 14, 14, 0.91);
  margin-top: 1em;
}

.gbm-button {
  background-color: rgb(0, 9, 102);
  width: 208px; /* Width of 4 buttons (40px each) + 3 gaps (16px each) = 160px + 48px = 208px */
}

.gbm-button:hover {
  background-color: rgb(0, 7, 85);
}
</style> 