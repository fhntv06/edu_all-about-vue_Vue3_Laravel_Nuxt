import { ref, watch } from 'vue'
import {CITIES, getCityByCoordinates, getCityByTimezone} from '@/config/constants.js'

export const useGeolocation = () => {
  const userCity = ref(null)
  const isLoading = ref(true)
  const error = ref(null)

  const detectUserLocation = () => {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const { latitude, longitude } = position.coords
        userCity.value = getCityByCoordinates(latitude, longitude)
        isLoading.value = false
      },
      (err) => {
        console.warn('Geolocation error:', err)

        // Пробуем определить по часовому поясу
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone
        const cityByTimezone = getCityByTimezone(timezone)

        if (cityByTimezone) {
          userCity.value = cityByTimezone
        } else {
          // Если по часовому поясу не нашли, пробуем геолокацию
          userCity.value = CITIES[0] // Москва по умолчанию
        }

        isLoading.value = false
      },
      {
        maximumAge: 300000 // 5 минут кэш
      }
    )
  }

  detectUserLocation()

  return {
    userCity,
    isLoading,
    error,
    detectUserLocation
  }
}
