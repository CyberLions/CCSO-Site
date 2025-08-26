<template>
  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div :class="headerClass" class="px-6 py-4">
      <div class="flex items-center">
        <component 
          :is="iconComponent" 
          class="w-6 h-6 text-white mr-3" 
        />
        <h3 class="text-lg font-semibold text-white">{{ title }}</h3>
      </div>
    </div>
    <div class="p-6">
      <div v-if="event && event.name" class="space-y-2">
        <p class="font-semibold text-slate-900">{{ event.name }}</p>
        <p class="text-gray-600">{{ event.date }} at {{ event.time }}</p>
        <p v-if="event.location" class="text-gray-600">📍 {{ event.location }}</p>
      </div>
      <div v-else class="text-center py-4">
        <p class="text-gray-500">None Scheduled</p>
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue'
import { 
  UsersIcon, 
  HeartIcon, 
  ShieldExclamationIcon, 
  ShieldCheckIcon, 
  TrophyIcon 
} from '@heroicons/vue/24/outline'

export default {
  name: 'EventCard',
  components: {
    UsersIcon,
    HeartIcon,
    ShieldExclamationIcon,
    ShieldCheckIcon,
    TrophyIcon
  },
  props: {
    title: {
      type: String,
      required: true
    },
    event: {
      type: Object,
      default: null
    },
    icon: {
      type: String,
      default: 'UsersIcon'
    },
    color: {
      type: String,
      default: 'blue'
    }
  },
  setup(props) {
    const iconComponent = computed(() => {
      const iconMap = {
        UsersIcon,
        HeartIcon,
        ShieldExclamationIcon,
        ShieldCheckIcon,
        TrophyIcon
      }
      return iconMap[props.icon] || UsersIcon
    })

    const headerClass = computed(() => {
      const colorMap = {
        blue: 'bg-blue-600',
        green: 'bg-green-600',
        red: 'bg-red-600',
        yellow: 'bg-yellow-600',
        purple: 'bg-purple-600'
      }
      return colorMap[props.color] || 'bg-blue-600'
    })

    return {
      iconComponent,
      headerClass
    }
  }
}
</script>