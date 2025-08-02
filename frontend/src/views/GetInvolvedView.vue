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
        <div class="calendar-cont">
          <div class="calendar-event calendar-event-gbm">
            <p><strong>Next General Body Meeting:</strong> <br>{{ nextEvents.gbm || 'None Scheduled' }}</p>
          </div>
          <div class="calendar-event calendar-event-social">
            <p><strong>Next Social:</strong> <br>{{ nextEvents.social || 'None Scheduled' }}</p>
          </div>
          <div class="calendar-event calendar-event-red">
            <p><strong>Next Red Team Meeting:</strong> <br>{{ nextEvents.red || 'None Scheduled' }}</p>
          </div>
          <div class="calendar-event calendar-event-blue">
            <p><strong>Next Blue Team Meeting:</strong> <br>{{ nextEvents.blue || 'None Scheduled' }}</p>
          </div>
          <div class="calendar-event calendar-event-comp">
            <p><strong>Next Competition:</strong> <br>{{ nextEvents.competition || 'None Scheduled' }}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import DiscordIcon from '@/components/icons/DiscordIcon.vue'
import LinkedInIcon from '@/components/icons/LinkedInIcon.vue'
import InstagramIcon from '@/components/icons/InstagramIcon.vue'

export default {
  name: 'GetInvolvedView',
  components: {
    DiscordIcon,
    LinkedInIcon,
    InstagramIcon
  },
  setup() {
    const nextEvents = ref({
      gbm: 'None Scheduled',
      social: 'None Scheduled',
      red: 'None Scheduled',
      blue: 'None Scheduled',
      competition: 'None Scheduled'
    })

    // Function to find next event by keyword (placeholder for calendar integration)
    const findNextEventByKeyword = (keyword) => {
      // This would integrate with calendar API in a real implementation
      // For now, returning placeholder data
      return 'None Scheduled'
    }

    const loadCalendarEvents = async () => {
      try {
        // This would fetch from calendar API equivalent to the PHP calendar integration
        // For now, using placeholder data
        nextEvents.value = {
          gbm: findNextEventByKeyword('GBM'),
          social: findNextEventByKeyword('Social'),
          red: findNextEventByKeyword('Red'),
          blue: findNextEventByKeyword('Blue'),
          competition: findNextEventByKeyword('Competition')
        }
      } catch (error) {
        console.error('Error loading calendar events:', error)
      }
    }

    onMounted(() => {
      loadCalendarEvents()
    })

    return {
      nextEvents
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
}
</style>