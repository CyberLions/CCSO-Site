<template>
  <div class="join-page min-h-screen">
    <!-- Hero Section -->
    <section class="join-hero">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="row featured-section">
          <h2 class="section-title">&lt;Join CCSO/&gt;</h2>
          <div class="hero-content">
            <p>
              The Penn State Competitive Cyber Security Organization (CCSO) is a student-run club 
              dedicated to fostering cybersecurity skills through hands-on learning, competitions, 
              and community engagement. Whether you're a beginner curious about security or an 
              experienced practitioner looking to sharpen your skills, CCSO has a place for you.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- Open Positions Section -->
    <section class="open-positions content-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="row officers-section">
          <h3 class="section-title">&lt;Open Positions/&gt;</h3>
          <p class="positions-intro">
            We're always looking for passionate individuals to help grow our organization. 
            Check out the positions below and apply to become part of our leadership team!
          </p>
          
          <div class="positions-grid">
            <div 
              v-for="position in positions" 
              :key="position.id" 
              class="position-card"
            >
              <div class="position-icon">
                <component :is="position.icon" class="w-10 h-10" />
              </div>
              <h4 class="position-title">{{ position.title }}</h4>
              <p class="position-description">{{ position.description }}</p>
              <a 
                :href="position.formUrl" 
                target="_blank" 
                rel="noopener noreferrer"
                class="apply-btn"
              >
                <PaperAirplaneIcon class="w-4 h-4 mr-2" />
                Apply Now
              </a>
            </div>
          </div>

          <div class="no-positions" v-if="positions.length === 0">
            <InformationCircleIcon class="w-16 h-16 mx-auto mb-4 text-blue-400" />
            <p>No open positions at the moment. Check back soon or join our Discord for updates!</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Join Section -->
    <section class="why-join content-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="section-title">&lt;Why Join CCSO?/&gt;</h2>
        <div class="benefits-grid">
          <div class="benefit-card">
            <ShieldCheckIcon class="benefit-icon" />
            <h4>Real-World Skills</h4>
            <p>Gain practical experience with penetration testing, incident response, and defensive security techniques.</p>
          </div>
          <div class="benefit-card">
            <FlagIcon class="benefit-icon" />
            <h4>Competitions</h4>
            <p>Compete in Red, Blue, and Capture the Flag competitions at local, regional, and national levels with experienced teammates.</p>
          </div>
          <div class="benefit-card">
            <BriefcaseIcon class="benefit-icon" />
            <h4>Career Development</h4>
            <p>Build your resume, network with industry professionals, and gain leadership experience.</p>
          </div>
          <div class="benefit-card">
            <SparklesIcon class="benefit-icon" />
            <h4>Community</h4>
            <p>Join a supportive community of like-minded students passionate about cybersecurity.</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { 
  RocketLaunchIcon,
  TrophyIcon,
  UsersIcon,
  AcademicCapIcon,
  PaperAirplaneIcon,
  ShieldCheckIcon,
  FlagIcon,
  BriefcaseIcon,
  SparklesIcon,
  InformationCircleIcon,
  CodeBracketIcon,
  PresentationChartLineIcon,
  MegaphoneIcon,
  CameraIcon,
  WrenchScrewdriverIcon,
  DocumentTextIcon
} from '@heroicons/vue/24/outline'
import DiscordIcon from '@/components/icons/DiscordIcon.vue'

// Define open positions - update this array to add/remove positions
const positions = ref([
  {
    id: 'sponsorship-chair',
    title: 'Sponsorship Chair',
    description: 'Manage and coordinate sponsorship opportunities for CCSO. Reach out to potential sponsors, negotiate deals, and ensure sponsors are satisfied with their partnership.',
    icon: PresentationChartLineIcon,
    formUrl: 'https://nextcloud.psuccso.org/apps/forms/s/fcSxKGQYpd8xEK3wtmMa8BwW'
  },
  {
    id: 'social-media-chair',
    title: 'Social Media Chair',
    description: 'Manage our social media presence across platforms. Create engaging content, grow our following, and help promote club events and achievements.',
    icon: MegaphoneIcon,
    formUrl: 'https://nextcloud.psuccso.org/apps/forms/s/CnNsz3CcintxPirLzYGi96rR'
  },
  {
    id: 'tech-team',
    title: 'Tech Team',
    description: 'Help maintain and improve our infrastructure. No experience required, just a willingness to learn.',
    icon: RocketLaunchIcon,
    formUrl: 'https://nextcloud.psuccso.org/apps/forms/s/8sE46Q2qfFbwZKKz3jCwBY3L'
  }
])
</script>

