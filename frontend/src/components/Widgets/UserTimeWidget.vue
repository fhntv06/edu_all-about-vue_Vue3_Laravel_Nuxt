<template>
  <div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5 flex flex-col h-full">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-medium text-gray-900">Ваше время</h3>
          <p class="text-sm text-gray-500">Текущее местное время</p>
        </div>
      </div>
      <div v-if="isLoading" class="relative h-full mt-4 flex justify-center items-center py-8">
        <div class="absolute top-[50%] left-[50%] translate-y-[-50%] translate-x-[-50%] animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
      </div>
      <div v-else class="mt-auto">
        <div class="text-2xl font-bold text-gray-900">{{ currentTime }}</div>
        <div class="text-lg text-gray-600 mt-1">{{ currentDate }}</div>
        <div class="text-sm text-gray-500 mt-2 flex items-center">
          <span class="w-3 h-3 bg-blue-400 rounded-full mr-2"></span>
          {{ userCity.label }}, {{ userCity.country }}
        </div>
        <div class="text-xs text-gray-400 mt-1">{{ this.userCity.timezone }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useGeolocation } from '@/composables'

export default {
  name: 'UserTimeWidget',
  data() {
    return {
      currentTime: '',
      currentDate: '',
    }
  },
  setup() {
    const { userCity, isLoading } = useGeolocation()

    return { userCity, isLoading }
  },
  watch: {
    isLoading(newIsLoading) {
      if (!newIsLoading && this.userCity) {
        this.updateTime()
        this.interval = setInterval(this.updateTime, 1000)
      }
    }
  },
  methods: {
    updateTime() {
      const now = new Date()

      this.currentTime = now.toLocaleTimeString('ru-RU', {
        timeZone: this.userCity.timezone,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      })

      this.currentDate = now.toLocaleDateString('ru-RU', {
        timeZone: this.userCity.timezone,
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }
  },
  unmounted() {
    if (this.interval) {
      clearInterval(this.interval)
    }
  }
}
</script>
