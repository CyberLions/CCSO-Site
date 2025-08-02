// src/main.js
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Vue3Autocounter from 'vue3-autocounter'
import App from './App.vue'
import router from './router'
import './assets/base.css'

const app = createApp(App)
app.use(createPinia())
app.use(router)
app.component('vue3-autocounter', Vue3Autocounter)
app.mount('#app')
