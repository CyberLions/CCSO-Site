import { ref, computed } from 'vue'
import { fetchSponsors } from '../utils/api'

export function useSponsors() {
  const sponsors = ref([])
  const loading = ref(false)
  const error = ref(null)

  const loadSponsors = async (params = {}) => {
    loading.value = true
    error.value = null
    
    try {
      const data = await fetchSponsors(params)
      sponsors.value = data?.data || []
      return sponsors.value
    } catch (err) {
      console.error('Failed to load sponsors:', err)
      error.value = err.message || 'Failed to load sponsors'
      throw err
    } finally {
      loading.value = false
    }
  }

  // Computed properties for different sponsor tiers
  const goldSponsors = computed(() => 
    sponsors.value.filter(sponsor => sponsor.tier === 'gold')
  )
  
  const silverSponsors = computed(() => 
    sponsors.value.filter(sponsor => sponsor.tier === 'silver')
  )
  
  const bronzeSponsors = computed(() => 
    sponsors.value.filter(sponsor => sponsor.tier === 'bronze')
  )
  
  const resourceSponsors = computed(() => 
    sponsors.value.filter(sponsor => sponsor.tier === 'resource')
  )

  const hasSponsors = computed(() => 
    goldSponsors.value.length > 0 || 
    silverSponsors.value.length > 0 || 
    bronzeSponsors.value.length > 0 ||
    resourceSponsors.value.length > 0
  )

  return {
    // State
    sponsors: computed(() => sponsors.value),
    loading: computed(() => loading.value),
    error: computed(() => error.value),
    
    // Computed sponsor tiers
    goldSponsors,
    silverSponsors,
    bronzeSponsors,
    resourceSponsors,
    hasSponsors,
    
    // Actions
    loadSponsors
  }
}
