<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="home-about">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="row top-about featured-section">
          <h2 class="section-title">&lt;Competitive Cyber Security Organization/&gt;</h2>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <p>CCSO members gain hands-on experience in offense, defense, physical security, and computer science. Meetings feature interactive challenges like internal competitions, lockpicking workshops, and resume-building events. Members also represent Penn State in national competitions, consistently placing in the top 4 at events such as CyberForce, CPTC, and MACCDC.</p>
              <a 
                href="https://discord.gg/NhN5RpBXkm" 
                target="_blank" 
                rel="noopener noreferrer"
                class="discord-btn mt-4"
              >
                <DiscordIcon :size="20" class="mr-2" />
                Join Our Discord
              </a>
            </div>
            <div class="flex justify-center">
              <div 
                v-if="home?.heroImage"
                class="w-full max-w-lg h-80 rounded-lg shadow-2xl overflow-hidden"
              >
                <img 
                  :src="getStrapiMediaUrl(home.heroImage.url)" 
                  :alt="home.heroImage.alternativeText || 'Team Photo'"
                  class="w-full h-full object-cover"
                />
              </div>
              <div 
                v-else
                class="w-full max-w-lg h-80 bg-gradient-to-br from-blue-100 to-slate-100 rounded-lg shadow-2xl flex items-center justify-center"
              >
                <div class="text-center">
                  <UsersIcon class="w-16 h-16 text-blue-600 mx-auto mb-2" />
                  <p class="text-slate-600 font-medium">Team Photo</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section content-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Our Activities/&gt;</h2>
        <div class="text-center">
          <RotatingGallery 
            v-if="whatWeDo?.gallery && whatWeDo.gallery.length > 0"
            :images="whatWeDo.gallery"
            :images-per-view="3"
            :rotation-interval="6000"
            :transition-duration="1000"
          />
          <div 
            v-else
            class="grid grid-cols-1 md:grid-cols-3 gap-4"
          >
            <div class="h-48 bg-gradient-to-br from-blue-100 to-slate-100 rounded-lg shadow-lg flex items-center justify-center">
              <div class="text-center">
                <PresentationChartLineIcon class="w-12 h-12 text-blue-600 mx-auto mb-2" />
                <p class="text-slate-600 font-medium text-sm">Meeting</p>
              </div>
            </div>
            <div class="h-48 bg-gradient-to-br from-blue-100 to-slate-100 rounded-lg shadow-lg flex items-center justify-center">
              <div class="text-center">
                <UsersIcon class="w-12 h-12 text-blue-600 mx-auto mb-2" />
                <p class="text-slate-600 font-medium text-sm">Team</p>
              </div>
            </div>
            <div class="h-48 bg-gradient-to-br from-blue-100 to-slate-100 rounded-lg shadow-lg flex items-center justify-center">
              <div class="text-center">
                <PresentationChartLineIcon class="w-12 h-12 text-blue-600 mx-auto mb-2" />
                <p class="text-slate-600 font-medium text-sm">Workshop</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- What We Do Section -->
    <section class="what-we-do content-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;What We Do/&gt;</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <FlipCard
            v-for="item in activities"
            :key="item.id"
          >
            <template #icon>
              <component :is="item.icon" class="w-12 h-12 text-blue-600" />
            </template>
            <template #header>
              {{ item.title }}
            </template>
            <template #message>
              {{ item.content }}
            </template>
          </FlipCard>
        </div>
      </div>
    </section>

    <!-- Calendar Section -->
    <section class="home-calendar content-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Upcoming Events/&gt;</h2>
        <CalendarWidget />
      </div>
    </section>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { 
  CalendarIcon, 
  UsersIcon, 
  PresentationChartLineIcon,
  ChatBubbleBottomCenterTextIcon,
  BugAntIcon,
  ShieldCheckIcon,
  WrenchScrewdriverIcon,
  AcademicCapIcon,
  FlagIcon
} from '@heroicons/vue/24/outline'
import FlipCard from '@/components/FlipCard.vue'
import DiscordIcon from '@/components/icons/DiscordIcon.vue'
import RotatingGallery from '@/components/RotatingGallery.vue'
import CalendarWidget from '@/components/CalendarWidget.vue'
import { useHome, useWhatWeDo } from '@/composables/useStrapi'
import { getStrapiMediaUrl } from '@/utils/api'

