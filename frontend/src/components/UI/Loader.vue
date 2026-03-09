<script>
export default {
  name: "Loader",
  props: {
    isLoading: {
      type: Boolean,
      default: true
    }
  },
}
</script>

<template>
  <div v-if="isLoading" class="fixed inset-0 bg-blue-200/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 flex flex-col items-center">
      <div class="loader">
        <svg class="loader-circular" viewBox="0 0 50 50">
          <circle class="loader-path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
        </svg>
      </div>
      <p class="mt-4 text-gray-600 font-medium">Загрузка...</p>
    </div>
  </div>
</template>

<style scoped>
.loader {
  width: 60px;
  height: 60px;
  position: relative;
}

.loader-circular {
  width: 100%;
  height: 100%;
  transform: rotate(-90deg);
}

.loader-path {
  stroke: #3b82f6; /* blue-500 */
  stroke-dasharray: 125.6; /* 2 * π * 20 */
  stroke-dashoffset: 125.6;
  animation: loader-dash 1.5s ease-in-out infinite, loader-colors 3s ease-in-out infinite;
}

@keyframes loader-dash {
  0% {
    stroke-dashoffset: 125.6;
  }
  50% {
    stroke-dashoffset: 0;
  }
  100% {
    stroke-dashoffset: -125.6;
  }
}

@keyframes loader-colors {
  0%, 100% {
    stroke: #3b82f6; /* blue-500 */
  }
  25% {
    stroke: #ef4444; /* red-500 */
  }
  50% {
    stroke: #10b981; /* green-500 */
  }
  75% {
    stroke: #f59e0b; /* amber-500 */
  }
}
</style>
