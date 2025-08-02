<template>
  <div class="dropdown-menu-hamburger mb-12 cursor-pointer transition-all duration-300" :class="{ 'active': isActive }" @click="$emit('toggle')">
    <h3>{{ title }}</h3>
    <div class="menu-content" v-if="isActive">
      <p>{{ content }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DropdownCard',
  props: {
    title: {
      type: String,
      required: true
    },
    content: {
      type: String,
      required: true
    },
    isActive: {
      type: Boolean,
      default: false
    }
  },
  emits: ['toggle']
}
</script>

<style scoped>
.dropdown-menu-hamburger {
  background-color: #00053e;
  border-radius: 10px;
  margin-bottom: 3em;
  padding: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.dropdown-menu-hamburger h3 {
  color: #ffffff;
  margin: 0;
}

.dropdown-menu-hamburger .menu-content {
  display: none;
}

.dropdown-menu-hamburger.active h3 {
  color: white;
}

.dropdown-menu-hamburger.active .menu-content {
  display: block;
  margin: -10px;
  margin-top: 10px;
  padding: 10px;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  background-color: #00458d;
  color: white;
}

.dropdown-menu-hamburger.active {
  background-color: #00053e;
}

@media (max-width: 990px) {
  .dropdown-menu-hamburger {
    margin-bottom: 1.5em;
  }
}
</style>