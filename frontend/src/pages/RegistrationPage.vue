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
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
            Имя *
          </label>
          <input
            id="name"
            v-model="form.name"
            name="name"
            type="text"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="Введите ваше имя"
            :class="{ 'border-red-300': validation.name.valid === false }"
          >
          <p v-if="validation.name.valid === false" class="mt-1 text-sm text-red-600">
            {{ validation.name.message }}
          </p>
        </div>

        <!-- Логин -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
            Логин *
          </label>
          <input
            id="username"
            v-model="form.username"
            name="username"
            type="text"
            class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
            placeholder="Придумайте логин"
            :class="{ 'border-red-300': validation.username.valid === false }"
          >
          <p v-if="validation.username.valid === false" class="mt-1 text-sm text-red-600">
            {{ validation.username.message }}
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
            :class="{ 'border-red-300': validation.email.valid === false }"
          >
          <p v-if="validation.email.valid === false" class="mt-1 text-sm text-red-600">
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
            placeholder="+7 (999) 999-99-99"
            :class="{ 'border-red-300': validation.phone.valid === false }"
          >
          <p v-if="validation.phone.valid === false" class="mt-1 text-sm text-red-600">
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
            :class="{ 'border-red-300': validation.password.valid === false }"
          >
          <p v-if="validation.password.valid === false" class="mt-1 text-sm text-red-600">
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
            :class="{ 'border-red-300': validation.confirmPassword.valid === false }"
          >
          <p v-if="validation.confirmPassword.valid === false" class="mt-1 text-sm text-red-600">
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
              :class="{ 'border-red-300': validation.privacyAccepted.valid === false }"
            >
          </div>
          <div class="ml-3 text-sm">
            <label for="privacy" class="font-medium text-gray-700">
              Я соглашаюсь с
              <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors">правилами обработки персональных данных</a>
              *
            </label>
            <p v-if="validation.privacyAccepted.valid === false" class="mt-1 text-red-600">
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
                Регистрация успешна!
              </h3>
              <div class="mt-2 text-sm text-green-700">
                <p>Аккаунт успешно создан. Вы будете перенаправлены в панель управления.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Сообщения об ошибках -->
        <div v-if="error && !isSuccess" class="rounded-md bg-red-50 p-4">
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
              <div class="mt-2 text-sm text-red-700">
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

