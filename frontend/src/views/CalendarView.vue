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
  </div>
</template>

<script>
import CalendarWidget from '@/components/CalendarWidget.vue'

export default {
  name: 'CalendarView',
  components: {
    CalendarWidget
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

@media (max-width: 990px) {
  h2.section-title {
    font-size: 2em;
  }
}
</style> 