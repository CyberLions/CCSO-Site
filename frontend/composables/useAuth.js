// src/composables/useAuth.js
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { apiRequest } from '../utils/api'

const authToken = ref(localStorage.getItem('token'))
const userData = ref(JSON.parse(localStorage.getItem('user') || 'null'))

export function useAuth() {
  const router = useRouter()
  const isLoggedIn = computed(() => !!authToken.value)
  const user = computed(() => userData.value)

  const updateUserData = () => {
    authToken.value = localStorage.getItem('token')
    const userStr = localStorage.getItem('user')
    userData.value = userStr ? JSON.parse(userStr) : null
  }

  const handleAuthChange = event => {
    authToken.value = event.detail.token
    userData.value = event.detail.user
    if (!event.detail.token) {
      router.push('/login')
    }
  }

  const handleStorageChange = event => {
    if (event.key === 'token' || event.key === 'user') {
      updateUserData()
    }
  }

  const handleSignOut = async () => {
    try {
      await apiRequest('/api/v1/users/logout', { method: 'POST' })
    } catch (error) {
      console.error('Logout API call failed, signing out locally.', error)
    } finally {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      window.dispatchEvent(
        new CustomEvent('auth-change', {
          detail: { token: null, user: null },
        })
      )
    }
  }

  onMounted(() => {
    window.addEventListener('auth-change', handleAuthChange)
    window.addEventListener('storage', handleStorageChange)
    updateUserData()
  })

  onUnmounted(() => {
    window.removeEventListener('auth-change', handleAuthChange)
    window.removeEventListener('storage', handleStorageChange)
  })

  return { isLoggedIn, user, handleSignOut }
}