<script>
export default {
  name: 'RegistrationPage',
  data() {
    return {
      form: {
        name: '',
        username: '',
        email: '',
        phone: '',
        password: '',
        confirmPassword: '',
        privacyAccepted: false
      },
      isLoading: false,
      isSuccess: false,
      error: '',
      validation: {
        name: {valid: true, message: ''},
        username: {valid: true, message: ''},
        email: {valid: true, message: ''},
        phone: {valid: true, message: ''},
        password: {valid: true, message: ''},
        confirmPassword: {valid: true, message: ''},
        privacyAccepted: {valid: true, message: ''}
      }
    }
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters.isAuthenticated
    }
  },
  mounted() {
    // Если пользователь уже авторизован, перенаправляем на главную
    if (this.isAuthenticated) {
      this.$router.push('/dashboard')
    }
  },
  methods: {
    validateName() {
      const value = this.form.name.trim()

      if (!value) {
        this.validation.name = {valid: false, message: 'Имя обязательно для заполнения'}
        return false
      }

      if (value.length <= 3) {
        this.validation.name = {valid: false, message: 'Имя должно содержать более 3-х символов'}
        return false
      }

      this.validation.name = {valid: true, message: ''}
      return true
    },

    validateUsername() {
      const value = this.form.username.trim()

      if (!value) {
        this.validation.username = {valid: false, message: 'Логин обязателен для заполнения'}
        return false
      }
      if (value.length <= 3) {
        this.validation.username = {valid: false, message: 'Логин должно содержать более 3-х символов'}
        return false
      }

      const usernameRegex = /^[a-zA-Z0-9_]+$/
      if (!usernameRegex.test(value)) {
        this.validation.username = {
          valid: false,
          message: 'Логин может содержать только буквы, цифры и нижнее подчеркивание'
        }
        return false
      }

      this.validation.username = {valid: true, message: ''}
      return true
    },

    validateEmail() {
      const value = this.form.email.trim()

      if (!value) {
        this.validation.email = {valid: false, message: 'Email обязателен для заполнения'}
        return false
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(value)) {
        this.validation.email = {valid: false, message: 'Введите корректный email'}
        return false
      }

      this.validation.email = {valid: true, message: ''}
      return true
    },

    validatePhone() {
      const value = this.form.phone.trim()

      if (value) {
        const phoneRegex = /^\+?[78][-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$/
        if (!phoneRegex.test(value)) {
          this.validation.phone = {valid: false, message: 'Введите корректный номер телефона'}
          return false
        }
      }

      this.validation.phone = {valid: true, message: ''}
      return true
    },

    validatePassword() {
      const value = this.form.password

      if (!value) {
        this.validation.password = {valid: false, message: 'Пароль обязателен для заполнения'}
        return false
      }

      if (value.length < 6) {
        this.validation.password = {
          valid: false,
          message: 'Пароль должен содержать минимум 6 символов'
        }
        return false
      }

      this.validation.password = {valid: true, message: ''}
      return true
    },

    validateConfirmPassword() {
      const value = this.form.confirmPassword

      if (!value) {
        this.validation.confirmPassword = {
          valid: false,
          message: 'Подтверждение пароля обязательно'
        }
        return false
      }

      if (value !== this.form.password) {
        this.validation.confirmPassword = {valid: false, message: 'Пароли не совпадают'}
        return false
      }

      this.validation.confirmPassword = {valid: true, message: ''}
      return true
    },

    validatePrivacy() {
      if (!this.form.privacyAccepted) {
        this.validation.privacyAccepted = {
          valid: false,
          message: 'Необходимо согласие на обработку данных'
        }
        return false
      }

      this.validation.privacyAccepted = {valid: true, message: ''}
      return true
    },

    async handleRegistration() {
      this.error = ''
      this.isSuccess = false

      const isNameValid = this.validateName()
      const isUsernameValid = this.validateUsername()
      const isEmailValid = this.validateEmail()
      const isPhoneValid = this.validatePhone()
      const isPasswordValid = this.validatePassword()
      const isConfirmPasswordValid = this.validateConfirmPassword()
      const isPrivacyValid = this.validatePrivacy()

      if (!isNameValid || !isUsernameValid || !isEmailValid || !isPhoneValid ||
        !isPasswordValid || !isConfirmPasswordValid || !isPrivacyValid) {
        return
      }

      this.isLoading = true

      try {
        const response = await this.mockRegistration()

        // Автоматически логиним пользователя после регистрации
        this.$store.dispatch('login', {
          user: response.user,
          token: response.token
        })

        localStorage.setItem('user-data', JSON.stringify(response.user))

        this.isSuccess = true

        // Автоматический переход через 2 секунды
        setTimeout(() => {
          this.$router.push('/dashboard')
        }, 2000)
      } catch (error) {
        this.error = error.message
      } finally {
        this.isLoading = false
      }
    },
    mockRegistration() {
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          // Mock проверка существующих пользователей
          const existingUsers = ['admin', 'user123']
          const existingEmails = ['admin@example.com', 'user@test.ru']

          if (existingUsers.includes(this.form.username)) {
            reject(new Error('Пользователь с таким логином уже существует'))
          }
          if (existingEmails.includes(this.form.email)) {
            reject(new Error('Пользователь с таким email уже существует'))
          }

          resolve({
            user: {
              id: Date.now(),
              name: this.form.name,
              username: this.form.username,
              email: this.form.email,
              phone: this.form.phone
            },
            token: 'mock-jwt-token-' + Date.now()
          })
        }, 2000)
      })
    },
  }
}
</script>
