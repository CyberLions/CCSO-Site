<template>
  <div id="app" class="min-h-screen relative">
    <!-- Animated Background -->
    <div class="fixed inset-0 animated-background z-0"></div>
    
    <!-- Header positioned outside overflow context -->
    <Header />
    
    <!-- Content -->
    <div class="relative z-10">
      <main>
        <transition 
          name="page" 
          mode="out-in"
        >
          <NuxtPage />
        </transition>
      </main>
      <Footer />
    </div>
  </div>
</template>

<script setup>
import Header from '@/components/layout/Header.vue'
import Footer from '@/components/layout/Footer.vue'
</script>

<style>
/* Page transition animations */
.page-enter-active,
.page-leave-active {
  transition: all 0.3s ease-in-out;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

/* CCSO WordPress Theme Background with Lava Lamp Effect */
.animated-background {
  background: #0e0e0e;
  /* Animated lava lamp gradient */
  background-image: 
    linear-gradient(45deg, #0e0e0e, #00053e, #00458d, #0e0e0e, #000000),
    radial-gradient(circle at 25% 25%, rgba(0, 69, 141, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 75% 75%, rgba(0, 5, 62, 0.1) 0%, transparent 50%);
  background-size: 400% 400%, 100% 100%, 100% 100%;
  animation: gradientShift 15s ease infinite;
}

@keyframes gradientShift {
  0% {
    background-position: 0% 50%, 0% 0%, 0% 0%;
  }
  50% {
    background-position: 100% 50%, 0% 0%, 0% 0%;
  }
  100% {
    background-position: 0% 50%, 0% 0%, 0% 0%;
  }
}

/* Additional floating orbs for enhanced lava lamp effect */
.animated-background::before,
.animated-background::after {
  content: '';
  position: absolute;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  filter: blur(60px);
  opacity: 0.3;
  animation: float 20s ease-in-out infinite;
}

.animated-background::before {
  background: radial-gradient(circle, #00458d, #00053e, transparent);
  top: 20%;
  left: 10%;
  animation-delay: 0s;
}

.animated-background::after {
  background: radial-gradient(circle, #00053e, #00458d, transparent);
  bottom: 20%;
  right: 10%;
  animation-delay: 10s;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px) translateX(0px) scale(1);
  }
  25% {
    transform: translateY(-50px) translateX(30px) scale(1.1);
  }
  50% {
    transform: translateY(-20px) translateX(-40px) scale(0.9);
  }
  75% {
    transform: translateY(30px) translateX(20px) scale(1.05);
  }
}

/* Global section title styling to match WordPress theme */
.section-title {
  color: #AEB6D5 !important;
  font-size: 3em !important;
  font-weight: 700 !important;
  word-spacing: 15px !important;
  letter-spacing: 3px !important;
  margin-bottom: 1em !important;
  text-align: center !important;
}

@media (max-width: 990px) {
  .section-title {
    font-size: 2em !important;
  }
}

/* Geometric featured section styling */
.featured-section {
  padding: 50px;
  clip-path: polygon(
    0% 0%, 0% 100%, 
    10% 100%, 10% 97%, 18% 98%, 18% 100%, 
    48% 100%, 48% 95%, 58% 96%, 58% 100%, 
    68% 100%, 68% 97%, 78% 98%, 78% 100%, 
    88% 100%, 88% 96%, 96% 97%, 96% 100%, 
    100% 100%, 100% 3%, 90% 4%, 90% 0%, 
    80% 0%, 80% 5%, 70% 4%, 70% 0%, 
    60% 0%, 60% 3%, 50% 4%, 50% 0%, 
    20% 0%, 20% 3%, 10% 4%, 10% 0%
  );
  max-width: 1600px;
  min-height: 400px;
  margin: 0 auto;
  overflow: hidden;
  margin-top: 2em;
  background-color: #00000087;
  position: relative;
}

.featured-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  clip-path: inherit;
  background: linear-gradient(to bottom, #00053e, #00458d);
  z-index: -2;
  box-shadow: 0 0 10px #00053e, 0 0 20px #00458d;
  animation: border-fade 2s infinite ease-in-out;
}

.featured-section::after {
  content: '';
  position: absolute;
  top: 4px;
  left: 4px;
  width: calc(100% - 8px);
  height: calc(100% - 8px);
  clip-path: inherit;
  background-color: #00000087;
  z-index: -1;
}

@keyframes border-fade {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.6;
  }
}

.featured-section p {
  color: #fff !important;
  font-size: 1.5em !important;
  line-height: 1.5em !important;
  margin-bottom: 1em !important;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
  .featured-section {
    padding: 30px 20px;
    margin: 1em 1rem;
    min-height: 300px;
  }
  
  .featured-section p {
    font-size: 1.2em !important;
    line-height: 1.4em !important;
  }
}

@media (max-width: 480px) {
  .featured-section {
    padding: 20px 15px;
    margin: 1em 0.5rem;
    min-height: 250px;
  }
  
  .featured-section p {
    font-size: 1.1em !important;
    line-height: 1.3em !important;
  }
}

/* Discord button styling to match original */
.discord-btn {
  display: inline-flex !important;
  align-items: center !important;
  padding: 10px 20px !important;
  background-color: #00458d !important;
  color: #ffffff !important;
  text-decoration: none !important;
  font-size: 20px !important;
  border-radius: 50px !important;
  font-weight: bold !important;
  transition: background-color 0.3s ease !important;
  border: none !important;
}

.discord-btn:hover {
  background-color: #00053e !important;
  color: #ffffff !important;
}

/* Officers section styling */
.officers-section {
  background-color: #00000087;
  border-radius: 5px;
  border: 2px solid #0761c2;
  padding: 2em;
  position: relative;
  margin-top: 2em;
}

/* Secondary titles (like officer names) */
.secondary-title {
  color: #8594C0 !important;
}

/* Content sections with proper spacing */
.content-section {
  margin-top: 5em;
}
</style>
