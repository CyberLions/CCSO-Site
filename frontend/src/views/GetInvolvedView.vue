<template>
  <div class="get-involved-page min-h-screen">
    <section class="socials-discord">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Discord/&gt;</h2>
        <div class="row discord-cont">
          <a href="https://discord.gg/NhN5RpBXkm/" target="_blank" class="btn discord-btn">
            <DiscordIcon :size="100" class="discord-svg" />
          </a>
          <p>Discord is a popular communication platform designed for creating communities, offering text, voice, and video chat. The Competitive Cyber Security Organization (CCSO) uses Discord as its primary tool for all communication, allowing members to collaborate, share information, and stay connected effectively in real-time.</p>
        </div>
      </div>
    </section>
    
    <section class="socials-others">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Other Socials/&gt;</h2>
        <div class="row socials-cont">
          <a class="social social-linkedin" href="https://www.linkedin.com/company/ccsopsu/" target="_blank">
            <p>Connect with us on LinkedIn!</p>
            <LinkedInIcon :size="50" />
          </a>    
          <a class="social social-instagram" href="https://www.instagram.com/ccsopsu/" target="_blank">
            <p>Follow us on Instagram!</p>
            <InstagramIcon :size="50" />
          </a>    
        </div>
      </div>
    </section>
    
    <section class="calendar">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Calendar/&gt;</h2>
        
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
        
        <!-- Calendar Content -->
        <div v-else class="calendar-content">
          <!-- Next Events Summary -->
          <div class="calendar-cont">
            <div 
              class="calendar-event calendar-event-gbm"
              @click="redirectToCalendar('general', nextEvents.general)"
              :class="{ 'has-upcoming-event': nextEvents.general }"
            >
              <p>
                <strong>Next General Body Meeting:</strong> <br>
                {{ nextEvents.general ? formatEventDisplay(nextEvents.general) : 'None Scheduled' }}
              </p>
              <div v-if="nextEvents.general" class="event-indicator">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            <div 
              class="calendar-event calendar-event-social"
              @click="redirectToCalendar('general', nextEvents.social)"
              :class="{ 'has-upcoming-event': nextEvents.social }"
            >
              <p>
                <strong>Next Social Event:</strong> <br>
                {{ nextEvents.social ? formatEventDisplay(nextEvents.social) : 'None Scheduled' }}
              </p>
              <div v-if="nextEvents.social" class="event-indicator">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            <div 
              class="calendar-event calendar-event-red"
              @click="redirectToCalendar('redTeam', nextEvents.redTeam)"
              :class="{ 'has-upcoming-event': nextEvents.redTeam }"
            >
              <p>
                <strong>Next Red Team Meeting:</strong> <br>
                {{ nextEvents.redTeam ? formatEventDisplay(nextEvents.redTeam) : 'None Scheduled' }}
              </p>
              <div v-if="nextEvents.redTeam" class="event-indicator">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            <div 
              class="calendar-event calendar-event-blue"
              @click="redirectToCalendar('blueTeam', nextEvents.blueTeam)"
              :class="{ 'has-upcoming-event': nextEvents.blueTeam }"
            >
              <p>
                <strong>Next Blue Team Meeting:</strong> <br>
                {{ nextEvents.blueTeam ? formatEventDisplay(nextEvents.blueTeam) : 'None Scheduled' }}
              </p>
              <div v-if="nextEvents.blueTeam" class="event-indicator">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            <div 
              class="calendar-event calendar-event-comp"
              @click="redirectToCalendar('ctfs', nextEvents.ctfs)"
              :class="{ 'has-upcoming-event': nextEvents.ctfs }"
            >
              <p>
                <strong>Next Competition:</strong> <br>
                {{ nextEvents.ctfs ? formatEventDisplay(nextEvents.ctfs) : 'None Scheduled' }}
              </p>
              <div v-if="nextEvents.ctfs" class="event-indicator">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import DiscordIcon from '@/components/icons/DiscordIcon.vue'
import LinkedInIcon from '@/components/icons/LinkedInIcon.vue'
import InstagramIcon from '@/components/icons/InstagramIcon.vue'
import { fetchAllCalendars, formatTime, formatDate } from '@/utils/calendar'

