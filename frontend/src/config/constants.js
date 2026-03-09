export const CITIES = [
  {
    value: 'moscow',
    label: 'Москва',
    timezone: 'Europe/Moscow',
    weatherName: 'Moscow',
    country: 'RU',
    coordinates: { lat: 55.7558, lon: 37.6173 }
  },
  {
    value: 'novosibirsk',
    label: 'Новосибирск',
    timezone: 'Asia/Novosibirsk',
    weatherName: 'Novosibirsk',
    country: 'RU',
    coordinates: { lat: 55.0084, lon: 82.9357 }
  },
  {
    value: 'vladivostok',
    label: 'Владивосток',
    timezone: 'Asia/Vladivostok',
    weatherName: 'Vladivostok',
    country: 'RU',
    coordinates: { lat: 43.1056, lon: 131.8735 }
  },
  {
    value: 'beijing',
    label: 'Пекин',
    timezone: 'Asia/Shanghai',
    weatherName: 'Beijing',
    country: 'CN',
    coordinates: { lat: 39.9042, lon: 116.4074 }
  },
  {
    value: 'tokyo',
    label: 'Токио',
    timezone: 'Asia/Tokyo',
    weatherName: 'Tokyo',
    country: 'JP',
    coordinates: { lat: 35.6762, lon: 139.6503 }
  },
  {
    value: 'las vegas',
    label: 'Лас-Вегас',
    timezone: 'America/Los_Angeles',
    weatherName: 'Las Vegas',
    country: 'US',
    coordinates: { lat: 36.1699, lon: -115.1398 }
  },
  {
    value: 'new york',
    label: 'Нью-Йорк',
    timezone: 'America/New_York',
    weatherName: 'New York',
    country: 'US',
    coordinates: { lat: 40.7128, lon: -74.0060 }
  },
  {
    value: 'washington',
    label: 'Вашингтон',
    timezone: 'America/New_York',
    weatherName: 'Washington',
    country: 'US',
    coordinates: { lat: 38.9072, lon: -77.0369 }
  },
  {
    value: 'london',
    label: 'Лондон',
    timezone: 'Europe/London',
    weatherName: 'London',
    country: 'GB',
    coordinates: { lat: 51.5074, lon: -0.1278 }
  }
]

// Функция для получения города по часовому поясу
export const getCityByTimezone = (timezone) => {
  return CITIES.find(city => city.timezone === timezone) // Москва по умолчанию
}

// Функция для получения города по геолокации
export const getCityByCoordinates = (lat, lon) => {
  // Находим ближайший город по координатам
  let closestCity = CITIES[0]
  let minDistance = Number.MAX_SAFE_INTEGER

  CITIES.forEach(city => {
    const distance = Math.sqrt(
      Math.pow(city.coordinates.lat - lat, 2) +
      Math.pow(city.coordinates.lon - lon, 2)
    )
    if (distance < minDistance) {
      minDistance = distance
      closestCity = city
    }
  })

  return closestCity
}
