<template>
  <div class="calendar-widget">
    
    <!-- Loading State -->
    <div v-if="loading" class="text-center py-12">
      <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-400 mx-auto"></div>
      <p class="mt-6 text-blue-200 text-lg">Loading events...</p>
    </div>
    
    <!-- Error State -->
    <div v-else-if="error" class="text-center py-12">
      <div class="text-red-400 mb-6">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
      </div>
      <p class="text-blue-200 mb-6 text-lg">{{ error }}</p>
      <button 
        @click="loadEvents" 
        class="discord-btn"
      >
        Retry
      </button>
    </div>
    
    <!-- No Events State -->
    <div v-else-if="!loading && events.length === 0" class="text-center py-12">
      <div class="text-blue-300 mb-6">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>
      <p class="text-blue-200 mb-6 text-lg">No events found in the calendars</p>
      <button 
        @click="loadEvents" 
        class="discord-btn"
      >
        Refresh
      </button>
    </div>
    
    <!-- Calendar Content -->
    <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Month Calendar -->
      <div class="bg-black bg-opacity-50 rounded-lg p-6 border border-blue-500 border-opacity-30">
        <div class="flex items-center justify-between mb-6">
          <button 
            @click="previousMonth"
            class="p-3 hover:bg-blue-600 hover:bg-opacity-20 rounded-lg transition-colors text-blue-300 hover:text-blue-100"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <h4 class="text-xl font-bold text-blue-200">{{ currentMonthName }} {{ currentYear }}</h4>
          <button 
            @click="nextMonth"
            class="p-3 hover:bg-blue-600 hover:bg-opacity-20 rounded-lg transition-colors text-blue-300 hover:text-blue-100"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
        </div>
        
        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-2">
          <!-- Day Headers -->
          <div 
            v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" 
            :key="day"
            class="text-center text-sm font-medium text-blue-300 py-3"
          >
            {{ day }}
          </div>
          
          <!-- Calendar Days -->
          <div 
            v-for="day in calendarDays" 
            :key="day.key"
            @click="selectDate(day.date)"
            :class="[
              'relative p-3 text-center cursor-pointer border border-blue-500 border-opacity-30 rounded-lg transition-all min-h-70px flex flex-col',
              day.isCurrentMonth 
                ? 'hover:bg-blue-600 hover:bg-opacity-20 hover:border-blue-400' 
                : 'text-gray-500 bg-black bg-opacity-30',
              day.isToday ? 'bg-blue-600 bg-opacity-30 border-blue-400' : '',
              day.isSelected ? 'bg-blue-500 bg-opacity-40 border-blue-300' : '',
              day.hasEvents ? 'border-l-4 border-l-blue-400' : ''
            ]"
          >
            <span class="text-sm font-medium" :class="day.isCurrentMonth ? 'text-blue-200' : 'text-gray-500'">
              {{ day.dayNumber }}
            </span>
            
            <!-- Event Indicators -->
            <div v-if="day.events && day.events.length > 0" class="mt-2">
              <!-- Desktop: Show event text -->
              <div class="hidden md:block">
                <div 
                  v-for="(event, index) in day.events.slice(0, 1)" 
                  :key="event.id"
                  class="text-xs truncate px-2 py-1 rounded-md font-medium"
                  :style="{ backgroundColor: event.bgColor + '20', color: event.color, border: `1px solid ${event.color}40` }"
                >
                  {{ event.title }}
                </div>
                <div 
                  v-if="day.events.length > 1" 
                  class="text-xs text-blue-300 mt-1 font-medium"
                >
                  +{{ day.events.length - 1 }} more
                </div>
              </div>
              
              <!-- Mobile: Show colored dots -->
              <div class="md:hidden flex flex-wrap justify-center gap-1">
                <div 
                  v-for="(event, index) in day.events.slice(0, 3)" 
                  :key="event.id"
                  class="w-2 h-2 rounded-full"
                  :style="{ backgroundColor: event.color }"
                  :title="event.title"
                ></div>
                <div 
                  v-if="day.events.length > 3" 
                  class="w-2 h-2 rounded-full bg-blue-400"
                  :title="`${day.events.length - 3} more events`"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Day Events -->
      <div class="bg-black bg-opacity-50 rounded-lg p-6 border border-blue-500 border-opacity-30">
        <div class="flex items-center justify-between mb-6">
          <h4 class="text-xl font-bold text-blue-200">
            {{ selectedDateFormatted }}
          </h4>
          <button 
            @click="selectToday"
            class="text-sm text-blue-400 hover:text-blue-200 transition-colors font-medium"
          >
            Today
          </button>
        </div>
        
        <!-- Events for Selected Day -->
        <div v-if="selectedDayEvents.length === 0" class="text-center py-12">
          <div class="text-blue-300 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <p class="text-blue-200 text-lg">No events scheduled for this day</p>
        </div>
        
        <div v-else class="space-y-4">
          <div 
            v-for="event in selectedDayEvents" 
            :key="event.id"
            class="border border-blue-500 border-opacity-30 rounded-lg p-4 hover:bg-blue-600 hover:bg-opacity-10 transition-all"
            :style="{ borderLeftColor: event.color, borderLeftWidth: '4px' }"
          >
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <h5 class="font-bold text-blue-100 mb-2 text-lg">{{ event.title }}</h5>
                <div class="flex items-center text-sm text-blue-300 mb-2">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  {{ formatTime(event.start) }} - {{ formatTime(event.end) }}
                </div>
                <div v-if="event.location" class="flex items-center text-sm text-blue-300 mb-2">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  {{ event.location }}
                </div>
                <p v-if="event.description" class="text-sm text-blue-200 mt-2">{{ event.description }}</p>
              </div>
              <div class="ml-4">
                <span 
                  class="inline-block px-3 py-1 text-xs font-bold rounded-full"
                  :style="{ backgroundColor: event.bgColor + '20', color: event.color, border: `1px solid ${event.color}40` }"
                >
                  {{ event.calendarName }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Calendar Legend -->
    <div class="mt-8 bg-black bg-opacity-30 rounded-lg p-6 border border-blue-500 border-opacity-30">
      <h5 class="text-lg font-bold text-blue-200 mb-4 text-center">Calendar Legend</h5>
      <div class="flex flex-wrap justify-center gap-6">
        <div 
          v-for="(config, key) in calendarConfig" 
          :key="key"
          class="flex items-center"
        >
          <div 
            class="w-4 h-4 rounded-full mr-3"
            :style="{ backgroundColor: config.color }"
          ></div>
          <span class="text-blue-200 font-medium">{{ config.name }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { 
  fetchAllCalendars, 
  getEventsForDate, 
  getEventsForMonth, 
  groupEventsByDate,
  formatTime,
  formatDate,
  CALENDAR_CONFIG 
} from '@/utils/calendar'

export default {
  name: 'CalendarWidget',
  props: {
    initialYear: {
      type: Number,
      default: () => new Date().getFullYear()
    },
    initialMonth: {
      type: Number,
      default: () => new Date().getMonth()
    },
    initialDay: {
      type: Number,
      default: () => new Date().getDate()
    },
    initialCalendar: {
      type: String,
      default: null
    },
    initialEventId: {
      type: String,
      default: null
    }
  },
  setup(props) {
    const events = ref([])
    const loading = ref(true)
    const error = ref(null)
    const currentYear = ref(props.initialYear)
    const currentMonth = ref(props.initialMonth)
    const selectedDate = ref(new Date(props.initialYear, props.initialMonth, props.initialDay))
    
    const calendarConfig = CALENDAR_CONFIG
    
    // Computed properties
    const currentMonthName = computed(() => {
      return new Date(currentYear.value, currentMonth.value).toLocaleDateString('en-US', { month: 'long' })
    })
    
    const selectedDateFormatted = computed(() => {
      return formatDate(selectedDate.value)
    })
    
    const selectedDayEvents = computed(() => {
      return getEventsForDate(events.value, selectedDate.value)
    })
    
    const monthEvents = computed(() => {
      return getEventsForMonth(events.value, currentYear.value, currentMonth.value)
    })
    
    const groupedMonthEvents = computed(() => {
      return groupEventsByDate(monthEvents.value, currentYear.value, currentMonth.value)
    })
    
    const calendarDays = computed(() => {
      const days = []
      const firstDay = new Date(currentYear.value, currentMonth.value, 1)
      const lastDay = new Date(currentYear.value, currentMonth.value + 1, 0)
      const startDate = new Date(firstDay)
      startDate.setDate(startDate.getDate() - firstDay.getDay())
      
      const today = new Date()
      today.setHours(0, 0, 0, 0)
      
      for (let i = 0; i < 42; i++) {
        const date = new Date(startDate)
        date.setDate(startDate.getDate() + i)
        
        const dayNumber = date.getDate()
        const isCurrentMonth = date.getMonth() === currentMonth.value
        const isToday = date.getTime() === today.getTime()
        const isSelected = date.toDateString() === selectedDate.value.toDateString()
        
        // Get events for this specific date, not just the day number
        const dayEvents = isCurrentMonth ? (groupedMonthEvents.value[dayNumber] || []) : []
        const hasEvents = dayEvents.length > 0
        
        days.push({
          key: date.toISOString(),
          date: date,
          dayNumber,
          isCurrentMonth,
          isToday,
          isSelected,
          hasEvents,
          events: dayEvents
        })
      }
      
      return days
    })
    
    // Methods
    const loadEvents = async () => {
      loading.value = true
      error.value = null
      
      try {
        events.value = await fetchAllCalendars()
        
        // After loading events, handle initial event selection
        if (props.initialEventId) {
          const targetEvent = events.value.find(event => event.id === props.initialEventId)
          if (targetEvent) {
            const eventDate = new Date(targetEvent.start)
            selectedDate.value = eventDate
            currentYear.value = eventDate.getFullYear()
            currentMonth.value = eventDate.getMonth()
          }
        }
      } catch (err) {
        error.value = 'Failed to load calendar events. Please try again later.'
        console.error('Error loading events:', err)
      } finally {
        loading.value = false
      }
    }
    
    const selectDate = (date) => {
      selectedDate.value = new Date(date)
    }
    
    const selectToday = () => {
      selectedDate.value = new Date()
      currentYear.value = selectedDate.value.getFullYear()
      currentMonth.value = selectedDate.value.getMonth()
    }
    
    const previousMonth = () => {
      if (currentMonth.value === 0) {
        currentMonth.value = 11
        currentYear.value--
      } else {
        currentMonth.value--
      }
    }
    
    const nextMonth = () => {
      if (currentMonth.value === 11) {
        currentMonth.value = 0
        currentYear.value++
      } else {
        currentMonth.value++
      }
    }
    
    // Lifecycle
    onMounted(() => {
      loadEvents()
    })
    
    return {
      events,
      loading,
      error,
      currentYear,
      currentMonth,
      selectedDate,
      calendarConfig,
      currentMonthName,
      selectedDateFormatted,
      selectedDayEvents,
      calendarDays,
      loadEvents,
      selectDate,
      selectToday,
      previousMonth,
      nextMonth,
      formatTime,
      formatDate
    }
  }
}
</script>

<style scoped>
.calendar-widget {
  max-width: 1400px;
  margin: 0 auto;
}

.min-h-70px {
  min-height: 70px;
}

/* Custom scrollbar for event descriptions */
.calendar-widget ::-webkit-scrollbar {
  width: 6px;
}

.calendar-widget ::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.3);
  border-radius: 3px;
}

