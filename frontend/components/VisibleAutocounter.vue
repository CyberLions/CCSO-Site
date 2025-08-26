<template>
  <div ref="elementRef">
    <vue3-autocounter 
      v-if="isVisible"
      :startAmount="startAmount" 
      :endAmount="endAmount" 
      :duration="duration" 
      :suffix="suffix"
      :prefix="prefix"
      :decimals="decimals"
      :autoplay="true"
    />
    <span v-else>{{ startAmount }}{{ suffix }}</span>
  </div>
</template>

<script>
import Vue3Autocounter from 'vue3-autocounter'
import { useIntersectionObserver } from '@/composables/useIntersectionObserver'

export default {
  name: 'VisibleAutocounter',
  components: {
    Vue3Autocounter
  },
  props: {
    startAmount: {
      type: Number,
      default: 0
    },
    endAmount: {
      type: Number,
      required: true
    },
    duration: {
      type: Number,
      default: 2
    },
    suffix: {
      type: String,
      default: ''
    },
    prefix: {
      type: String,
      default: ''
    },
    decimals: {
      type: Number,
      default: 0
    }
  },
  setup() {
    const { isVisible, elementRef } = useIntersectionObserver({
      threshold: 0.3, // Trigger when 30% of the element is visible
      rootMargin: '50px' // Start observing 50px before the element enters viewport
    })
    
    return {
      isVisible,
      elementRef
    }
  }
}
</script> 