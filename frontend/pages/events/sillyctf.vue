<template>
  <div class="landing-page">
    <div class="container">
      <!-- Logo Section -->
      <div class="logo-container">
        <img 
          src="https://cms.psuccso.org/uploads/signal_2025_10_28_092351_002_79df896551.png" 
          alt="SillyCTF Logo" 
          class="logo"
        />
      </div>

      <!-- Countdown Timer Section -->
      <div class="timer-section">
        <div class="timer-grid">
          <div class="timer-unit">
            <div class="timer-value">{{ timeLeft.days }}</div>
            <div class="timer-label">Days</div>
          </div>
          <div class="timer-separator">:</div>
          <div class="timer-unit">
            <div class="timer-value">{{ timeLeft.hours }}</div>
            <div class="timer-label">Hours</div>
          </div>
          <div class="timer-separator">:</div>
          <div class="timer-unit">
            <div class="timer-value">{{ timeLeft.minutes }}</div>
            <div class="timer-label">Minutes</div>
          </div>
          <div class="timer-separator">:</div>
          <div class="timer-unit">
            <div class="timer-value">{{ timeLeft.seconds }}</div>
            <div class="timer-label">Seconds</div>
          </div>
        </div>
      </div>

      <!-- Event Date Caption -->
      <div class="event-date">
        {{ formattedEventDate }}
      </div>

      <!-- Message Section -->
      <div class="message-section">
        <p class="message">Check back for updates!</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// Fixed Eastern Time target: March 21, 2026 10:00 AM ET (EDT)
// Using explicit UTC offset for correctness across viewer locales
const eventDate = new Date('2026-03-21T10:00:00-04:00')

const timeLeft = ref({
  days: 0,
  hours: 0,
  minutes: 0,
  seconds: 0
})

let countdownInterval = null

const updateCountdown = () => {
  // Target: March 21, 10:00 AM (local time)
  const targetDate = eventDate
  const now = new Date()
  // Compute difference using epoch milliseconds to avoid timezone drift on client
  const difference = targetDate.getTime() - now.getTime()

  if (difference <= 0) {
    timeLeft.value = { days: 0, hours: 0, minutes: 0, seconds: 0 }
    return
  }

  timeLeft.value = {
    days: Math.floor(difference / (1000 * 60 * 60 * 24)),
    hours: Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
    minutes: Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60)),
    seconds: Math.floor((difference % (1000 * 60)) / 1000)
  }

  // Format to 2 digits with leading zero
  timeLeft.value.days = String(timeLeft.value.days).padStart(2, '0')
  timeLeft.value.hours = String(timeLeft.value.hours).padStart(2, '0')
  timeLeft.value.minutes = String(timeLeft.value.minutes).padStart(2, '0')
  timeLeft.value.seconds = String(timeLeft.value.seconds).padStart(2, '0')
}

onMounted(() => {
  updateCountdown()
  countdownInterval = setInterval(updateCountdown, 1000)
})

onUnmounted(() => {
  if (countdownInterval) {
    clearInterval(countdownInterval)
  }
})

// Set page metadata
useHead({
  title: 'SillyCTF - Coming Soon',
  meta: [
    { name: 'description', content: 'SillyCTF - The silliest CTF event. Check back for updates!' }
  ]
})

const formattedEventDate = new Intl.DateTimeFormat(undefined, {
  weekday: 'short',
  year: 'numeric',
  month: 'long',
  day: 'numeric',
  hour: 'numeric',
  minute: '2-digit',
  timeZone: 'America/New_York',
  timeZoneName: 'short'
}).format(eventDate)
</script>

<style scoped>
.landing-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
  padding: 2rem;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.container {
  max-width: 1000px;
  width: 100%;
  text-align: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 20px;
  padding: 2.5rem 2rem;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.logo-container {
  margin-bottom: 3rem;
  display: flex;
  justify-content: center;
}

.logo {
  max-width: 400px;
  width: 100%;
  height: auto;
  animation: fadeInDown 1s ease-out;
}

.timer-section {
  margin-bottom: 3rem;
}

.timer-grid {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.timer-unit {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  padding: 2rem 1.5rem;
  min-width: 120px;
  animation: fadeInUp 0.8s ease-out;
}

.timer-value {
  font-size: 3rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 0.5rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.timer-label {
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.9);
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: 500;
}

.timer-separator {
  font-size: 2.5rem;
  font-weight: 700;
  color: #ffffff;
  animation: pulse 1s ease-in-out infinite;
}

.message-section {
  animation: fadeIn 1.2s ease-out;
}

.event-date {
  margin-top: 1rem;
  margin-bottom: 2rem;
  color: rgba(255, 255, 255, 0.95);
  font-weight: 600;
  letter-spacing: 0.3px;
}

.message {
  font-size: 1.5rem;
  color: #ffffff;
  font-weight: 500;
  letter-spacing: 0.5px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .timer-unit {
    padding: 1.5rem 1rem;
    min-width: 100px;
  }

  .timer-value {
    font-size: 2rem;
  }

  .timer-label {
    font-size: 0.75rem;
  }

  .timer-separator {
    font-size: 1.5rem;
  }

  .message {
    font-size: 1.2rem;
  }

  .logo {
    max-width: 300px;
  }
}

@media (max-width: 480px) {
  .timer-unit {
    padding: 1rem 0.75rem;
    min-width: 70px;
  }

  .timer-value {
    font-size: 1.5rem;
  }

  .timer-label {
    font-size: 0.65rem;
  }

  .timer-separator {
    font-size: 1.2rem;
  }

  .logo {
    max-width: 250px;
  }
}
</style>

