<!-- views/DashboardPage.vue -->
<template>
  <div class="space-y-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Главный экран</h1>
      <p class="mt-1 text-sm text-gray-600">
        Ознакомьтесь с основной информацией о приложении
      </p>
    </div>

    <!-- Виджеты в сетке -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <div class="grid col-span-full lg:col-span-2 xl:col-span-1">
        <UserTimeWidget />
      </div>
      <div class="grid col-span-full lg:col-span-2 xl:col-span-1">
        <WorldTimeWidget />
      </div>
      <div class="grid col-span-full lg:col-span-2 xl:col-span-1">
        <WeatherWidget />
      </div>
    </div>

    <!-- Дополнительная информация -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Статистика приложения</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
          <div class="text-2xl font-bold text-blue-600">1,248</div>
          <div class="text-sm text-gray-600">Всего постов</div>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
          <div class="text-2xl font-bold text-green-600">5,342</div>
          <div class="text-sm text-gray-600">Пользователей</div>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
          <div class="text-2xl font-bold text-purple-600">24.8K</div>
          <div class="text-sm text-gray-600">Просмотров</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UserTimeWidget from '@/components/Widgets/UserTimeWidget.vue'
import WorldTimeWidget from '@/components/Widgets/WorldTimeWidget.vue'
import WeatherWidget from '@/components/Widgets/WeatherWidget.vue'

export default {
  name: 'DashboardPage',
  components: {
    UserTimeWidget,
    WorldTimeWidget,
    WeatherWidget
  }
}
</script>
