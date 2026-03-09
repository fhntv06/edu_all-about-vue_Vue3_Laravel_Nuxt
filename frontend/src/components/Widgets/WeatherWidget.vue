<template>
  <div class="bg-white shadow rounded-lg">
    <div class="p-5 flex flex-col h-full">
      <div class="flex flex-col gap-y-3 justify-between mb-4">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
              </svg>
            </div>
          </div>
          <div class="ml-4">
            <h3 class="text-lg font-medium text-gray-900">Погода</h3>
            <p class="text-sm text-gray-500">Текущая погода в городах</p>
          </div>
        </div>
        <Select
          :label="'Выбор города'"
          :options="cities"
          @changeValue="fetchWeather"
        />
      </div>

      <div v-if="isLoading" class="mt-4 flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
      </div>

      <div v-else-if="weather" class="mt-4">
        <div class="flex items-center justify-between">
          <div class="text-3xl font-bold text-gray-900">
            {{ Math.round(weather.main.temp) }}°C
          </div>
          <div class="text-right">
            <div class="text-lg text-gray-600 capitalize">{{ weather.weather[0].description }}</div>
            <div class="text-sm text-gray-500">Ощущается как {{ Math.round(weather.main.feels_like) }}°C</div>
          </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
          <div class="flex items-center">
            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
            </svg>
            Влажность: {{ weather.main.humidity }}%
          </div>
          <div class="flex items-center">
            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            Давление: {{ weather.main.pressure }} hPa
          </div>
          <div class="flex items-center">
            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Ветер: {{ Math.round(weather.wind.speed * 3.6) }} км/ч
          </div>
          <div class="flex items-center">
            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Обновлено: {{ lastUpdated }}
          </div>
        </div>
      </div>

      <div v-else-if="error" class="mt-4 text-center py-4">
        <div class="text-red-500 text-sm">{{ error }}</div>
        <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors" @click="() => fetchWeather()">
          Попробовать снова
        </button>
      </div>
      <div v-else class="mmt-4 text-center py-4">
        <p class="text-red-500 text-sm">{{ error }}</p>
        <Button @click="() => fetchWeather()">
          Попробовать снова
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import { weatherConfig } from '@/config'
import { CITIES } from '@/config/constants.js'
import { useGeolocation } from '@/composables'

export default {
  name: 'WeatherWidget',
  data() {
    return {
      cities: CITIES,
      selectedCityId: null,
      weather: null,
      error: 'Нет данных о погоде',
      isLoading: true,
    }
  },
  setup() {
    const { userCity } = useGeolocation()

    return { userCity }
  },
  computed: {
    haveApiUrl() {
      return weatherConfig && weatherConfig.apiUrl && weatherConfig.apiUrl !== ''
    },
    haveApiKey() {
      return weatherConfig && weatherConfig.apiKey && weatherConfig.apiKey !== ''
    },
    lastUpdated() {
      if (!this.lastUpdateTime) return ''
      return this.lastUpdateTime.toLocaleTimeString('ru-RU', {
        hour: '2-digit',
        minute: '2-digit'
      })
    },
  },
  methods: {
    fetchWeather(value) {
      this.isLoading = true

      if (!value && !this.selectedCityId) {

        this.selectedCityId = this.userCity ? this.userCity.value : this.cities[0].value
      } else {
        this.selectedCityId = value
      }

      if (!this.haveApiKey) {
        this.error = 'API ключ не настроен'
        return
      }
      if (!this.haveApiUrl) {
        this.error = 'API url не задано'
        return
      }

      this.error = ''

      const url = `${weatherConfig.apiUrl}?q=${this.selectedCityId}&appid=${weatherConfig.apiKey}&units=metric&lang=ru`

      fetch(url)
        .then((response) => {
          if (!response.ok) {
            if (response.status === 401) {
              throw new Error('Неверный API ключ. Проверьте правильность ключа в config/weather.js')
            } else if (response.status === 404) {
              throw new Error(`Город "${this.selectedCity.name}" не найден`)
            } else {
              throw new Error(`Ошибка API: ${response.status}`)
            }
          }

          return response
        }).then(async (data) => {
          this.weather = await data.json()
          this.lastUpdateTime = new Date()
        })
        .catch((err) => {
          console.error('Error fetching weather:', err)
          this.error = 'Не удалось загрузить данные о погоде'
          this.weather = null
        })
        .finally(() => {
          this.isLoading = false
        })
    }
  },
  mounted() {
    this.fetchWeather()
  }
}
</script>
