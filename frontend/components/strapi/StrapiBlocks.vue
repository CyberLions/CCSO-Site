<template>
  <div class="strapi-blocks">
    <StrapiBlocks 
      v-if="content && content.length" 
      :content="content" 
      :blocks="customBlocks"
      :modifiers="customModifiers"
    />
    <div v-else-if="loading" class="loading">
      <div class="animate-pulse">
        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
      </div>
    </div>
    <p v-else class="text-gray-500">No content available</p>
  </div>
</template>

<script setup>
import { h } from 'vue'
import { StrapiBlocks } from 'vue-strapi-blocks-renderer'
import { getStrapiMediaUrl } from '@/utils/api'

const props = defineProps({
  content: {
    type: Array,
    default: () => []
  },
  loading: {
    type: Boolean,
    default: false
  }
})

// Custom block components with Tailwind styling
const customBlocks = {
  paragraph: (props) => h('p', { 
    class: 'mb-4 text-gray-700 leading-relaxed' 
  }, props.children),
  
  heading: (props) => {
    const classes = {
      1: 'text-4xl font-bold mb-6 text-gray-900',
      2: 'text-3xl font-semibold mb-5 text-gray-800',
      3: 'text-2xl font-medium mb-4 text-gray-800',
      4: 'text-xl font-medium mb-3 text-gray-700',
      5: 'text-lg font-medium mb-2 text-gray-700',
      6: 'text-base font-medium mb-2 text-gray-700'
    }
    
    return h(`h${props.level}`, { 
      class: classes[props.level] || classes[2]
    }, props.children)
  },
  
  list: (props) => {
    const Component = props.format === 'ordered' ? 'ol' : 'ul'
    const listClass = props.format === 'ordered' 
      ? 'list-decimal list-inside mb-4 space-y-1' 
      : 'list-disc list-inside mb-4 space-y-1'
    
    return h(Component, { 
      class: listClass
    }, props.children)
  },
  
  quote: (props) => h('blockquote', { 
    class: 'border-l-4 border-blue-500 pl-4 py-2 mb-4 italic text-gray-600 bg-gray-50' 
  }, props.children),
  
  code: (props) => h('pre', { 
    class: 'bg-gray-900 text-white p-4 rounded-lg mb-4 overflow-x-auto'
  }, [
    h('code', {}, props.plainText)
  ]),
  
  image: (props) => {
    if (!props.image) return null
    
    const imageUrl = getStrapiMediaUrl(props.image.url)
    
    return h('div', { class: 'mb-6' }, [
      h('img', {
        src: imageUrl,
        alt: props.image.alternativeText || '',
        class: 'max-w-full h-auto rounded-lg shadow-sm',
        loading: 'lazy'
      }),
      props.image.caption && h('p', { 
        class: 'text-sm text-gray-500 mt-2 text-center' 
      }, props.image.caption)
    ])
  },
  
  link: (props) => h('a', { 
    href: props.url,
    class: 'text-blue-600 hover:text-blue-800 underline',
    target: props.url.startsWith('http') ? '_blank' : '_self',
    rel: props.url.startsWith('http') ? 'noopener noreferrer' : undefined
  }, props.children)
}

// Custom modifier components
const customModifiers = {
  bold: (props) => h('strong', { 
    class: 'font-bold' 
  }, props.children),
  
  italic: (props) => h('em', { 
    class: 'italic' 
  }, props.children),
  
  underline: (props) => h('u', { 
    class: 'underline' 
  }, props.children),
  
  strikethrough: (props) => h('s', { 
    class: 'line-through' 
  }, props.children),
  
  code: (props) => h('code', { 
    class: 'bg-gray-100 px-1 py-0.5 rounded text-sm font-mono' 
  }, props.children)
}
</script>

<style scoped>
.strapi-blocks {
  @apply text-base leading-relaxed;
}

.loading {
  @apply py-4;
}
</style>