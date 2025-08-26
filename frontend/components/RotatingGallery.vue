<template>
  <div class="rotating-gallery">
    <div 
      v-for="(image, index) in displayedImages" 
      :key="`${image.id}-${currentSet}`"
      class="gallery-image"
      :class="{ 
        'fade-in': isVisible[index],
        'fade-out': !isVisible[index] 
      }"
      :style="{ 
        '--delay': `${index * 0.2}s`
      }"
    >
      <div class="image-container">
        <img 
          :src="getStrapiMediaUrl(image.url)" 
          :alt="image.alternativeText || 'Gallery image'"
          class="gallery-img"
          @load="onImageLoad"
        />
      </div>
    </div>
    
    <!-- Preload all images -->
    <div class="preload-container" style="display: none;">
      <img 
        v-for="image in allImages"
        :key="`preload-${image.id}`"
        :src="getStrapiMediaUrl(image.url)"
        class="preload-img"
      />
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { getStrapiMediaUrl } from '@/utils/api'

export default {
  name: 'RotatingGallery',
  props: {
    images: {
      type: Array,
      default: () => []
    },
    imagesPerView: {
      type: Number,
      default: 3
    },
    rotationInterval: {
      type: Number,
      default: 6000 // 6 seconds
    },
    transitionDuration: {
      type: Number,
      default: 1000 // 1 second for smooth transitions
    }
  },
  setup(props) {
    const currentSet = ref(0)
    const isVisible = ref([])
    const loadedImages = ref(new Set())
    const isTransitioning = ref(false)
    let rotationTimer = null

    // All images (for template rendering and preloading)
    const allImages = computed(() => {
      return props.images || []
    })

    // Get current set of images to display
    const displayedImages = computed(() => {
      if (!props.images || props.images.length === 0) return []
      
      const startIndex = (currentSet.value * props.imagesPerView) % props.images.length
      const images = []
      
      for (let i = 0; i < props.imagesPerView; i++) {
        const index = (startIndex + i) % props.images.length
        images.push(props.images[index])
      }
      
      return images
    })

    // Track image loading for preloading
    const onImageLoad = (event) => {
      const src = event.target.src
      loadedImages.value.add(src)
    }

    // Initialize visibility for fade animations
    const initializeVisibility = () => {
      isVisible.value = new Array(props.imagesPerView).fill(false)
    }

    // Fade out current images with smoother timing
    const fadeOut = () => {
      return new Promise((resolve) => {
        isTransitioning.value = true
        
        // Fade out each image with staggered timing
        displayedImages.value.forEach((_, index) => {
          setTimeout(() => {
            if (isVisible.value[index] !== undefined) {
              isVisible.value[index] = false
            }
          }, index * 200) // 200ms stagger (slower than before)
        })
        
        // Wait for all images to fade out completely
        setTimeout(resolve, (props.imagesPerView - 1) * 200 + 1200) // 1.2s fade duration
      })
    }

    // Fade in new images with smoother timing
    const fadeIn = () => {
      // Reset visibility for new images
      isVisible.value = new Array(props.imagesPerView).fill(false)
      
      // Fade in each image with staggered timing after a brief pause
      setTimeout(() => {
        displayedImages.value.forEach((_, index) => {
          setTimeout(() => {
            if (isVisible.value[index] !== undefined) {
              isVisible.value[index] = true
            }
          }, index * 200) // 200ms stagger between each image fade in
        })
        
        // Mark transition as complete
        setTimeout(() => {
          isTransitioning.value = false
        }, (props.imagesPerView - 1) * 200 + 1200)
      }, 150)
    }

    // Rotate to next set of images
    const rotateImages = async () => {
      if (!props.images || props.images.length <= props.imagesPerView || isTransitioning.value) return
      
      await fadeOut()
      currentSet.value = (currentSet.value + 1) % Math.ceil(props.images.length / props.imagesPerView)
      fadeIn()
    }

    // Start rotation timer
    const startRotation = () => {
      if (!props.images || props.images.length <= props.imagesPerView) return
      
      rotationTimer = setInterval(rotateImages, props.rotationInterval)
    }

    // Stop rotation timer
    const stopRotation = () => {
      if (rotationTimer) {
        clearInterval(rotationTimer)
        rotationTimer = null
      }
    }

    onMounted(() => {
      initializeVisibility()
      
      // Start rotation after a brief delay to allow for preloading
      setTimeout(() => {
        // Start with first fade-in
        fadeIn()
        startRotation()
      }, 1000)
    })

    onUnmounted(() => {
      stopRotation()
    })

    return {
      allImages,
      displayedImages,
      currentSet,
      isVisible,
      loadedImages,
      isTransitioning,
      onImageLoad,
      getStrapiMediaUrl
    }
  }
}
</script>

<style scoped>
.rotating-gallery {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  height: 300px;
  max-width: 100%;
  margin: 0 auto;
}

.gallery-image {
  position: relative;
  overflow: hidden;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  opacity: 0;
  visibility: hidden;
  transition: none; /* Disable default transitions, use animations */
}

.gallery-image.fade-in {
  opacity: 1;
  visibility: visible;
  animation: fadeInUp 1.2s ease-out var(--delay) both;
}

.gallery-image.fade-out {
  opacity: 0;
  animation: fadeInUp 1.2s ease-out var(--delay) both; 
}

.image-container {
  width: 100%;
  height: 100%;
  position: relative;
}

.gallery-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  transition: transform 0.4s ease;
}

.gallery-image:hover .gallery-img {
  transform: scale(1.05);
}

.preload-container {
  position: absolute;
  visibility: hidden;
  pointer-events: none;
}

.preload-img {
  width: 1px;
  height: 1px;
  opacity: 0;
}

/* Smoother, less snappy animations */
@keyframes fadeInUp {
  0% {
    opacity: 0;
    visibility: visible;
    transform: translate3d(0, 40px, 0) scale(0.95);
  }
  50% {
    opacity: 0.7;
    visibility: visible;
    transform: translate3d(0, 15px, 0) scale(0.98);
  }
  100% {
    opacity: 1;
    visibility: visible;
    transform: translate3d(0, 0, 0) scale(1);
  }
}

@keyframes fadeOutDown {
  0% {
    opacity: 1;
    visibility: visible;
    transform: translate3d(0, 0, 0) scale(1);
  }
  50% {
    opacity: 0.7;
    visibility: visible;
    transform: translate3d(0, 15px, 0) scale(0.98);
  }
  100% {
    opacity: 0;
    visibility: hidden;
    transform: translate3d(0, 40px, 0) scale(0.95);
  }
}

/* Responsive design - Tablet */
@media (max-width: 768px) {
  .rotating-gallery {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(2, 1fr);
    height: 400px;
    gap: 0.75rem;
    padding: 0 1rem;
  }
  
  .gallery-image:hover .gallery-img {
    transform: scale(1.02); /* Smaller scale on mobile for better UX */
  }
}

/* Responsive design - Mobile */
@media (max-width: 640px) {
  .rotating-gallery {
    grid-template-columns: 1fr;
    grid-template-rows: repeat(3, 1fr);
    height: 500px;
    gap: 0.5rem;
    padding: 0 1rem;
  }
  
  .gallery-image {
    border-radius: 0.375rem; /* Slightly smaller border radius on mobile */
  }
  
  .gallery-image:hover .gallery-img {
    transform: none; /* Disable hover effects on mobile for better touch UX */
  }
}

/* Extra small mobile devices */
@media (max-width: 480px) {
  .rotating-gallery {
    height: 450px;
    padding: 0 0.75rem;
  }
}
</style>