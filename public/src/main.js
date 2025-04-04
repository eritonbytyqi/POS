import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/service-worker.js').then(registration => {
        registration.onupdatefound = () => {
          const installingWorker = registration.installing
          installingWorker?.addEventListener('statechange', () => {
            if (installingWorker.state === 'installed') {
              if (navigator.serviceWorker.controller) {
                if (confirm('Ka një version të ri. Dëshiron të rifreskosh?')) {
                  window.location.reload()
                }
              }
            }
          })
        }
      })
    })
  }
  