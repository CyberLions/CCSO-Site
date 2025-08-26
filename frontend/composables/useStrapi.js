// src/composables/useStrapi.js
import { ref, reactive, computed } from 'vue'
import {
  fetchAbout,
  fetchGlobal,
  fetchBoards,
  fetchBoard,
  fetchCompetitions,
  fetchCompetition,
  fetchResources,
  fetchResource,
  fetchSponsors,
  fetchSponsor,
  fetchHome,
  fetchWhatWeDo,
  getStrapiMediaUrl,
  clearCache,
  getCacheSize
} from '../utils/api'

// Global state for shared data
const globalState = reactive({
  global: null,
  about: null,
  loading: false,
  error: null
})

// Composable for Strapi data management
export function useStrapi() {
  const loading = ref(false)
  const error = ref(null)

  const setLoading = (isLoading) => {
    loading.value = isLoading
    globalState.loading = isLoading
  }

  const setError = (err) => {
    error.value = err
    globalState.error = err
  }

  const clearError = () => {
    error.value = null
    globalState.error = null
  }

  // Generic fetch function with loading and error handling
  const fetchWithState = async (fetchFn, ...args) => {
    setLoading(true)
    clearError()
    
    try {
      const result = await fetchFn(...args)
      return result
    } catch (err) {
      console.error('Strapi fetch error:', err)
      setError(err.message || 'Failed to fetch data')
      throw err
    } finally {
      setLoading(false)
    }
  }

  return {
    // State
    loading: computed(() => loading.value),
    error: computed(() => error.value),
    globalState,

    // Actions
    clearError,
    clearCache,
    getCacheSize,

    // Global data
    fetchGlobal: (params) => fetchWithState(fetchGlobal, params),
    fetchAbout: (params) => fetchWithState(fetchAbout, params),

    // Board data
    fetchBoards: (params) => fetchWithState(fetchBoards, params),
    fetchBoard: (id, params) => fetchWithState(fetchBoard, id, params),

    // Competition data
    fetchCompetitions: (params) => fetchWithState(fetchCompetitions, params),
    fetchCompetition: (id, params) => fetchWithState(fetchCompetition, id, params),

    // Resource data
    fetchResources: (params) => fetchWithState(fetchResources, params),
    fetchResource: (id, params) => fetchWithState(fetchResource, id, params),

    // Sponsor data
    fetchSponsors: (params) => fetchWithState(fetchSponsors, params),
    fetchSponsor: (id, params) => fetchWithState(fetchSponsor, id, params),

    // Home data
    fetchHome: (params) => fetchWithState(fetchHome, params),

    // What We Do data
    fetchWhatWeDo: (params) => fetchWithState(fetchWhatWeDo, params),

    // Utilities
    getStrapiMediaUrl
  }
}

// Specific composables for different content types
export function useGlobal() {
  const { fetchGlobal, loading, error } = useStrapi()
  const global = ref(globalState.global)

  const loadGlobal = async (params = {}) => {
    if (!global.value) {
      const data = await fetchGlobal(params)
      global.value = data?.data
      globalState.global = global.value
    }
    return global.value
  }

  return {
    global: computed(() => global.value),
    loading,
    error,
    loadGlobal
  }
}

export function useAbout() {
  const { fetchAbout, loading, error } = useStrapi()
  const about = ref(globalState.about)

  const loadAbout = async (params = {}) => {
    const data = await fetchAbout(params)
    about.value = data?.data
    globalState.about = about.value
    return about.value
  }

  return {
    about: computed(() => about.value),
    loading,
    error,
    loadAbout
  }
}

export function useBoards() {
  const { fetchBoards, fetchBoard, loading, error } = useStrapi()
  const boards = ref([])
  const currentBoard = ref(null)

  const loadBoards = async (params = {}) => {
    const data = await fetchBoards(params)
    boards.value = data?.data || []
    return boards.value
  }

  const loadBoard = async (id, params = {}) => {
    const data = await fetchBoard(id, params)
    currentBoard.value = data?.data
    return currentBoard.value
  }

  const getCurrentBoard = () => {
    const currentYear = new Date().getFullYear()
    return boards.value.find(board => board.year === currentYear) || boards.value[0]
  }

  return {
    boards: computed(() => boards.value),
    currentBoard: computed(() => currentBoard.value),
    loading,
    error,
    loadBoards,
    loadBoard,
    getCurrentBoard
  }
}

export function useCompetitions() {
  const { fetchCompetitions, fetchCompetition, loading, error } = useStrapi()
  const competitions = ref([])
  const currentCompetition = ref(null)

  const loadCompetitions = async (params = {}) => {
    const data = await fetchCompetitions(params)
    competitions.value = data?.data || []
    return competitions.value
  }

  const loadCompetition = async (id, params = {}) => {
    const data = await fetchCompetition(id, params)
    currentCompetition.value = data?.data
    return currentCompetition.value
  }

  const getRecentCompetitions = (limit = 5) => {
    return competitions.value.slice(0, limit)
  }

  const getCompetitionsByYear = (year) => {
    return competitions.value.filter(comp => {
      const compYear = new Date(comp.date).getFullYear()
      return compYear === year
    })
  }

  return {
    competitions: computed(() => competitions.value),
    currentCompetition: computed(() => currentCompetition.value),
    loading,
    error,
    loadCompetitions,
    loadCompetition,
    getRecentCompetitions,
    getCompetitionsByYear
  }
}

export function useResources() {
  const { fetchResources, fetchResource, loading, error } = useStrapi()
  const resources = ref([])
  const currentResource = ref(null)

  const loadResources = async (params = {}) => {
    const data = await fetchResources(params)
    resources.value = data?.data || []
    return resources.value
  }

  const loadResource = async (id, params = {}) => {
    const data = await fetchResource(id, params)
    currentResource.value = data?.data
    return currentResource.value
  }

  return {
    resources: computed(() => resources.value),
    currentResource: computed(() => currentResource.value),
    loading,
    error,
    loadResources,
    loadResource
  }
}

export function useHome() {
  const { fetchHome, loading, error } = useStrapi()
  const home = ref(null)

  const loadHome = async (params = {}) => {
    const data = await fetchHome(params)
    home.value = data?.data
    return home.value
  }

  return {
    home: computed(() => home.value),
    loading,
    error,
    loadHome
  }
}

export function useWhatWeDo() {
  const { fetchWhatWeDo, loading, error } = useStrapi()
  const whatWeDo = ref(null)

  const loadWhatWeDo = async (params = {}) => {
    const data = await fetchWhatWeDo(params)
    whatWeDo.value = data?.data
    return whatWeDo.value
  }

  return {
    whatWeDo: computed(() => whatWeDo.value),
    loading,
    error,
    loadWhatWeDo
  }
}