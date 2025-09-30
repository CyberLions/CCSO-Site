// src/utils/api.js
import qs from 'qs'

// Prefer Nuxt runtime config when available
let useRuntimeConfigSafely = undefined

// Function to initialize runtime config safely
async function initializeRuntimeConfig() {
  if (useRuntimeConfigSafely !== undefined) {
    return useRuntimeConfigSafely
  }
  
  try {
    // This import only works in Nuxt runtime; guarded to avoid build-time issues
    // eslint-disable-next-line no-undef
    const mod = await import('#app')
    useRuntimeConfigSafely = mod.useRuntimeConfig
    return useRuntimeConfigSafely
  } catch (_) {
    useRuntimeConfigSafely = null
    return null
  }
}

async function getStrapiToken() {
  // Try Nuxt runtime config (server or client)
  try {
    const runtimeConfig = await initializeRuntimeConfig()
    if (typeof runtimeConfig === 'function') {
      const cfg = runtimeConfig()
      if (cfg?.public?.NUXT_STRAPI_API_TOKEN) return cfg.public.NUXT_STRAPI_API_TOKEN
      if (cfg?.public?.strapiApiToken) return cfg.public.strapiApiToken
    }
  } catch (_) {}
  // Client-side window injection via public/env.js
  if (typeof window !== 'undefined' && window?.ENV?.NUXT_STRAPI_API_TOKEN) {
    return window.ENV.NUXT_STRAPI_API_TOKEN
  }
  // Vite/Nuxt env fallbacks
  return import.meta?.env?.NUXT_PUBLIC_STRAPI_API_TOKEN || ''
}

// Simple in-memory cache for faster content loading
const cache = new Map()
const CACHE_DURATION = 5 * 60 * 1000 // 5 minutes

export function getApiUrl() {
  // Nuxt runtime config first
  try {
    const runtimeConfig = initializeRuntimeConfig()
    if (typeof runtimeConfig === 'function') {
      const cfg = runtimeConfig()
      if (cfg?.public?.apiBase) return cfg.public.apiBase
      if (cfg?.public?.NUXT_API_URL) return cfg.public.NUXT_API_URL
    }
  } catch (_) {}
  // Client-side window injection via public/env.js
  if (typeof window !== 'undefined' && window?.ENV?.NUXT_API_URL) {
    return window.ENV.NUXT_API_URL
  }
  // In development, use relative path for proxy
  if (import.meta.env.DEV) {
    return ''
  }
  return (
    import.meta.env.NUXT_PUBLIC_API_BASE ||
    import.meta.env.NUXT_API_URL ||
    '/api'
  )
}

export function buildApiUrl(endpoint) {
  const baseUrl = getApiUrl().replace(/\/$/, '')
  const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`
  return `${baseUrl}${cleanEndpoint}`
}

export function buildStrapiUrl(endpoint) {
  const baseUrl = getApiUrl().replace(/\/$/, '')
  const apiPath = '/api'
  const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`
  return `${baseUrl}${apiPath}${cleanEndpoint}`
}

// Generic API request function
export async function apiRequest(endpoint, options = {}) {
  const url = buildApiUrl(endpoint)
  const token = localStorage.getItem('token')
  const defaultHeaders = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    ...(token && { Authorization: `Bearer ${token}` }),
  }
  const config = {
    ...options,
    headers: { ...defaultHeaders, ...options.headers },
  }
  return fetch(url, config)
}

// Strapi-specific API request function
export async function strapiRequest(endpoint, options = {}) {
  const cacheKey = `${endpoint}-${JSON.stringify(options)}`
  
  // Check cache first for GET requests
  if ((!options.method || options.method === 'GET') && cache.has(cacheKey)) {
    const cached = cache.get(cacheKey)
    if (Date.now() - cached.timestamp < CACHE_DURATION) {
      return { data: cached.data, fromCache: true }
    }
    cache.delete(cacheKey)
  }

  const url = buildStrapiUrl(endpoint)
  const defaultHeaders = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    Authorization: `Bearer ${await getStrapiToken()}`,
  }
  
  const config = {
    ...options,
    headers: { ...defaultHeaders, ...options.headers },
  }

  try {
    const response = await fetch(url, config)
    
    if (!response.ok) {
      const errorData = await response.json().catch(() => ({}))
      throw new Error(errorData.error?.message || `HTTP ${response.status}: ${response.statusText}`)
    }

    const data = await response.json()
    
    // Cache successful GET requests
    if (!options.method || options.method === 'GET') {
      cache.set(cacheKey, {
        data,
        timestamp: Date.now()
      })
    }

    return { data, fromCache: false }
  } catch (error) {
    console.error('Strapi API Error:', error)
    throw error
  }
}

// Build query string for Strapi API
export function buildQuery(params = {}) {
  return qs.stringify(params, {
    encodeValuesOnly: true,
  })
}

// STRAPI API METHODS