export default {
  name: 'GetInvolvedView',
  components: {
    DiscordIcon,
    LinkedInIcon,
    InstagramIcon
  },
  setup() {
    const router = useRouter()
    const events = ref([])
    const loading = ref(true)
    const error = ref(null)
    
    // Computed properties for next events by category
    const nextEvents = computed(() => {
      const now = new Date()
      const upcoming = {
        general: null,
        social: null,
        redTeam: null,
        blueTeam: null,
        ctfs: null
      }
      
      // Filter future events and group by calendar type
      const futureEvents = events.value.filter(event => new Date(event.start) > now)
      
      futureEvents.forEach(event => {
        const eventDate = new Date(event.start)
        
        // Check if this is the next event for this category
        if (event.calendar === 'general') {
          if (!upcoming.general || eventDate < new Date(upcoming.general.start)) {
            upcoming.general = event
          }
        } else if (event.calendar === 'redTeam') {
          if (!upcoming.redTeam || eventDate < new Date(upcoming.redTeam.start)) {
            upcoming.redTeam = event
          }
        } else if (event.calendar === 'blueTeam') {
          if (!upcoming.blueTeam || eventDate < new Date(upcoming.blueTeam.start)) {
            upcoming.blueTeam = event
          }
        } else if (event.calendar === 'ctfs') {
          if (!upcoming.ctfs || eventDate < new Date(upcoming.ctfs.start)) {
            upcoming.ctfs = event
          }
        }
        
        // Check for social events (events with "social" in title from general calendar)
        if (event.calendar === 'general' && event.title.toLowerCase().includes('social')) {
          if (!upcoming.social || eventDate < new Date(upcoming.social.start)) {
            upcoming.social = event
          }
        }
      })
      
      return upcoming
    })
    
    // Methods
    const loadEvents = async () => {
      loading.value = true
      error.value = null
      
      try {
        events.value = await fetchAllCalendars()
      } catch (err) {
        error.value = 'Failed to load calendar events. Please try again later.'
        console.error('Error loading events:', err)
      } finally {
        loading.value = false
      }
    }
    
    const formatEventDisplay = (event) => {
      const date = new Date(event.start)
      const time = formatTime(date)
      const day = formatDate(date)
      return `${day} at ${time}`
    }
    
    const redirectToCalendar = (calendarType, event) => {
      if (event) {
        // Redirect to calendar page with specific event and calendar type
        const eventDate = new Date(event.start)
        const year = eventDate.getFullYear()
        const month = eventDate.getMonth()
        const day = eventDate.getDate()
        
        router.push({
          name: 'calendar',
          query: {
            year,
            month: month + 1, // Calendar months are 1-indexed
            day,
            calendar: calendarType,
            eventId: event.id
          }
        })
      } else {
        // If no event, just redirect to calendar page
        router.push({
          name: 'calendar',
          query: {
            calendar: calendarType
          }
        })
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
      nextEvents,
      loadEvents,
      formatEventDisplay,
      redirectToCalendar
    }
  }
}
</script>

<style scoped>
/*Designed and Developed by Aiden Johnson | TGM.One*/
.socials-discord h2.section-title {
    margin-bottom: 0;
}
.discord-cont, .socials-cont, .calendar-cont {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: row;
    max-width: 1100px;
    margin: 0 auto;
}
a.btn.discord-btn {
    flex: 1 1 calc(40%);
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.discord-svg {
    width: 100% !important;
    height: auto !important;
    max-width: 200px;
    color: #5865f2;
}
.discord-cont p {
    margin-right: 0px;
    margin-left: 4em;
    border-radius: 20px;
    background-color: #00000087;
    padding: 20px;
    color: #9AA5CB;
    border: 1px solid #00458d ;
}

.socials-cont {
    gap: 5em;
}
a.social {
    display: inline-flex;
    border-radius: 20px;
    background-color: #00000087;
    color: #9AA5CB;
    border: 1px solid #00458d;
    width: 250px;
    height: 100px;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    text-decoration: none;
}
.social p {
    margin: 0;
    text-align: center;
    flex: 1;
}
.social svg {
    margin-left: 10px;
    flex-shrink: 0;
}

section.calendar,section.past-events {
    margin-top: 4em;
}
.calendar-cont {
    gap: 32px;
    flex-wrap: wrap;
}
.calendar-event {
    flex: 1 1 calc(30% - 32px);
    padding: 1em;
    border-radius: 20px;
    text-align: center;
    height: 250px;
    background-size: cover !important;
    background-position: center !important;
    position: relative;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}
.calendar-event:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 69, 141, 0.3);
    border-color: #00458d;
}
.calendar-event.has-upcoming-event {
    border-color: #10B981;
    box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
}
.calendar-event p {
    padding-top: 20px;
    margin-bottom: 0px;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    padding: 10px;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 1%,rgba(0, 0, 0, 0.9) 20%, rgba(0, 0, 0, 1) 100%);
    border-bottom-left-radius: 18px;
    border-bottom-right-radius: 18px;
    color: white;
}
.event-indicator {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(16, 185, 129, 0.9);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
.calendar-event-gbm {
    background: url('/src/assets/images/gbm.png');
    flex: 1 1 calc(64% - 32px);
}
.calendar-event-social {
    background: url('/src/assets/images/gbm_sdr_photo.jpg');
}
.calendar-event-red {
    background: url('/src/assets/images/lockpicking_working_gbm.jpg');
}
.calendar-event-blue {
    background: url('/src/assets/images/ccdc_working_2025.jpg');
}
.calendar-event-comp {
    background: url('/src/assets/images/competitions.png');
}

@media (max-width: 990px) {
    .discord-cont p {
        margin-left: 0px;
        margin-top: 1em;
    }
    .socials-cont {
        gap: 1em;
    }
    .calendar-event {
        flex: 1 1 calc(100% - 32px);
    }
    .calendar-event-gbm {
        flex: 1 1 calc(100% - 32px);
    }
    h2.section-title {
        font-size: 2em;
    }
    a.social {
        height: 75px;
    }
    .social p {
        line-height: 1.2em;
    }
    .social svg {
        max-width: 50px !important;
        margin: auto 0;
        max-height: 50px !important;
    }
    section.socials-discord {
        margin-bottom: 4em;
    }
    .discord-cont {
        flex-direction: column;
    }
    .discord-cont {
        flex-direction: column;
    }
    .discord-svg {
        width: 100% !important;
        max-height: 100px !important;
    }
    .event-indicator {
        width: 30px;
        height: 30px;
        top: 10px;
        right: 10px;
    }
    .event-indicator svg {
        width: 16px;
        height: 16px;
    }
}
</style>