<style scoped>
.join-hero {
  padding-top: 2rem;
}

.hero-content {
  text-align: center;
  max-width: 900px;
  margin: 0 auto;
}

.hero-content p {
  color: #9AA5CB;
  font-size: 1.2em;
  line-height: 1.7;
  margin-bottom: 2rem;
}

.hero-highlights {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.highlight-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(0, 69, 141, 0.3);
  padding: 0.75rem 1.25rem;
  border-radius: 50px;
  border: 1px solid #00458d;
  color: #AEB6D5;
  font-size: 0.95em;
  transition: all 0.3s ease;
}

.highlight-item:hover {
  background: rgba(0, 69, 141, 0.5);
  border-color: #ffc300ff;
  transform: translateY(-2px);
}

.highlight-icon {
  width: 20px;
  height: 20px;
  color: #ffc300ff;
}

.positions-intro {
  text-align: center;
  color: #9AA5CB;
  font-size: 1.1em;
  max-width: 700px;
  margin: 0 auto 3rem auto;
  line-height: 1.6;
}

.positions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}

.position-card {
  background: rgba(0, 0, 0, 0.53);
  border: 2px solid #003566ff;
  border-radius: 1rem;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.position-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #00458d, #ffc300ff, #00458d);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.position-card:hover {
  border-color: #00458d;
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 69, 141, 0.3);
}

.position-card:hover::before {
  opacity: 1;
}

.position-icon {
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #00458d, #00053e);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.25rem;
  color: #ffc300ff;
  transition: all 0.3s ease;
}

.position-card:hover .position-icon {
  transform: scale(1.1) rotate(5deg);
  box-shadow: 0 0 20px rgba(255, 195, 0, 0.3);
}

.position-title {
  color: #AEB6D5 !important;
  font-size: 1.4em;
  font-weight: 600;
  margin-bottom: 0.75rem;
  letter-spacing: 1px;
}

.position-description {
  color: #9AA5CB;
  font-size: 0.95em;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.apply-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.5rem;
  background: linear-gradient(135deg, #00458d, #003566);
  color: #ffffff;
  text-decoration: none;
  font-size: 0.95em;
  font-weight: 600;
  border-radius: 50px;
  border: 2px solid transparent;
  transition: all 0.3s ease;
  letter-spacing: 0.5px;
}

.apply-btn:hover {
  background: linear-gradient(135deg, #ffc300ff, #e6b000);
  color: #00053e;
  transform: scale(1.05);
  box-shadow: 0 5px 20px rgba(255, 195, 0, 0.3);
}

.no-positions {
  text-align: center;
  padding: 3rem;
  color: #9AA5CB;
}

.no-positions p {
  font-size: 1.1em;
  max-width: 500px;
  margin: 0 auto;
}

/* Benefits Section */
.benefits-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}

.benefit-card {
  background: rgba(0, 0, 0, 0.4);
  border: 1px solid #00458d;
  border-radius: 1rem;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
}

.benefit-card:hover {
  background: rgba(0, 69, 141, 0.2);
  border-color: #00458d;
  transform: translateY(-3px);
}

.benefit-icon {
  width: 48px;
  height: 48px;
  color: #ffc300ff;
  margin: 0 auto 1rem auto;
}

.benefit-card h4 {
  color: #AEB6D5 !important;
  font-size: 1.2em;
  margin-bottom: 0.75rem;
}

.benefit-card p {
  color: #9AA5CB;
  font-size: 0.95em;
  line-height: 1.5;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .hero-highlights {
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }

  .highlight-item {
    width: 100%;
    max-width: 300px;
    justify-content: center;
  }

  .positions-grid {
    grid-template-columns: 1fr;
  }

  .benefits-grid {
    grid-template-columns: 1fr;
  }

  .position-card {
    padding: 1.5rem;
  }

  .hero-content p {
    font-size: 1.1em;
    padding: 0 1rem;
  }
}

@media (max-width: 480px) {
  .position-title {
    font-size: 1.2em;
  }

  .position-description {
    font-size: 0.9em;
  }

  .apply-btn {
    padding: 0.6rem 1.2rem;
    font-size: 0.9em;
  }

  .benefit-card {
    padding: 1.5rem;
  }

  .benefit-icon {
    width: 40px;
    height: 40px;
  }
}
</style>

