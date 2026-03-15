<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Заголовок -->
      <div class="text-center">
        <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
          </svg>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
          Регистрация
        </h2>
        <p class="mt-2 text-sm text-gray-600">
          Создайте новый аккаунт
        </p>
      </div>

      <!-- Форма -->
      <form class="mt-8 space-y-4" @submit.prevent="handleRegistration">
        <!-- Имя -->
        <div>
          <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">
            Имя *
          </label>
          <input
            id="firstname"
            v-model="form.firstname"
            name="firstname"
            type="text"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="Введите ваше имя"
            :class="{ 'border-red-300': !validation.firstname.valid }"
            @blur="validateField('firstname')"
          >
          <p v-if="!validation.firstname.valid" class="mt-1 text-sm text-red-600">
            {{ validation.firstname.message }}
          </p>
        </div>

        <!-- Логин -->
        <div>
          <label for="login" class="block text-sm font-medium text-gray-700 mb-1">
            Логин *
          </label>
          <input
            id="login"
            v-model="form.login"
            name="login"
            type="text"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="Придумайте логин"
            :class="{ 'border-red-300': !validation.login.valid }"
            @blur="validateField('login')"
          >
          <p v-if="!validation.login.valid" class="mt-1 text-sm text-red-600">
            {{ validation.login.message }}
          </p>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Email *
          </label>
          <input
            id="email"
            v-model="form.email"
            name="email"
            type="email"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="example@mail.com"
            :class="{ 'border-red-300': !validation.email.valid }"
            @blur="validateField('email')"
          >
          <p v-if="!validation.email.valid" class="mt-1 text-sm text-red-600">
            {{ validation.email.message }}
          </p>
        </div>

        <!-- Телефон -->
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
            Телефон
          </label>
          <input
            id="phone"
            v-model="form.phone"
            name="phone"
            type="tel"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="+79999999999"
            :class="{ 'border-red-300': !validation.phone.valid }"
            @blur="validateField('phone')"
          >
          <p v-if="!validation.phone.valid" class="mt-1 text-sm text-red-600">
            {{ validation.phone.message }}
          </p>
        </div>

        <!-- Пароль -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
            Пароль *
          </label>
          <input
            id="password"
            v-model="form.password"
            name="password"
            type="password"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="Минимум 6 символов"
            :class="{ 'border-red-300': !validation.password.valid }"
            @blur="validateField('password')"
          >
          <p v-if="!validation.password.valid" class="mt-1 text-sm text-red-600">
            {{ validation.password.message }}
          </p>
        </div>

        <!-- Подтверждение пароля -->
        <div>
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">
            Подтверждение пароля *
          </label>
          <input
            id="confirmPassword"
            v-model="form.confirmPassword"
            name="confirmPassword"
            type="password"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="Повторите пароль"
            :class="{ 'border-red-300': !validation.confirmPassword.valid }"
            @blur="validateField('confirmPassword')"
          >
          <p v-if="!validation.confirmPassword.valid" class="mt-1 text-sm text-red-600">
            {{ validation.confirmPassword.message }}
          </p>
        </div>

        <!-- Согласие на обработку данных -->
        <div class="flex items-start">
          <div class="flex items-center h-5">
            <input
              id="privacy"
              v-model="form.privacyAccepted"
              name="privacy"
              type="checkbox"
              class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded mt-1"
              :class="{ 'border-red-300': !validation.privacyAccepted.valid }"
              @blur="validateField('privacyAccepted')"
            >
          </div>
          <div class="ml-3 text-sm">
            <label for="privacy" class="font-medium text-gray-700">
              Я соглашаюсь с
              <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors">правилами обработки персональных данных</a>
              *
            </label>
            <p v-if="!validation.privacyAccepted.valid" class="mt-1 text-red-600">
              {{ validation.privacyAccepted.message }}
            </p>
          </div>
        </div>

        <!-- Кнопка регистрации -->
        <div class="pt-2">
          <button
            type="submit"
            :disabled="isLoading"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
              </svg>
            </span>
            <span v-if="!isLoading">Зарегистрироваться</span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Регистрация...
            </span>
          </button>
        </div>

        <!-- Сообщение об успехе -->
        <div v-if="isSuccess" class="rounded-md bg-green-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-green-800">
                Регистрация прошла успешно!
              </h3>
              <div class="mt-2 text-sm text-green-700">
                <p>Аккаунт успешно создан. Вы будете перенаправлены в панель управления.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Сообщения об ошибках -->
        <div v-if="errors.length && !isSuccess" class="rounded-md bg-red-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                Ошибка регистрации
              </h3>
              <div class="mt-2 text-sm text-red-700" v-for="error in errors">
                <p>{{ error }}</p>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- Дополнительные ссылки -->
      <div class="text-center">
        <p class="text-sm text-gray-600">
          Уже есть аккаунт?
          <router-link to="/login" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
            Войти в систему
          </router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onBeforeMount, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import { fetchRegister } from '@/api/index.js'
import { useFormValidation } from '@/composables'

const router = useRouter()
const store = useStore()

const isLoading = ref(false)
const isSuccess = ref(false)
const errors = ref([])

// Форма
const form = reactive({
  firstname: '',
  login: '',
  email: '',
  phone: '',
  password: '',
  confirmPassword: '',
  privacyAccepted: false
})

const confirmPasswordRule = (value, formData, fieldName = 'Подтверждение пароля') => {
  if (!value) {
    return { valid: false, message: `${fieldName} обязательно` }
  }
  if (value !== formData.password) {
    return { valid: false, message: 'Пароли не совпадают' }
  }
  return null
}

// Правила валидации
const validationRules = {
  firstname: ['required', 'name'],
  login: ['required', 'login'],
  email: ['required', 'email'],
  phone: ['phone'], // необязательное поле
  password: ['required', 'password'],
  confirmPassword: [confirmPasswordRule],
  privacyAccepted: ['required']
}

// Метки полей для сообщений об ошибках
const fieldLabels = {
  firstname: 'Имя',
  login: 'Логин',
  email: 'Email',
  phone: 'Телефон',
  password: 'Пароль',
  confirmPassword: 'Подтверждение пароля',
  privacyAccepted: 'Согласие на обработку данных'
}

// Используем хук валидации
const { validation, validateField, validateAll, resetValidation } = useFormValidation(form, validationRules, fieldLabels)

// Вычисляемое свойство для проверки авторизации
const isAuthenticated = computed(() => store.getters.isAuthenticated)

// Перенаправление, если пользователь уже авторизован
onBeforeMount(() => {
  if (isAuthenticated.value) {
    router.push('/dashboard')
  }
})

// Сохранение данных пользователя
const saveDataUser = ({ user, token }) => {
  if (!user) errors.value.push('Не получены данные пользователя!')
  if (!token) errors.value.push('Не получен токен авторизации!')

  isSuccess.value = !!(user && token)

  if (!isSuccess.value) return

  store.dispatch('login', { user, token })
  localStorage.setItem('user-data', JSON.stringify(user))

  setTimeout(() => router.push('/dashboard'), 2000)
}

// Обработка регистрации
const handleRegistration = async () => {
  errors.value = []

  // Валидация всех полей
  if (!validateAll()) {
    return
  }

  isLoading.value = true

  try {
    const { data } = await fetchRegister(form)
    saveDataUser(data)
  } catch (error) {
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
    } else {
      errors.value.push('Произошла ошибка при регистрации')
    }
  } finally {
    isLoading.value = false
  }
}
</script>
