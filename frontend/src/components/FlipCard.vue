<template>
  <div
    class="flip-card group focus:outline-none"
    :tabindex="tabindex"
    role="button"
    aria-pressed="flipped"
    @click="toggleFlip"
    @keyup.enter.space="toggleFlip"
    @blur="flipped = false"
  >
    <div class="flip-card-inner" :class="{ 'flipped': flipped }">
      <div class="flip-card-front">
        <div class="icon">
          <slot name="icon" />
        </div>
        <div class="header">
          <slot name="header" />
        </div>
      </div>
      <div class="flip-card-back">
        <div class="message">
          <slot name="message" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
const flipped = ref(false)
const tabindex = 0 // always focusable for accessibility
function toggleFlip() {
  flipped.value = !flipped.value
}
</script>

<style scoped>
.flip-card {
  perspective: 1200px;
  cursor: pointer;
  outline: none;
  width: 100%;
  min-height: 150px;
  min-width: 0;
  display: flex;
  flex-direction: column;
  flex: 1 1 0%;
}
.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  transition: transform 0.5s cubic-bezier(.4,2,.6,1);
  transform-style: preserve-3d;
  flex: 1 1 0%;
}
.flip-card-inner.flipped {
  transform: rotateY(180deg);
}
.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.53);
  border: 2px solid #003566ff;
  border-radius: 1rem;
  box-shadow: 0 4px 12px rgba(0, 53, 102, 0.3);
  padding: 1.25rem;
  transition: all 0.3s ease;
}
.flip-card-front:hover {
  border-color: #ffc300ff;
  box-shadow: 0 6px 16px rgba(255, 195, 0, 0.2);
}
.flip-card-front {
  z-index: 2;
}
.flip-card-back {
  transform: rotateY(180deg);
  z-index: 1;
  background: rgba(0, 53, 102, 0.8);
  border-color: #ffc300ff;
}
.icon {
  margin-bottom: .75rem;
}
.icon :deep(svg) {
  color: #ffc300ff;
}
.header {
  font-size: 1.25rem;
  font-weight: 600;
  color: #8594C0;
  margin-bottom: 0;
  text-align: center;
}
.message {
  font-size: 1rem;
  color: #9AA5CB;
  text-align: center;
  line-height: 1.5;
}
</style> 