export default {
  name: 'HomeView',
  components: {
    CalendarIcon,
    UsersIcon,
    PresentationChartLineIcon,
    ChatBubbleBottomCenterTextIcon,
    BugAntIcon,
    ShieldCheckIcon,
    WrenchScrewdriverIcon,
    AcademicCapIcon,
    FlagIcon,
    FlipCard,
    DiscordIcon,
    RotatingGallery,
    CalendarWidget
  },
  setup() {
    // Initialize composables
    const { home, loadHome, loading: homeLoading } = useHome()
    const { whatWeDo, loadWhatWeDo, loading: whatWeDoLoading } = useWhatWeDo()
    
    // Load data on mount
    onMounted(async () => {
      try {
        await Promise.all([
          loadHome(),
          loadWhatWeDo()
        ])
      } catch (error) {
        console.error('Failed to load home data:', error)
      }
    })
    
    const activities = [
      {
        id: 'general-body-meeting',
        title: 'General Body Meetings',
        icon: ChatBubbleBottomCenterTextIcon,
        content: 'Our general body meetings are held every other week on Wednesdays at 6:00 PM in the Cybertorium. We discuss upcoming events, workshops, and competitions. We also have guest speakers from industry and academia.'
      },
      {
        id: 'offense-meeting',
        title: 'Offense Meetings',
        icon: BugAntIcon,
        content: 'Offense meetings focus on developing skills in ethical hacking and penetration testing. These sessions dive into offensive security techniques, preparing members for competitions and real-world scenarios.'
      },
      {
        id: 'defense-meeting',
        title: 'Defense Meetings',
        icon: ShieldCheckIcon,
        content: 'Defense meetings are dedicated to learning and practicing defensive cybersecurity strategies. Members explore topics like network security, incident response, and system hardening to strengthen their defensive capabilities.'
      },
      {
        id: 'workshops',
        title: 'Workshops',
        icon: WrenchScrewdriverIcon,
        content: 'Our workshops provide hands-on learning experiences in various cybersecurity topics. These sessions are designed to enhance technical skills through practical exercises and guided instruction.'
      },
      {
        id: 'education',
        title: 'Education',
        icon: AcademicCapIcon,
        content: 'The education track offers structured learning paths in cybersecurity, covering foundational to advanced topics. We provide resources, tutorials, and guided study sessions to help members expand their knowledge.'
      },
      {
        id: 'capture-the-flag',
        title: 'Capture the Flag',
        icon: FlagIcon,
        content: 'Capture the Flag (CTF) competitions are a key part of our organization. These events challenge members to solve cybersecurity puzzles and problems, fostering a competitive spirit and sharpening their technical skills.'
      }
    ]

    return {
      activities,
      home,
      whatWeDo,
      homeLoading,
      whatWeDoLoading,
      getStrapiMediaUrl
    }
  }
}
</script>

<style scoped>
/* Mobile improvements for homepage header */
@media (max-width: 768px) {
  .home-about {
    padding-top: 2rem;
  }
  
  .home-about .featured-section {
    padding-top: 3rem;
    padding-bottom: 2rem;
    text-align: center;
  }
  
  .home-about .section-title {
    margin-bottom: 2rem;
    padding-top: 1rem;
  }
  
  .home-about .grid {
    gap: 2rem;
  }
  
  .home-about p {
    text-align: center;
    margin-bottom: 2rem;
  }
  
  .home-about .discord-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
  }
}

@media (max-width: 480px) {
  .home-about {
    padding-top: 1.5rem;
  }
  
  .home-about .featured-section {
    padding-top: 2.5rem;
    padding-bottom: 1.5rem;
    margin: 0.5rem 0.5rem;
  }
  
  .home-about .section-title {
    margin-bottom: 1.5rem;
    padding-top: 0.5rem;
  }
}
</style>