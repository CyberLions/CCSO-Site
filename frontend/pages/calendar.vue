<template>
  <div class="calendar-page min-h-screen">
    <section class="calendar-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Calendar/&gt;</h2>
        <div class="calendar-container">
          <CalendarWidget 
            :initial-year="parseInt($route.query.year) || new Date().getFullYear()"
            :initial-month="parseInt($route.query.month) - 1 || new Date().getMonth()"
            :initial-day="parseInt($route.query.day) || new Date().getDate()"
            :initial-calendar="$route.query.calendar || null"
            :initial-event-id="$route.query.eventId || null"
          />
        </div>
      </div>
    </section>

    <section class="subscription-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Subscribe/&gt;</h2>
        <p class="text-blue-200 mb-4 text-center">Copy an ICS feed URL to subscribe in your calendar app.</p>
        <div class="subscription-list">
          <div v-for="cal in calendars" :key="cal.key" class="subscription-item">
            <span class="subscription-name">{{ cal.name }}</span>
            <div>
              <button class="copy-btn" @click="copySubscriptionUrl(cal.url, cal.key)">Copy subscription link</button>
              <span v-if="copiedKey === cal.key" class="copied-hint">Copied!</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import CalendarWidget from '@/components/CalendarWidget.vue'
import { CALENDAR_CONFIG } from '@/utils/calendar.js'
import { ref } from 'vue'

export default {
  name: 'CalendarView',
  components: {
    CalendarWidget
  },
  setup() {
    const copiedKey = ref(null)
    const calendars = Object.entries(CALENDAR_CONFIG).map(([key, cfg]) => ({
      key,
      name: cfg.name,
      url: cfg.url
    }))

    async function copySubscriptionUrl(url, key) {
      try {
        await navigator.clipboard.writeText(url)
        copiedKey.value = key
        setTimeout(() => {
          if (copiedKey.value === key) copiedKey.value = null
        }, 2000)
      } catch (e) {
        console.error('Failed to copy URL:', e)
      }
    }

    return { calendars, copiedKey, copySubscriptionUrl }
  }
}
</script>

<style scoped>
/*Designed and Developed by Aiden Johnson | TGM.One*/
.calendar-section {
  margin-top: 2em;
}

.calendar-container {
  max-width: 1400px;
  margin: 0 auto;
}

/* New subscription section */
.subscription-section {
  margin-top: 3em;
}
.subscription-list {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
  max-width: 900px;
  margin: 0 auto;
}
.subscription-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #00000087;
  border: 1px solid #00458d;
  border-radius: 12px;
  padding: 12px 16px;
}
.subscription-name {
  color: #9AA5CB;
  font-weight: 600;
}
.copy-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 8px 12px;
  border-radius: 8px;
  border: 1px solid #00458d;
  background: #0b2040;
  color: #cfe1ff;
  cursor: pointer;
  transition: all .2s ease;
}
.copy-btn:hover {
  background: #123366;
  border-color: #0a57b5;
}
.copied-hint {
  margin-left: 10px;
  color: #10B981;
  font-size: .9rem;
}

@media (max-width: 990px) {
  h2.section-title {
    font-size: 2em;
  }
  .subscription-item {
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }
}
</style> 