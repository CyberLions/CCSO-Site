<template>
  <div class="competitions-page min-h-screen">
    <!-- Loading State -->
    <div v-if="loading" class="year">
      <div class="max-w-[1100px] mx-auto px-4">
        <h2 class="section-title animate-pulse">
          <div class="h-8 bg-gray-300 rounded w-32 mx-auto"></div>
        </h2>
        <div class="year-cont">
          <div v-for="n in 3" :key="n" class="competition animate-pulse">
            <div class="competition-details">
              <div class="h-6 bg-gray-300 rounded mb-4"></div>
              <div class="h-4 bg-gray-300 rounded mb-4"></div>
              <div class="h-3 bg-gray-300 rounded w-3/4"></div>
            </div>
            <div class="members-img">
              <div class="bg-gray-300 rounded-lg w-full h-full"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="year">
      <div class="max-w-[1100px] mx-auto px-4 text-center py-12">
        <div class="bg-red-900/50 border border-red-500 rounded-lg p-6">
          <p class="text-red-300 mb-4">Failed to load competitions: {{ error }}</p>
          <button 
            @click="retryLoad" 
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors"
          >
            Retry
          </button>
        </div>
      </div>
    </div>

    <!-- Competitions by Year -->
    <div v-else>
      <section 
        v-for="yearGroup in competitionsByYear" 
        :key="yearGroup.year" 
        class="year"
      >
        <h2 class="section-title">&lt;{{ yearGroup.year }}/&gt;</h2>
        <div class="year-cont">
          <div 
            v-for="competition in yearGroup.competitions" 
            :key="competition.id" 
            class="competition"
          >
            <div class="competition-details">
              <h2>{{ competition.title }} - </h2>
              <h2 class="placing">{{ getPlacementText(competition.placement) }}</h2>
              <a 
                v-if="competition.article_url" 
                :href="competition.article_url" 
                target="_blank"
                rel="noopener noreferrer"
                class="excerpt"
              >
                {{ competition.excerpt || 'Read Article' }}
              </a>
              <p v-else class="excerpt-text">{{ competition.excerpt }}</p>
              <p v-if="competition.members" class="members">Members: {{ competition.members }}</p>
            </div>
            <div class="members-img">
              <img 
                v-if="competition.picture?.url"
                :src="getStrapiMediaUrl(competition.picture.url)"
                :alt="competition.title + ' team photo'"
                class="img-responsive"
              />
              <div 
                v-else 
                class="img-placeholder bg-gray-600/50 rounded-lg flex items-center justify-center"
              >
                <span class="text-gray-400">No image available</span>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Empty State -->
      <section v-if="!competitionsByYear.length" class="year">
        <div class="max-w-[1100px] mx-auto px-4 text-center py-12">
          <p class="text-gray-400 text-lg">No competitions found.</p>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useCompetitions } from '@/composables/useStrapi'
import { getStrapiMediaUrl } from '@/utils/api'

const { competitions, loading, error, loadCompetitions } = useCompetitions()

// Group competitions by year
const competitionsByYear = computed(() => {
  if (!competitions.value?.length) return []
  
  // First, sort all competitions by date (most recent first)
  const sortedCompetitions = [...competitions.value].sort((a, b) => {
    return new Date(b.date) - new Date(a.date)
  })
  
  const grouped = {}
  sortedCompetitions.forEach(competition => {
    const year = new Date(competition.date).getFullYear()
    if (!grouped[year]) {
      grouped[year] = []
    }
    grouped[year].push(competition)
  })
  
  // Sort years in descending order (most recent year first) and return as array
  const sortedYears = Object.keys(grouped)
    .map(year => parseInt(year))
    .sort((a, b) => b - a)
  
  // Return array of year objects to preserve order
  return sortedYears.map(year => ({
    year,
    competitions: grouped[year]
  }))
})

const getPlacementText = (placement) => {
  if (!placement) return ''
  const num = parseInt(placement)
  if (isNaN(num)) return placement
  
  const suffix = num === 1 ? 'st' : num === 2 ? 'nd' : num === 3 ? 'rd' : 'th'
  return `${num}${suffix} Place`
}

const retryLoad = async () => {
  try {
    await loadCompetitions()
  } catch (err) {
    console.error('Failed to reload competitions:', err)
  }
}

onMounted(async () => {
  try {
    await loadCompetitions()
  } catch (err) {
    console.error('Failed to load competitions:', err)
  }
})
</script>

<style scoped>
/*Designed and Developed by Aiden Johnson | TGM.One*/
h2.section-title {
  margin-top: 1em;
  text-align: center;
  color: #8594C0;
  font-size: 2.5em;
  font-weight: 700;
  letter-spacing: 2px;
  margin-bottom: 1.5em;
}

section.year {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 1rem;
}

.competition {
  display: flex;
  gap: 32px;
  margin-bottom: 2em;
}

.competition-details {
  flex: 1 1 calc(50% - 32px);
  background-color: rgba(0, 0, 0, 0.53);
  border: 6px solid;
  border-image-slice: 1;
  border-width: 6px;
  border-radius: 6px;
  border-image-source: linear-gradient(to right, #007BFF, #0065D1, #007BFF);
  padding: 20px;
  text-align: center;
  color: #AEB6D5;
}

.competition .members-img {
  flex: 1 1 calc(50% - 32px);
  contain: strict;
  border-radius: 10px;
  height: auto;
  min-height: 200px;
}

.members-img img,
.img-placeholder {
  border-radius: 10px;
  height: 100%;
  width: 100%;
  object-fit: cover;
  margin: 0 auto;
}

.img-placeholder {
  min-height: 200px;
}

.competition-details h2 {
  display: inline-block;
  color: #AEB6D5;
  margin-bottom: 30px;
  font-size: 1.5rem;
  font-weight: 600;
}

.competition-details .placing {
  display: inline-block;
  color: #F4C267;
  font-weight: bold;
}

.competition-details .excerpt {
  display: block;
  color: #AEB6D5;
  text-decoration: underline;
  margin-bottom: 30px;
  cursor: pointer;
  transition: color 0.2s;
}

.competition-details .excerpt:hover {
  color: #007BFF;
}

.competition-details .excerpt-text {
  display: block;
  color: #AEB6D5;
  margin-bottom: 30px;
}

.competition-details .members {
  font-size: 11px;
  color: #AEB6D5;
  margin: 0;
}

@media (max-width: 780px) {
  .competition {
    flex-direction: column;
    gap: 5px;
  }
  
  .competition-details {
    flex: 1 1 calc(100%);
    order: 2;
    margin: 0 1em;
  }
  
  .competition .members-img {
    flex: 1 1 calc(100%);
    max-height: 300px;
    contain: content;
    order: 1;
  }
  
  .members-img img,
  .img-placeholder {
    max-height: 300px;
    height: 100%;
    width: auto;
    object-fit: scale-down;
  }
  
  h2.section-title {
    font-size: 2rem;
  }
}
</style>