.calendar-widget ::-webkit-scrollbar-thumb {
  background: rgba(59, 130, 246, 0.5);
  border-radius: 3px;
}

.calendar-widget ::-webkit-scrollbar-thumb:hover {
  background: rgba(59, 130, 246, 0.7);
}

/* Mobile optimizations */
@media (max-width: 768px) {
  .calendar-widget .grid {
    gap: 1rem;
  }
  
  .calendar-widget .bg-black.bg-opacity-50 {
    padding: 1rem;
  }
  
  .calendar-widget .grid.grid-cols-7 {
    gap: 1px;
  }
  
  .calendar-widget .grid.grid-cols-7 > div {
    min-height: 60px;
    padding: 0.5rem 0.25rem;
  }
  
  .calendar-widget .text-sm {
    font-size: 0.75rem;
  }
  
  .calendar-widget .text-xl {
    font-size: 1.125rem;
  }
  
  .calendar-widget .p-3 {
    padding: 0.5rem;
  }
  
  .calendar-widget .w-6.h-6 {
    width: 1.25rem;
    height: 1.25rem;
  }
  
  .calendar-widget .space-y-4 > div {
    margin-bottom: 1rem;
  }
  
  .calendar-widget .p-4 {
    padding: 1rem;
  }
  
  .calendar-widget .text-lg {
    font-size: 1rem;
  }
  
  .calendar-widget .gap-6 {
    gap: 1rem;
  }
  
  .calendar-widget .p-6 {
    padding: 1rem;
  }
}

@media (max-width: 480px) {
  .calendar-widget .grid.grid-cols-7 > div {
    min-height: 50px;
    padding: 0.25rem 0.125rem;
  }
  
  .calendar-widget .text-sm {
    font-size: 0.7rem;
  }
  
  .calendar-widget .w-2.h-2 {
    width: 0.375rem;
    height: 0.375rem;
  }
}
</style> 