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
          Восстановление пароля
        </h2>
        <p class="mt-2 text-sm text-gray-600">
          Введите ваш email, и мы вышлем инструкции для восстановления пароля
        </p>
      </div>

      <!-- Форма -->
      <form class="mt-8 space-y-6" @submit.prevent="handleResetPassword">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Email
          </label>
          <input
            id="email"
            v-model="form.email"
            name="email"
            type="text"
            required
            class="relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-colors"
            placeholder="Введите ваш email"
            :class="{ 'border-red-300': validation.email.valid === false }"
          >
          <p v-if="validation.email.valid === false" class="mt-1 text-sm text-red-600">
            {{ validation.email.message }}
          </p>
        </div>

        <!-- Кнопка отправки -->
        <div>
          <button
            type="submit"
            :disabled="isLoading"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </span>
            <span v-if="!isLoading">Отправить инструкции</span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Отправка...
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
                Инструкции отправлены!
              </h3>
              <div class="mt-2 text-sm text-green-700">
                <p>Мы отправили инструкции по восстановлению пароля на указанный email/телефон. Пожалуйста, проверьте вашу почту или сообщения.</p>
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
                Ошибка отправки
              </h3>
              <div class="mt-2 text-sm text-red-700">
                <p>{{ error }}</p>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- Дополнительные ссылки -->
      <div class="text-center space-y-2">
        <p class="text-sm text-gray-600">
          Вспомнили пароль?
          <router-link to="/login" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
            Войти
          </router-link>
        </p>
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

<script>
export default {
  name: 'ForgotPasswordPage',
  data() {
    return {
      form: {
        email: ''
      },
      isLoading: false,
      isSuccess: false,
      error: '',
      validation: {
        email: { valid: true, message: '' }
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
    validateEmail() {
      const value = this.form.email.trim()

      if (!value) {
        this.validation.email = { valid: false, message: 'Поле обязательно для заполнения' }
        return false
      }

      // Проверка на email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

      if (!emailRegex.test(value)) {
        this.validation.email = { valid: false, message: 'Введите корректный email' }
        return false
      }

      this.validation.email = { valid: true, message: '' }
      return true
    },

    async handleResetPassword() {
      this.error = ''
      this.isSuccess = false

      const isValid = this.validateEmail()

      if (!isValid) {
        return
      }

      this.isLoading = true

      try {
        // Имитация запроса к API
        await this.mockResetPassword()
        this.isSuccess = true
      } catch (error) {
        this.error = error.message
      } finally {
        this.isLoading = false
      }
    },

    mockResetPassword() {
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          // Mock логика проверки существования пользователя
          const existingUsers = ['admin@example.com', 'user@test.ru']

          if (existingUsers.includes(this.form.email)) {
            resolve({ success: true, message: 'Инструкции отправлены' })
          } else {
            reject(new Error('Пользователь с таким email/телефоном не найден'))
          }
        }, 2000)
      })
    },
  }
}
</script>
