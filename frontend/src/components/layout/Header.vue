<template>
  <header class="header sticky top-0 z-50 transition-all duration-300" :class="{ 'is-pinned': isPinned }">
    <div class="header-top full-width transition-all duration-300" :class="{ 'bg-dark-pinned': isPinned, 'h-pinned': isPinned }">
      <div class="max-w-7xl mx-auto">
      <div class="flex items-center justify-between transition-all duration-300" :class="isPinned ? 'h-12 px-2 sm:px-4 lg:px-6' : 'h-20 px-4 sm:px-6 lg:px-8'">
        <!-- Logo and Brand -->
        <div class="flex items-center">
          <router-link to="/" class="flex items-center group" :class="isPinned ? 'space-x-0' : 'space-x-3'">
            <div class="rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300" 
                 :class="isPinned ? 'w-8 h-8' : 'w-12 h-12'">
              <img src="@/assets/icons/icon.png" alt="CCSO Logo" class="rounded-lg transition-all duration-300" 
                   :class="isPinned ? 'w-8 h-8' : 'w-12 h-12'" />
            </div>
            <div class="text-left transition-all duration-300" 
                 :class="isPinned ? 'ml-2' : 'ml-3'">
              <h1 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors duration-200">
                CCSO
              </h1>
              <p class="text-sm text-gray-300 font-medium transition-all duration-300"
                 :class="isPinned ? 'opacity-0 h-0 overflow-hidden' : 'opacity-100 h-auto'">
                Competitive Cyber Security Organization
              </p>
            </div>
          </router-link>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center space-x-8">
          <router-link 
            v-for="item in navigationItems" 
            :key="item.name"
            :to="item.path"
            class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 relative group"
            :class="{ 'text-blue-400': $route.path === item.path }"
          >
            {{ item.name }}
            <span 
              v-if="$route.path === item.path"
              class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 rounded-full"
            ></span>
          </router-link>
        </nav>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="text-gray-300 hover:text-blue-400 p-2 rounded-md transition-colors duration-200"
          >
            <Bars3Icon 
              v-if="!isMobileMenuOpen"
              class="w-6 h-6" 
            />
            <XMarkIcon 
              v-else
              class="w-6 h-6" 
            />
          </button>
        </div>
      </div>
    </div>

      <!-- Mobile Navigation -->
      <div 
        v-show="isMobileMenuOpen"
        class="md:hidden border-t border-gray-700 bg-black/50 backdrop-blur-md"
      >
        <div class="px-2 pt-2 pb-3 space-y-1">
          <router-link
            v-for="item in navigationItems"
            :key="item.name"
            :to="item.path"
            @click="isMobileMenuOpen = false"
            class="text-gray-300 hover:text-blue-400 hover:bg-slate-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
            :class="{ 'text-blue-400 bg-slate-800': $route.path === item.path }"
          >
            {{ item.name }}
          </router-link>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

export default {
  name: 'Header',
  components: {
    Bars3Icon,
    XMarkIcon
  },
  setup() {
    const isMobileMenuOpen = ref(false)
    const isPinned = ref(false)
    
    const navigationItems = [
      { name: 'Home', path: '/' },
      { name: 'About', path: '/about' },
      { name: 'Get Involved', path: '/get-involved' },
      { name: 'Competitions', path: '/competitions' },
      { name: 'Mixer', path: '/mixer' },
      { name: 'Sponsors', path: '/sponsors' }
    ]

    let observer = null

    const handleScroll = () => {
      isPinned.value = window.scrollY > 100
    }

    onMounted(() => {
      window.addEventListener('scroll', handleScroll)
    })

    onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll)
      if (observer) {
        observer.disconnect()
      }
    })

    return {
      isMobileMenuOpen,
      isPinned,
      navigationItems
    }
  }
}
</script>

<style scoped>
.header-top {
  background-color: transparent;
  transition: all 0.4s ease;
  padding-top: 7px;
  z-index: 999;
}

.bg-dark-pinned {
  background-color: rgba(14, 14, 14, 0.91) !important;
}

.h-pinned {
  padding-top: 2px !important;
}

.full-width {
  width: 100%;
}
</style> 