// About page
export async function fetchAbout(params = {}) {
  const query = buildQuery({
    populate: '*',
    ...params
  })
  const { data } = await strapiRequest(`/about?${query}`)
  return data
}

// Global settings
export async function fetchGlobal(params = {}) {
  const query = buildQuery({
    populate: {
      defaultSeo: {
        populate: '*'
      },
      favicon: true
    },
    ...params
  })
  const { data } = await strapiRequest(`/global?${query}`)
  return data
}

// Board members
export async function fetchBoards(params = {}) {
  const query = buildQuery({
    populate: {
      team: {
        populate: {
          officer: {
            populate: '*'
          }
        }
      }
    },
    sort: 'year:desc',
    ...params
  })
  const { data } = await strapiRequest(`/boards?${query}`)
  return data
}

export async function fetchBoard(id, params = {}) {
  const query = buildQuery({
    populate: {
      team: {
        populate: {
          officer: {
            populate: '*'
          }
        }
      }
    },
    ...params
  })
  const { data } = await strapiRequest(`/boards/${id}?${query}`)
  return data
}

// Competitions
export async function fetchCompetitions(params = {}) {
  const query = buildQuery({
    populate: '*',
    sort: 'date:desc',
    ...params
  })
  const { data } = await strapiRequest(`/competitions?${query}`)
  return data
}

export async function fetchCompetition(id, params = {}) {
  const query = buildQuery({
    populate: '*',
    ...params
  })
  const { data } = await strapiRequest(`/competitions/${id}?${query}`)
  return data
}

// Resources
export async function fetchResources(params = {}) {
  const query = buildQuery({
    populate: '*',
    sort: 'createdAt:desc',
    ...params
  })
  const { data } = await strapiRequest(`/resources?${query}`)
  return data
}

export async function fetchResource(id, params = {}) {
  const query = buildQuery({
    populate: '*',
    ...params
  })
  const { data } = await strapiRequest(`/resources/${id}?${query}`)
  return data
}

// Sponsors
export async function fetchSponsors(params = {}) {
  const query = buildQuery({
    populate: '*',
    sort: 'tier:asc',
    ...params
  })
  const { data } = await strapiRequest(`/sponsors?${query}`)
  return data
}

export async function fetchSponsor(id, params = {}) {
  const query = buildQuery({
    populate: '*',
    ...params
  })
  const { data } = await strapiRequest(`/sponsors/${id}?${query}`)
  return data
}

// Home
export async function fetchHome(params = {}) {
  const query = buildQuery({
    populate: '*',
    ...params
  })
  const { data } = await strapiRequest(`/home?${query}`)
  return data
}

// What We Do
export async function fetchWhatWeDo(params = {}) {
  const query = buildQuery({
    populate: '*',
    ...params
  })
  const { data } = await strapiRequest(`/what-we-do?${query}`)
  return data
}

// Utility functions
export function getStrapiMediaUrl(mediaPath) {
  if (!mediaPath) return null
  if (mediaPath.startsWith('http')) return mediaPath
  const baseUrl = getApiUrl().replace(/\/$/, '')
  return `${baseUrl}${mediaPath}`
}

export function clearCache() {
  cache.clear()
}

export function getCacheSize() {
  return cache.size
}

// LEGACY API METHODS (keeping for backward compatibility)
export async function fetchTag(uuid) {
  const res = await apiRequest(`/v1/tags/${uuid}`)
  if (!res.ok) throw new Error('Failed to fetch tag')
  return res.json()
}

export async function fetchOwnerContact(ownerId) {
  const res = await apiRequest(`/v1/users/${ownerId}/contact`)
  if (!res.ok) throw new Error('Failed to fetch owner contact')
  return res.json()
}

export async function fetchOrg(orgId) {
  const res = await apiRequest(`/v1/orgs/${orgId}`)
  if (!res.ok) throw new Error('Failed to fetch org')
  return res.json()
}

export async function postTagEvent(uuid, data) {
  const res = await apiRequest(`/v1/tags/${uuid}/events`, {
    method: 'POST',
    body: JSON.stringify(data),
  })
  if (!res.ok) throw new Error('Failed to post event')
  return res.json()
}

export async function verifyEmail(token) {
  const res = await apiRequest('/v1/users/verify-email', {
    method: 'POST',
    body: JSON.stringify({ token }),
  })
  if (!res.ok) throw new Error('Email verification failed')
  return res.json()
}

export async function resendVerification(email) {
  const res = await apiRequest('/v1/users/resend-verification', {
    method: 'POST',
    body: JSON.stringify({ user_email: email }),
  })
  if (!res.ok) throw new Error('Failed to resend verification')
  return res.json()
}

// Lockpicking Leaderboard
export async function fetchLockpickingLeaderboards(params = {}) {
  const query = buildQuery({
    populate: '*',
    sort: 'time:asc',
    ...params
  })
  const { data } = await strapiRequest(`/lockpicking-leaderboards?${query}`)
  return data
}
