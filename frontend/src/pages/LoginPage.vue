<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Заголовок -->
      <div class="text-center">
        <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
          Авторизация
        </h2>
        <p class="mt-2 text-sm text-gray-600">
          Введите свои данные для входа в систему
        </p>
      </div>

      <!-- Форма -->
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
          <!-- Поле email -->
          <div>
            <label for="login" class="sr-only">Email</label>
            <input
              id="login"
              v-model="form.email"
              name="email"
              type="text"
              required
              class="relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-colors"
              placeholder="Email"
              @blur="validateField('email')"
            >
            <p v-if="!validation.email.valid" class="mt-1 text-sm text-red-600">
              {{ validation.email.message }}
            </p>
          </div>

          <!-- Поле пароля -->
          <div>
            <label for="password" class="sr-only">Пароль</label>
            <input
              id="password"
              v-model="form.password"
              name="password"
              type="password"
              required
              class="relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-colors"
              placeholder="Пароль"
              @blur="validateField('password')"
            >
            <p v-if="!validation.password.valid" class="mt-1 text-sm text-red-600">
              {{ validation.password.message }}
            </p>
          </div>

        <!-- Дополнительные опции -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              v-model="form.remember_me"
              name="remember-me"
              type="checkbox"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              @change="validateField('remember_me')"
            >
            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
              Запомнить меня
            </label>
          </div>

          <div class="text-sm">
            <router-link to="/forgot-password" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
              Забыли пароль?
            </router-link>
          </div>
        </div>

        <!-- Кнопка входа -->
        <div>
          <button
            type="submit"
            :disabled="isLoading"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
              </svg>
            </span>
            <span v-if="!isLoading">Войти</span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Вход...
            </span>
          </button>
        </div>

        <!-- Сообщения об ошибках -->
        <div v-if="errors.length" class="rounded-md bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                Ошибка авторизации
              </h3>
              <div class="mt-2 text-sm text-red-700" v-for="error in errors">
                <p>{{ error }}</p>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- Дополнительная информация -->
      <div class="text-center">
        <p class="text-sm text-gray-600">
          Нет аккаунта?
          <router-link to="/registration" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
            Зарегистрироваться
          </router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, computed, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { fetchLogin } from '@/api'
import { useFormValidation } from '@/composables'
import {fetchAuthSanctum} from "@/api/auth.js";

const router = useRouter()
const store = useStore()

const isLoading = ref(false)
const errors = ref([])

const form = reactive({
  email: '',
  password: '',
  remember_me: false
})

// Правила валидации
const validationRules = {
  email: ['required', 'email'],
  password: ['required', 'password'],
  remember_me: ['bool']
}

// Метки полей для сообщений об ошибках
const fieldLabels = {
  email: 'Email',
  password: 'Пароль'
  // remember_me не нуждается в метке, так как не валидируется
}

// Используем хук валидации
const { validation, validateField, validateAll } = useFormValidation( form, validationRules, fieldLabels)

// Вычисляемое свойство для проверки авторизации
const isAuthenticated = computed(() => store.getters.isAuthenticated)

// Перенаправление, если пользователь уже авторизован
onBeforeMount(() => {
  if (isAuthenticated.value) {
    router.push('/dashboard')
  }
})

// Сохранение данных пользователя
const saveDataUser = (response) => {
  // Сохраняем данные авторизации в store
  store.dispatch('login', {
    user: response.user,
    token: response.token
  })

  // Сохраняем данные пользователя в localStorage для инициализации
  localStorage.setItem('user-data', JSON.stringify(response.user))

  // Успешная авторизация
  router.push('/dashboard')
}

// Выполнение запроса на авторизацию
const performLogin = async () => {
  try {
    await fetchAuthSanctum()
    const response = await fetchLogin(form)

    // Проверяем структуру ответа и вызываем saveDataUser
    // В зависимости от структуры ответа может быть response.data или просто response
    const data = response.data || response
    saveDataUser(data)
  } catch (error) {
    console.error('Login error:', error)
    const responseData = error?.response?.data

    if (responseData?.errors) {
      Object.entries(responseData.errors).forEach(([nameField, errorMessages]) => {
        // Обновляем состояние валидации для поля с ошибкой
        if (validation[nameField]) {
          validation[nameField].valid = false
          validation[nameField].message = errorMessages[0]
        }

        errors.value.push(errorMessages[0])
      })
    } else if (responseData?.message) {
      errors.value.push(responseData.message)
    } else if (error?.message) {
      errors.value.push(error.message)
    } else {
      errors.value.push('Ошибка при входе в систему')
    }
  } finally {
    isLoading.value = false
  }
}

// Обработка входа
const handleLogin = () => {
  errors.value = []

  // Валидация всех полей
  if (!validateAll()) {
    errors.value.push('Пожалуйста, исправьте ошибки в форме')
    return
  }

  isLoading.value = true
  performLogin()
}
</script>
