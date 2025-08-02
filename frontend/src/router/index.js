// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../views/HomeView.vue'),
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue'),
  },
  {
    path: '/get-involved',
    name: 'get-involved',
    component: () => import('../views/GetInvolvedView.vue'),
  },
  {
    path: '/competitions',
    name: 'competitions',
    component: () => import('../views/CompetitionsView.vue'),
  },
  {
    path: '/mixer',
    name: 'mixer',
    component: () => import('../views/MixerView.vue'),
  },
  {
    path: '/resources',
    name: 'resources',
    component: () => import('../views/ResourcesView.vue'),
  },
  {
    path: '/sponsors',
    name: 'sponsors',
    component: () => import('../views/SponsorsView.vue'),
  },
  {
    path: '/sponsor-us',
    name: 'sponsor-us',
    component: () => import('../views/SponsorUsView.vue'),
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('../views/NotFoundView.vue'),
  },
]

const router = createRouter({ 
  history: createWebHistory(), 
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
})

export default router
