<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section class="home-about">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="row featured-section">
          <h2 class="section-title">&lt;About Us/&gt;</h2>
          <p class="text-center">The purpose of the Penn State Competitive Cyber Security Organization is to provide members with an academic outlet to pursue and refine their cyber defense and security skills, collaborate with members of other technology-related clubs, expand their technical acumen, and provide the opportunity to apply such acumen in competitive environments through participation in various cyber security competitions.</p>
        </div>
      </div>
    </section>

    <!-- Officers Section -->
    <section class="club-officers content-section">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="row officers officers-section">
          <span class="year-selector cursor-pointer" id="prev-year" @click="goToOlderYear" v-if="currentYearIndex < years.length - 1">
            <ChevronLeftIcon class="w-4 h-4 inline mr-1" />
            {{ getOlderYearRange() }}
          </span>
          <span class="year-selector cursor-pointer" id="next-year" @click="goToNewerYear" v-if="currentYearIndex > 0">
            {{ getNewerYearRange() }}
            <ChevronRightIcon class="w-4 h-4 inline ml-1" />
          </span>
          <h3 class="section-title" :class="{ 'transitioning': isTransitioning }">&lt;{{ formatYearRange(currentYear) }}/&gt;</h3>
          <div id="boards-container" :class="{ 'transitioning': isTransitioning }">
            <div v-for="board in currentBoards" :key="board.title" class="mb-12 board-item">
              <h4 class="text-4xl font-bold text-center mb-8 secondary-title">{{ board.title }}</h4>
              <div class="officer-cont">
                <div
                  v-for="officer in board.officers"
                  :key="officer.name"
                  class="officer"
                >
                  <div class="aspect-square bg-gray-200 flex items-center justify-center w-52 h-52 rounded-full mx-auto mb-4 border-4 border-blue-600">
                    <img
                      v-if="officer.img && officer.img !== ''"
                      :src="officer.img"
                      :alt="officer.name"
                      class="w-full h-full object-cover rounded-full"
                    />
                    <UserIcon v-else class="w-16 h-16 text-gray-400" />
                  </div>
                  <h5 class="secondary-title">{{ officer.name }}</h5>
                  <p class="text-white">{{ officer.position }}</p>
                  <a
                    v-if="officer.url && officer.url !== ''"
                    :href="officer.url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors mt-2"
                  >
                    <LinkIcon class="w-4 h-4 mr-1" />
                    Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { UserIcon, LinkIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import { useBoards } from '@/composables/useStrapi'
import { getStrapiMediaUrl } from '@/utils/api'

const { boards, loading, error, loadBoards } = useBoards()

const currentYearIndex = ref(0)
const isTransitioning = ref(false)

// Computed properties for board data
const years = computed(() => {
  if (!boards.value?.length) return []
  return boards.value
    .map(board => board.year)
    .filter(Boolean)
    .sort((a, b) => b - a)
})

const currentYear = computed(() => years.value[currentYearIndex.value])

const currentBoards = computed(() => {
  if (!boards.value?.length || !currentYear.value) return []
  
  const yearBoard = boards.value.find(board => board.year === currentYear.value)
  if (!yearBoard?.team) return []

  // Group officers by team title
  const teamsMap = new Map()
  
  yearBoard.team.forEach(teamItem => {
    const teamTitle = teamItem.title || 'Executive Board'
    
    if (!teamsMap.has(teamTitle)) {
      teamsMap.set(teamTitle, {
        title: teamTitle,
        officers: []
      })
    }
    
    // Add officers from this team
    if (teamItem.officer && Array.isArray(teamItem.officer)) {
      teamItem.officer.forEach(officer => {
        const officerData = {
          name: officer.name,
          position: officer.position,
          img: officer.picture?.url ? getStrapiMediaUrl(officer.picture.url) : '',
          url: officer.url || ''
        }
        teamsMap.get(teamTitle).officers.push(officerData)
      })
    }
  })
  
  return Array.from(teamsMap.values())
})

const goToOlderYear = async () => {
  if (currentYearIndex.value < years.value.length - 1) {
    isTransitioning.value = true
    await new Promise(resolve => setTimeout(resolve, 150))
    currentYearIndex.value++
    await new Promise(resolve => setTimeout(resolve, 150))
    isTransitioning.value = false
  }
}

const goToNewerYear = async () => {
  if (currentYearIndex.value > 0) {
    isTransitioning.value = true
    await new Promise(resolve => setTimeout(resolve, 150))
    currentYearIndex.value--
    await new Promise(resolve => setTimeout(resolve, 150))
    isTransitioning.value = false
  }
}

const formatYearRange = (year) => {
  if (!year) return ''
  const yearNum = Number(year)
  return `${yearNum}-${yearNum + 1}`
}

const getNewerYearRange = () => {
  if (currentYearIndex.value > 0) {
    const newerYear = years.value[currentYearIndex.value - 1]
    return formatYearRange(newerYear)
  }
  return ''
}

const getOlderYearRange = () => {
  if (currentYearIndex.value < years.value.length - 1) {
    const olderYear = years.value[currentYearIndex.value + 1]
    return formatYearRange(olderYear)
  }
  return ''
}

onMounted(async () => {
  try {
    await loadBoards()
  } catch (err) {
    console.error('Failed to load boards:', err)
  }
})
</script>

<style scoped>
.officer-cont {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 16px;
  max-width: 1100px;
  margin: 0 auto;
}

.officer-cont .officer {
  flex: 1 1 calc(30% - 16px);
  padding: 1em;
  text-align: center;
}

.officer-cont .officer h5 {
  color: #8594C0;
  font-size: 1.3em;
  letter-spacing: 2px;
  margin-bottom: 0;
}

.officer-cont .officer p {
  color: #ffffff;
  font-size: 1.2em;
}

.year-selector {
  color: #8594C0;
  position: absolute;
  font-size: 1em;
  font-weight: 700;
  word-spacing: 15px;
  letter-spacing: 3px;
  top: 10px;
  display: flex;
  align-items: center;
}

#prev-year {
  left: 10px;
}

#next-year {
  right: 10px;
}

#boards-container {
  transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
  opacity: 1;
  transform: translateY(0);
}

#boards-container.transitioning {
  opacity: 0.3;
  transform: translateY(10px);
}

.board-item {
  transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.year-selector:hover {
  opacity: 0.8;
  transform: scale(1.05);
}

.year-selector {
  transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
}

.section-title {
  transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.section-title.transitioning {
  opacity: 0.6;
  transform: scale(0.98);
}

@media (max-width: 768px) {
  .officer-cont .officer {
    flex: 1 1 calc(50% - 16px);
  }
}

@media (max-width: 480px) {
  .officer-cont .officer {
    flex: 1 1 calc(100% - 16px);
  }
}
</style>