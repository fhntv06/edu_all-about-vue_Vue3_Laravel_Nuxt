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
        <div class="rounded-md shadow-sm -space-y-px">
          <!-- Поле email/телефон -->
          <div>
            <label for="login" class="sr-only">Email или телефон</label>
            <input
              id="login"
              v-model="form.login"
              name="login"
              type="text"
              required
              class="relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-colors"
              placeholder="Email или телефон"
            >
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
              class="relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-colors"
              placeholder="Пароль"
            >
          </div>
        </div>

        <!-- Дополнительные опции -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input
              id="remember-me"
              v-model="form.rememberMe"
              name="remember-me"
              type="checkbox"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
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
        <div v-if="error" class="rounded-md bg-red-50 p-4">
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
              <div class="mt-2 text-sm text-red-700">
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

<script>
export default {
  name: 'LoginPage',
  data() {
    return {
      form: {
        login: '',
        password: '',
        rememberMe: false
      },
      isLoading: false,
      error: ''
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
    async handleLogin() {
      // Сброс ошибки
      this.error = ''

      // Валидация
      if (!this.form.login.trim() || !this.form.password) {
        this.error = 'Пожалуйста, заполните все поля'
        return
      }

      this.isLoading = true

      try {
        const response = await this.performLogin()

        // Сохраняем данные авторизации в store
        this.$store.dispatch('login', {
          user: response.user,
          token: response.token
        })

        // Сохраняем данные пользователя в localStorage для инициализации
        localStorage.setItem('user-data', JSON.stringify(response.user))

        // Успешная авторизация
        this.$router.push('/dashboard')
      } catch (error) {
        this.error = error.message
      } finally {
        this.isLoading = false
      }
    },
    // Имитация запроса к API для авторизации
    performLogin() {
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          // Mock данные для авторизации
          const validCredentials = [
            { login: 'admin@example.com', password: 'password', user: { id: 1, name: 'Администратор', email: 'admin@example.com' } },
            { login: 'user@test.ru', password: 'password', user: { id: 2, name: 'Пользователь', email: 'user@test.ru' } },
            { login: '+79991234567', password: 'password', user: { id: 3, name: 'Телефонный пользователь', phone: '+79991234567' } }
          ]

          const credential = validCredentials.find(
            cred => cred.login === this.form.login && cred.password === this.form.password
          )

          if (credential) {
            resolve({
              user: credential.user,
              token: 'mock-jwt-token-' + Date.now()
            })
          } else {
            reject(new Error('Неверный email/телефон или пароль'))
          }
        }, 1500)
      })
    },
  }
}
</script>
