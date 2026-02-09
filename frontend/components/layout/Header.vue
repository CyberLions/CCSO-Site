<template>
  <header class="header sticky top-0 z-50 transition-all duration-300" :class="{ 'is-pinned': isPinned }">
    <div class="header-top full-width transition-all duration-300" :class="{ 'bg-dark-pinned': isPinned, 'h-pinned': isPinned }">
      <div class="max-w-7xl mx-auto">
      <div class="flex items-center justify-between transition-all duration-300" :class="isPinned ? 'h-12 px-2 sm:px-4 lg:px-6' : 'h-20 px-4 sm:px-6 lg:px-8'">
        <!-- Logo and Brand -->
        <div class="flex items-center">
          <NuxtLink to="/" class="flex items-center group" :class="isPinned ? 'space-x-2' : 'space-x-4'">
            <div class="rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300" 
                 :class="isPinned ? 'w-8 h-8' : 'w-12 h-12'">
              <img src="@/assets/icons/icon.png" alt="CCSO Logo" class="rounded-lg transition-all duration-300" 
                   :class="isPinned ? 'w-8 h-8' : 'w-12 h-12'" />
            </div>
            <div class="text-left transition-all duration-300" 
                 :class="isPinned ? 'ml-3' : 'ml-4'">
              <h1 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors duration-200">
                CCSO
              </h1>
              <p class="text-sm text-gray-300 font-medium transition-all duration-300"
                 :class="isPinned ? 'opacity-0 h-0 overflow-hidden' : 'opacity-100 h-auto'">
                Competitive Cyber Security Organization
              </p>
            </div>
          </NuxtLink>
        </div>

        <!-- Desktop Navigation (hidden below 1200px) -->
        <nav class="hidden min-[1200px]:flex items-center space-x-8">
          <NuxtLink 
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
          </NuxtLink>
          <NuxtLink
            to="/join"
            class="join-btn ml-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200"
            :class="$route.path === '/join' ? 'join-btn-active' : ''"
          >
            Join
          </NuxtLink>
        </nav>

        <!-- Mobile menu button (visible below 1200px) -->
        <div class="min-[1200px]:hidden">
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

      <!-- Mobile Navigation (visible below 1200px) -->
      <div 
        v-show="isMobileMenuOpen"
        class="min-[1200px]:hidden border-t border-gray-700 bg-black/50 backdrop-blur-md"
      >
        <div class="px-2 pt-2 pb-3 space-y-1">
          <NuxtLink
            v-for="item in navigationItems"
            :key="item.name"
            :to="item.path"
            @click="isMobileMenuOpen = false"
            class="text-gray-300 hover:text-blue-400 hover:bg-slate-800 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200"
            :class="{ 'text-blue-400 bg-slate-800': $route.path === item.path }"
          >
            {{ item.name }}
          </NuxtLink>
          <NuxtLink
            to="/join"
            @click="isMobileMenuOpen = false"
            class="join-btn-mobile block text-center mx-3 mt-2 px-4 py-3 rounded-lg text-base font-semibold transition-all duration-200"
            :class="$route.path === '/join' ? 'join-btn-active' : ''"
          >
            Join
          </NuxtLink>
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
      { name: 'Resources', path: '/resources' },
      { name: 'Sponsors', path: '/sponsors' }
    ]

    let scrollTimeout = null
    let lastScrollY = 0
    const PIN_THRESHOLD = 80
    const UNPIN_THRESHOLD = 60 // Hysteresis: unpin at a lower scroll position
    const DEBOUNCE_DELAY = 10 // ms

    const handleScroll = () => {
      // Clear existing timeout
      if (scrollTimeout) {
        clearTimeout(scrollTimeout)
      }

      // Debounce the scroll event
      scrollTimeout = setTimeout(() => {
        const currentScrollY = window.scrollY
        
        // Only update if scroll position changed significantly
        if (Math.abs(currentScrollY - lastScrollY) < 5) {
          return
        }

        // Apply hysteresis to prevent flickering
        if (currentScrollY > PIN_THRESHOLD && !isPinned.value) {
          isPinned.value = true
        } else if (currentScrollY < UNPIN_THRESHOLD && isPinned.value) {
          isPinned.value = false
        }

        lastScrollY = currentScrollY
      }, DEBOUNCE_DELAY)
    }

    onMounted(() => {
      // Set initial state based on current scroll position
      lastScrollY = window.scrollY
      isPinned.value = window.scrollY > PIN_THRESHOLD
      
      // Use passive scroll listener for better performance
      window.addEventListener('scroll', handleScroll, { passive: true })
    })

    onUnmounted(() => {
      window.removeEventListener('scroll', handleScroll)
      if (scrollTimeout) {
        clearTimeout(scrollTimeout)
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
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  padding-top: 7px;
  z-index: 999;
  will-change: background-color, padding-top;
}

.bg-dark-pinned {
  background-color: rgba(14, 14, 14, 0.95) !important;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.h-pinned {
  padding-top: 2px !important;
}

.full-width {
  width: 100%;
}

/* Ensure smooth transitions for all animated elements */
.header {
  will-change: transform;
}

/* Prevent layout shifts during transitions */
.header * {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Join as button in header */
.join-btn {
  background: linear-gradient(135deg, #00458d, #003566);
  color: #fff;
  border: 2px solid rgba(255, 195, 0, 0.4);
}
.join-btn:hover {
  background: linear-gradient(135deg, #ffc300, #e6b000);
  color: #000814;
  border-color: #ffc300;
  box-shadow: 0 4px 14px rgba(255, 195, 0, 0.25);
}
.join-btn-active {
  background: linear-gradient(135deg, #ffc300, #e6b000);
  color: #000814;
  border-color: #ffc300;
}
.join-btn-mobile {
  background: linear-gradient(135deg, #00458d, #003566);
  color: #fff;
  border: 2px solid rgba(255, 195, 0, 0.4);
}
.join-btn-mobile:hover {
  background: linear-gradient(135deg, #ffc300, #e6b000);
  color: #000814;
  border-color: #ffc300;
}
.join-btn-mobile.join-btn-active {
  background: linear-gradient(135deg, #ffc300, #e6b000);
  color: #000814;
  border-color: #ffc300;
}
</style> 