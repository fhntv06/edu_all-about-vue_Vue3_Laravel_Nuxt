const authStore = {
  state: {
    user: null,
    token: localStorage.getItem('auth-token') || null,
    isAuthenticated: !!localStorage.getItem('auth-token')
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user
    },
    SET_TOKEN(state, token) {
      state.token = token
      state.isAuthenticated = !!token
      if (token) {
        localStorage.setItem('auth-token', token)
      } else {
        localStorage.removeItem('auth-token')
      }
    },
    LOGOUT(state) {
      state.user = null
      state.token = null
      state.isAuthenticated = false
      localStorage.removeItem('auth-token')
      localStorage.removeItem('user-data')
    }
  },
  actions: {
    login({ commit }, { user, token }) {
      commit('SET_USER', user)
      commit('SET_TOKEN', token)
    },
    logout({ commit }) {
      commit('LOGOUT')
    },
    initializeAuth(context) {
      const token = localStorage.getItem('auth-token')
      if (token) {
        // Здесь можно добавить проверку токена через API
        context.commit('SET_TOKEN', token)
        // Загружаем данные пользователя
        const userData = localStorage.getItem('user-data')
        if (userData) {
          context.commit('SET_USER', JSON.parse(userData))
        }
      }
    }
  },
  getters: {
    isAuthenticated: state => state.isAuthenticated,
    currentUser: state => state.user,
    authToken: state => state.token
  }
}

export default authStore
