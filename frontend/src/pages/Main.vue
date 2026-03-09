<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg p-t-">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center py-4">
          <div class="text-center md:text-left mb-4 md:mb-0">
            <router-link to="/" class="hover:opacity-90 transition-opacity">
              <h1 class="text-4xl md:text-3xl font-bold">Vue3 + Laravel</h1>
              <p class="text-sm md:text-base opacity-90">Образовательный проект</p>
            </router-link>
          </div>

          <nav class="flex items-center space-x-4">
            <div v-if="isAuthenticated" class="flex items-center space-x-4">
              <router-link
                to="/dashboard"
                class="flex items-center space-x-2 px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors"
              >
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10"/>
                </svg>
                <span>Dashboard</span>
              </router-link>
              <button
                @click="handleLogout"
                class="px-4 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors"
              >
                Выйти
              </button>
            </div>
            <router-link v-else to="/login">
              <Button>
                Войти
              </Button>
            </router-link>
          </nav>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-8">
      <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 mb-12 text-center">
          <h2 class="text-5xl md:text-4xl font-bold text-gray-800 mb-4">
            Добро пожаловать в обучающий проект!
          </h2>
          <p class="text-lg md:text-2xl text-gray-600 max-w-3xl mx-auto mb-8">
            Это полноценное веб-приложение, демонстрирующее интеграцию
            <strong class="text-blue-600">Vue.js 3</strong> на фронтенде и <strong class="text-red-500">Laravel</strong> на бэкенде
          </p>

          <div class="flex flex-col sm:flex-row justify-center gap-4" v-if="!isAuthenticated">
            <router-link to="/registration">
              <Button type="primary" size="large" class="px-8 py-3">
                Начать работу
              </Button>
            </router-link>
            <router-link to="/login">
              <Button type="outline" size="large" class="px-8 py-3">
                Войти в систему
              </Button>
            </router-link>
          </div>
          <div class="flex flex-col sm:flex-row justify-center gap-4" v-else>
            <router-link to="/dashboard">
              <Button type="primary" size="large" class="px-8 py-3">
                Перейти в Dashboard
              </Button>
            </router-link>
            <router-link to="/dashboard/posts">
              <Button type="outline" size="large" class="px-8 py-3">
                Управление постами
              </Button>
            </router-link>
          </div>
        </section>

        <!-- Tech Stack Section -->
        <section class="mb-16">
          <h3 class="text-4xl md:text-3xl font-bold text-center text-gray-800 mb-12">
            Используемый стек технологий
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
              <div class="flex justify-between">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Vue.js 3</h3>
                <div class="bg-green-500 text-white p-2 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                  Vue
                </div>
              </div>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                  Composition API
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                  Vue Router
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                  Pinia/Vuex
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                  Reactive система
                </li>
              </ul>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
              <div class="flex justify-between">
                <h4 class="text-2xl font-semibold text-gray-800 mb-4">Laravel 12</h4>
                <div class="bg-red-500 text-white p-2 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                  Laravel
                </div>
              </div>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                  Eloquent ORM
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                  API ресурсы
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                  Миграции и сиды
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                  Аутентификация
                </li>
              </ul>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
              <div class="flex justify-between">
                <h4 class="text-2xl font-semibold text-gray-800 mb-4">Особенности</h4>
                <div class="bg-blue-500 text-white p-2 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                  🚀
                </div>
              </div>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                  SPA архитектура
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                  JWT аутентификация
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                  CRUD операции
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                  Виджеты реального времени
                </li>
              </ul>
            </div>
          </div>
        </section>

        <!-- Widgets Preview -->
        <section class="mb-16">
          <h3 class="text-4xl md:text-3xl font-bold text-center text-gray-800 mb-4">
            Реализованные виджеты
          </h3>
          <p class="text-gray-600 text-center mb-8">
            Демонстрация работы с внешними API и временными данными
          </p>
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <WeatherWidget />
            <UserTimeWidget />
            <WorldTimeWidget />
          </div>
        </section>

        <!-- Features Section -->
        <section class="mb-16">
          <h3 class="text-4xl md:text-3xl font-bold text-center text-gray-800 mb-12">
            Что реализовано в проекте
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
              <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <span class="mr-2">📊</span> Dashboard система
              </h4>
              <p class="text-gray-600">
                Полноценная панель управления с навигацией, аналитикой и управлением контентом
              </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
              <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <span class="mr-2">🔐</span> Аутентификация
              </h4>
              <p class="text-gray-600">
                Регистрация, вход, восстановление пароля с использованием JWT токенов
              </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
              <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <span class="mr-2">📝</span> CRUD постов
              </h4>
              <p class="text-gray-600">
                Создание, чтение, обновление и удаление постов с валидацией
              </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
              <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <span class="mr-2">🔄</span> API интеграция
              </h4>
              <p class="text-gray-600">
                RESTful API на Laravel с обработкой ошибок и пагинацией
              </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
              <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <span class="mr-2">🛡️</span> Навигационные guard'ы
              </h4>
              <p class="text-gray-600">
                Защита маршрутов на основе ролей и аутентификации
              </p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
              <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <span class="mr-2">🎯</span> Аналитика
              </h4>
              <p class="text-gray-600">
                Визуализация данных и статистики по активности пользователей
              </p>
            </div>
          </div>
        </section>

        <!-- API Information -->
        <section class="bg-gray-50 rounded-xl p-8 mb-16">
          <h3 class="text-4xl md:text-3xl font-bold text-center text-gray-800 mb-8">
            Laravel Backend API
          </h3>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg p-6">
              <h4 class="text-2xl font-semibold text-gray-800 mb-4">Основные эндпоинты:</h4>
              <ul class="space-y-3">
                <li class="flex items-start">
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">POST /api/register</code>
                  <span class="ml-3">- Регистрация пользователя</span>
                </li>
                <li class="flex items-start">
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">POST /api/login</code>
                  <span class="ml-3">- Аутентификация</span>
                </li>
                <li class="flex items-start">
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">GET /api/posts</code>
                  <span class="ml-3">- Получение списка постов</span>
                </li>
                <li class="flex items-start">
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">POST /api/posts</code>
                  <span class="ml-3">- Создание поста</span>
                </li>
                <li class="flex items-start">
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">PUT /api/posts/{id}</code>
                  <span class="ml-3">- Обновление поста</span>
                </li>
                <li class="flex items-start">
                  <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono">DELETE /api/posts/{id}</code>
                  <span class="ml-3">- Удаление поста</span>
                </li>
              </ul>
            </div>

            <div class="bg-white rounded-lg p-6">
              <h4 class="text-2xl font-semibold text-gray-800 mb-4">Особенности backend:</h4>
              <ul class="space-y-3">
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                  Миграции для users и posts
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                  Фабрики и сиды для тестовых данных
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                  Ресурсы API для форматирования ответов
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                  Middleware для CORS и аутентификации
                </li>
                <li class="flex items-center">
                  <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                  Валидация запросов
                </li>
              </ul>
            </div>
          </div>
        </section>

        <!-- Getting Started -->
        <section v-if="!isAuthenticated" class="mb-16">
          <h3 class="text-4xl md:text-3xl font-bold text-center text-gray-800 mb-12">
            Как начать?
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow">
              <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                1
              </div>
              <h4 class="text-lg font-semibold text-gray-800 mb-3">Зарегистрируйтесь</h4>
              <p class="text-gray-600">Создайте аккаунт для доступа ко всем функциям</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow">
              <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                2
              </div>
              <h4 class="text-lg font-semibold text-gray-800 mb-3">Изучите Dashboard</h4>
              <p class="text-gray-600">Перейдите в панель управления для работы с постами</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow">
              <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                3
              </div>
              <h4 class="text-lg font-semibold text-gray-800 mb-3">Создайте пост</h4>
              <p class="text-gray-600">Протестируйте CRUD операции с постами</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition-shadow">
              <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                4
              </div>
              <h4 class="text-lg font-semibold text-gray-800 mb-3">Изучите аналитику</h4>
              <p class="text-gray-600">Просмотрите статистику и виджеты</p>
            </div>
          </div>
        </section>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
      <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <h4 class="text-2xl font-bold mb-4">Vue3 + Laravel Образовательный проект</h4>
            <p class="text-gray-300 mb-2">
              Демонстрация интеграции современных веб-технологий
            </p>
            <p class="text-green-400 font-semibold">Версия 1.0.0</p>
          </div>

          <div>
            <h5 class="font-semibold mb-4">Быстрые ссылки</h5>
            <div class="flex flex-col space-y-2">
              <router-link to="/" class="text-gray-300 hover:text-white transition-colors">
                Главная
              </router-link>
              <router-link v-if="isAuthenticated" to="/dashboard" class="text-gray-300 hover:text-white transition-colors">
                Dashboard
              </router-link>
              <router-link v-else to="/login" class="text-gray-300 hover:text-white transition-colors">
                Войти
              </router-link>
              <a href="https://vuejs.org/" target="_blank" class="text-gray-300 hover:text-white transition-colors">
                Vue.js Docs
              </a>
              <a href="https://laravel.com/" target="_blank" class="text-gray-300 hover:text-white transition-colors">
                Laravel Docs
              </a>
            </div>
          </div>

          <div>
            <h5 class="font-semibold mb-4">Технологии</h5>
            <div class="flex flex-wrap gap-2">
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Vue 3</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Laravel</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Vue Router</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Vuex</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">REST API</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">JWT</span>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-700 pt-6 text-center">
          <p class="text-gray-400">
            © 2024 Образовательный проект. Для демонстрации возможностей Vue.js и Laravel
          </p>
        </div>
      </div>
    </footer>
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
  },
  methods: {
    async handleLogout() {
      this.$store.state.authStore.commit('LOGOUT')
      this.$router.push('/')
    }
  },
  computed: {
    isAuthenticated() {
      return this.$store.state.authStore.isAuthenticated
    }
  },
}
</script>
