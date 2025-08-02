<template>
  <div class="sponsors-page min-h-screen">
    <h2 class="section-title">&lt;Sponsors/&gt;</h2>
    <section class="sponsors-cont">
      <!-- Loading State -->
      <div v-if="loading" class="space-y-8">
        <div v-for="n in 3" :key="n" class="tier">
          <div class="h-8 bg-gray-400 rounded w-64 mx-auto mb-4 animate-pulse"></div>
          <div class="tier-sponsors">
            <div v-for="i in 3" :key="i" class="sponsor animate-pulse">
              <div class="bg-gray-500 w-full h-full rounded"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="tier">
        <h2>Error Loading Sponsors</h2>
        <div class="bg-red-900/50 border border-red-500 rounded-lg p-6 max-w-md mx-auto">
          <p class="text-red-300 mb-4">Failed to load sponsors: {{ error }}</p>
          <button 
            @click="retryLoad" 
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors"
          >
            Retry
          </button>
        </div>
      </div>

      <!-- Sponsors by Tier -->
      <div v-else>
        <!-- Gold Sponsors -->
        <div v-if="getGoldSponsors().length" class="resource">
          <h3>Thank you to our <span style="color: #F4C267">Gold</span> Sponsors!</h3>
          <div class="tier-sponsors">
            <a
              v-for="sponsor in getGoldSponsors()"
              :key="sponsor.id"
              :href="sponsor.url || '#'"
              :target="sponsor.url ? '_blank' : '_self'"
              :rel="sponsor.url ? 'noopener noreferrer' : ''"
              class="sponsor"
            >
              <img 
                v-if="sponsor.logo?.url"
                :src="getStrapiMediaUrl(sponsor.logo.url)"
                :alt="sponsor.name + ' logo'"
              />
              <div 
                v-else 
                class="flex items-center justify-center h-full text-gray-400"
              >
                No Logo
              </div>
              <h3>{{ sponsor.name }}</h3>
            </a>
          </div>
        </div>

        <!-- Silver Sponsors -->
        <div v-if="getSilverSponsors().length" class="resource">
          <h3>Thank you to our <span style="color: #C0C0C0">Silver</span> Sponsors!</h3>
          <div class="tier-sponsors">
            <a
              v-for="sponsor in getSilverSponsors()"
              :key="sponsor.id"
              :href="sponsor.url || '#'"
              :target="sponsor.url ? '_blank' : '_self'"
              :rel="sponsor.url ? 'noopener noreferrer' : ''"
              class="sponsor"
            >
              <img 
                v-if="sponsor.logo?.url"
                :src="getStrapiMediaUrl(sponsor.logo.url)"
                :alt="sponsor.name + ' logo'"
              />
              <div 
                v-else 
                class="flex items-center justify-center h-full text-gray-400"
              >
                No Logo
              </div>
              <h3>{{ sponsor.name }}</h3>
            </a>
          </div>
        </div>

        <!-- Bronze Sponsors -->
        <div v-if="getBronzeSponsors().length" class="resource">
          <h3>Thank you to our <span style="color: #CD7F32">Bronze</span> Sponsors!</h3>
          <div class="tier-sponsors">
            <a
              v-for="sponsor in getBronzeSponsors()"
              :key="sponsor.id"
              :href="sponsor.url || '#'"
              :target="sponsor.url ? '_blank' : '_self'"
              :rel="sponsor.url ? 'noopener noreferrer' : ''"
              class="sponsor"
            >
              <img 
                v-if="sponsor.logo?.url"
                :src="getStrapiMediaUrl(sponsor.logo.url)"
                :alt="sponsor.name + ' logo'"
              />
              <div 
                v-else 
                class="flex items-center justify-center h-full text-gray-400"
              >
                No Logo
              </div>
              <h3>{{ sponsor.name }}</h3>
            </a>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!getGoldSponsors().length && !getSilverSponsors().length && !getBronzeSponsors().length" class="resource">
          <h3>No Sponsors Yet</h3>
          <div>
            <p>We're currently looking for sponsors to support our mission.</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useSponsors } from '@/composables/useStrapi'
import { getStrapiMediaUrl } from '@/utils/api'

const { 
  sponsors, 
  loading, 
  error, 
  loadSponsors,
  getGoldSponsors,
  getSilverSponsors,
  getBronzeSponsors
} = useSponsors()

const retryLoad = async () => {
  try {
    await loadSponsors()
  } catch (err) {
    console.error('Failed to reload sponsors:', err)
  }
}

onMounted(async () => {
  try {
    await loadSponsors()
  } catch (err) {
    console.error('Failed to load sponsors:', err)
  }
})
</script>

<style scoped>
/*Designed and Developed by Aiden Johnson | TGM.One*/
h2.section-title {
  text-align: center;
  color: #8594C0;
  font-size: 2.5em;
  font-weight: 700;
  letter-spacing: 2px;
  margin-bottom: 1.5em;
  margin-top: 1em;
}

section.sponsors-cont {
  max-width: 1100px;
  margin: 0 auto;
  text-align: center;
  padding: 0 1rem;
}

/* Resource container - basic spacing */
.resource {
  margin-bottom: 1em;
  text-align: center;
}

/* H3 styling with background and border (matching resources page) - only for tier titles */
.resource > h3 {
  background-color: rgba(0, 0, 0, 0.53);
  border: 5px solid;
  border-image-slice: 1;
  border-width: 5px;
  border-image-source: linear-gradient(to right, #007BFF, #0065D1, #007BFF);
  padding: 10px;
  color: #9AA5CB;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1em;
  text-align: center;
}

.resource div {
  color: #9AA5CB;
  padding: 5px 5px 0 5px;
}

.tier-sponsors {
  display: flex;
  flex-wrap: wrap;
  gap: 32px;
  justify-content: center;
  margin: 0;
  padding: 0;
}

.sponsor {
  flex: 1 1 calc(30% - 16px);
  max-width: 30%;
  background-color: #212121;
  position: relative;
  border: 5px solid;
  border-image-slice: 1;
  border-width: 5px;
  border-image-source: linear-gradient(to right, #007BFF, #0065D1, #007BFF);
  padding: 20px;
  color: white;
  height: 250px;
  text-decoration: none;
  display: block;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.sponsor:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.sponsor img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: calc(100% - 20px);
  max-height: calc(100% - 60px);
  padding: 10px;
  object-fit: contain;
}

.sponsor h3 {
  color: white;
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
  width: calc(100% - 20px);
  font-size: 1rem;
  font-weight: 600;
  margin: 0;
  text-align: center;
}

@media (max-width: 780px) {
  .sponsor {
    flex: 1 1 calc(100%);
    max-width: 80%;
  }
  
  h2.section-title {
    font-size: 2rem;
  }
  
  .tier h2 {
    font-size: 1.5em;
  }
}

@media (max-width: 480px) {
  .sponsor {
    max-width: 90%;
    height: 200px;
  }
  
  .tier h2 {
    font-size: 1.3em;
  }
  
  section.sponsors-cont {
    padding: 0 0.5rem;
  }
}
</style>