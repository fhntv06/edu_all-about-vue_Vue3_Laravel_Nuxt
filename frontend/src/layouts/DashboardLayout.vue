<!-- layouts/DashboardLayout.vue -->
<template>
  <div class="min-h-screen bg-gray-50 flex gap-x-10">
    <div
      class="hidden lg:flex lg:flex-shrink-0 transition-all duration-300 ease-in-out"
      :class="sidebarWidth"
    >
      <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
        <!-- Лого и заголовок -->
        <div class="flex items-center justify-between h-16 flex-shrink-0 px-4 border-b border-gray-200">
          <div class="flex items-center min-w-0">
            <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
              <span class="text-white font-bold text-sm">D</span>
            </div>
            <span
              class="ml-3 text-lg font-semibold text-gray-900 truncate transition-opacity duration-200"
              :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100'"
            >
              Dashboard
            </span>
          </div>
          <button
            @click="toggleSidebar"
            class="p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-colors flex-shrink-0"
            :class="sidebarCollapsed ? 'rotate-z-180' : 'rotate-z-0'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
          </button>
        </div>

        <!-- Навигация -->
        <nav class="flex-1 px-4 py-4 space-y-2">
          <router-link
            v-for="item in navigation"
            :key="item.name"
            :to="item.to"
            class="group flex gap-x-5 items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 "
            :class="[
              isActiveLink(item)
                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
            ]"
          >
            <div
              class="h-5 w-5 flex-shrink-0 transition-transform duration-200"
              :class="[
                isActiveLink(item)
                  ? 'text-blue-700'
                  : 'text-gray-400 group-hover:text-gray-500',
              ]"
              v-html="item.icon"
            >
            </div>
            <span class="transition-all duration-200 overflow-hidden" :class="sidebarCollapsed ? 'hidden' : 'opacity-100 w-auto'">
              {{ item.name }}
            </span>
          </router-link>
        </nav>

        <!-- User info -->
        <div
          class="flex-shrink-0 border-t border-gray-200 p-4 transition-all duration-200"
          :class="sidebarCollapsed ? 'opacity-0 h-0 py-0' : 'opacity-100 h-auto py-4'"
        >
          <div class="flex items-center">
            <div class="h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
              <span class="text-white font-semibold text-sm">
                {{ userInitials }}
              </span>
            </div>
            <div
              class="ml-3 transition-all duration-200 overflow-hidden"
              :class="sidebarCollapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'"
            >
              <p class="text-sm font-medium text-gray-700 truncate">{{ currentUser?.name }}</p>
              <button
                @click="handleLogout"
                class="text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors"
              >
                Выйти
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Мобильное меню (overlay) -->
    <transition
      enter-active-class="transition-opacity ease-linear duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity ease-linear duration-300"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="mobileMenuOpen"
        class="lg:hidden fixed inset-0 z-40"
      >
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="mobileMenuOpen = false"></div>
        <transition
          enter-active-class="transition-transform ease-in-out duration-300"
          enter-from-class="-translate-x-full"
          enter-to-class="translate-x-0"
          leave-active-class="transition-transform ease-in-out duration-300"
          leave-from-class="translate-x-0"
          leave-to-class="-translate-x-full"
        >
          <div v-if="mobileMenuOpen" class="fixed inset-y-0 left-0 flex flex-col w-64 bg-white transform">
            <div class="flex items-center justify-between h-16 flex-shrink-0 px-4 border-b border-gray-200">
              <div class="flex items-center">
                <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                  <span class="text-white font-bold text-sm">D</span>
                </div>
                <span class="ml-3 text-lg font-semibold text-gray-900">Dashboard</span>
              </div>
              <button
                @click="mobileMenuOpen = false"
                class="p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-colors"
              >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1">
              <router-link
                v-for="item in navigation"
                :key="item.name"
                :to="item.to"
                @click="mobileMenuOpen = false"
                class="group flex gap-x-5 items-center px-3 py-2 text-sm font-medium rounded-md transition-colors bg-blue-50 text-blue-700 border-r-2 border-blue-70"
                :class="[
                  isActiveLink(item)
                    ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                ]"
              >
                <div
                  class="h-5 w-5 flex-shrink-0 transition-transform duration-200"
                  :class="[
                isActiveLink(item)
                  ? 'text-blue-700'
                  : 'text-gray-400 group-hover:text-gray-500',
              ]"
                  v-html="item.icon"
                >
                </div>
                <span :class="sidebarCollapsed ? 'hidden' : 'opacity-100 w-auto'">
                  {{ item.name }}
                </span>
              </router-link>
            </nav>

            <div class="flex-shrink-0 border-t border-gray-200 p-4">
              <div class="flex items-center">
                <div class="h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center">
                  <span class="text-white font-semibold text-sm">
                    {{ userInitials }}
                  </span>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-700">{{ currentUser?.name }}</p>
                  <button
                    @click="handleLogout"
                    class="text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors"
                  >
                    Выйти
                  </button>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </transition>

    <!-- Основной контент -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Хедер -->
      <div class="lg:hidden flex items-center justify-between h-16 bg-white border-b border-gray-200 px-4">
        <button
          @click="mobileMenuOpen = true"
          class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-colors"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div class="text-lg font-semibold text-gray-900">Dashboard</div>
        <div class="w-10"></div> <!-- Для выравнивания -->
      </div>

      <!-- Контент -->
      <main class="flex-1 p-6 transition-all duration-300 ease-in-out">
        <!-- Breadcrumbs -->
        <div class="mb-6">
          <Breadcrumbs />
        </div>

        <router-view />
      </main>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import { FallbackIcon } from '@/components/UI/icons.js'

export default {
  name: 'Dashboard',
  setup() {
    const store = useStore()
    const router = useRouter()
    const route = useRoute() // Добавляем useRoute
    const mobileMenuOpen = ref(false)
    const sidebarCollapsed = ref(false)

    const navigation = computed(() => {
      const routes = router.options.routes
      const dashboardRoute = routes.find(route => route.path === '/dashboard')

      if (!dashboardRoute || !dashboardRoute.children) {
        return []
      }

      const navItems = []

      const processRoute = (child, basePath = '/dashboard') => {
        const fullPath = basePath + (child.path ? `/${child.path}` : '')

        // Если это layout с детьми, берем первого ребенка для навигации
        if (child.children && child.children.length > 0) {
          const firstChildWithBreadcrumb = child.children.find(
            subChild => subChild.meta?.breadcrumb && subChild.name
          )
          if (firstChildWithBreadcrumb) {
            const childFullPath = fullPath + (firstChildWithBreadcrumb.path ? `/${firstChildWithBreadcrumb.path}` : '')

            navItems.push({
              name: firstChildWithBreadcrumb.meta.breadcrumb,
              to: childFullPath,
              icon: child.meta?.icon,
              routeName: firstChildWithBreadcrumb.name,
              basePath: fullPath // Сохраняем базовый путь для проверки активности
            })
          }
        }
        // Если это конечная страница с breadcrumb
        else if (child.meta?.breadcrumb && child.name) {
          navItems.push({
            name: child.meta.breadcrumb,
            to: fullPath,
            icon: child.meta?.icon,
            routeName: child.name,
            basePath: fullPath
          })
        }
      }

      dashboardRoute.children.forEach(child => processRoute(child))

      return navItems
    })

    // Функция для проверки активного пункта меню
    const isActiveLink = (item) => (route.path === item.basePath)

    const currentUser = computed(() => store.getters.currentUser)

    const userInitials = computed(() => {
      if (!currentUser.value?.name) return 'U'
      return currentUser.value.name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2)
    })

    const sidebarWidth = computed(() => {
      return sidebarCollapsed.value ? 'w-20' : 'w-64'
    })

    const toggleSidebar = () => {
      sidebarCollapsed.value = !sidebarCollapsed.value
    }

    const handleLogout = () => {
      store.dispatch('logout')
      router.push('/login')
    }

    return {
      mobileMenuOpen,
      sidebarCollapsed,
      navigation,
      currentUser,
      userInitials,
      sidebarWidth,
      toggleSidebar,
      handleLogout,
      isActiveLink,
    }
  }
}
</script>
