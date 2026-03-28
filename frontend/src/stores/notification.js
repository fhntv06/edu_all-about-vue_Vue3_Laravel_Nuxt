export default {
  state: () => ({
    items: [],
    nextId: 0
  }),
  getters: {
    successNotifications: (state) => state.items.filter(n => n.type === 'success'),
    errorNotifications: (state) => state.items.filter(n => n.type === 'error'),
    warningNotifications: (state) => state.items.filter(n => n.type === 'warning'),
    infoNotifications: (state) => state.items.filter(n => n.type === 'info'),
    count: (state) => state.items.length,
    hasNotifications: (state) => state.items.length > 0,
    lastNotification: (state) => state.items[state.items.length - 1]
  },
  mutations: {
    ADD_NOTIFICATION(notification) {
      this.items.push({
        id: this.nextId++,
        ...notification,
        createdAt: Date.now()
      })
    },
    REMOVE_NOTIFICATION(id) {
      const index = this.items.findIndex(n => n.id === id)
      if (index !== -1) {
        this.items.splice(index, 1)
      }
    },
    CLEAR_ALL() {
      this.items = []
    },
    REMOVE_BY_TYPE(type) {
      this.items = this.items.filter(n => n.type !== type)
    },
    REMOVE_OLDER_THAN(timestamp) {
      this.items = this.items.filter(n => n.createdAt > timestamp)
    },
  },
  actions: {
    show({ type = 'info', message, duration = 5000 }) {
      this.ADD_NOTIFICATION({ type, message, duration })

      if (duration > 0) {
        setTimeout(() => {
          this.REMOVE_NOTIFICATION(this.nextId - 1)
        }, duration)
      }
    },
    success(message, duration) {
      this.show({ type: 'success', message, duration })
    },
    error(message, duration) {
      this.show({ type: 'error', message, duration })
    },
    warning(message, duration) {
      this.show({ type: 'warning', message, duration })
    },
    info(message, duration) {
      this.show({ type: 'info', message, duration })
    },
    showMultiple(notifications) {
      notifications.forEach(n => this.show(n))
    },
    showApiError(error) {
      if (!error.response) {
        this.error('Сбой сети. Проверьте подключение к интернету')
        return
      }

      switch (error.response.status) {
        case 400:
          this.warning(error.response.data?.message || 'Проверьте правильность заполнения полей')
          break
        case 401:
          this.error('Необходима авторизация')
          break
        case 403:
          this.error('Доступ запрещен')
          break
        case 404:
          this.warning('Ресурс не найден')
          break
        case 422:
          const errors = error.response.data.errors
          if (errors) {
            Object.values(errors).forEach(err => {
              this.warning(err[0] || 'Ошибка валидации')
            })
          }
          break
        case 500:
          this.error('Внутренняя ошибка сервера')
          break
        default:
          this.error(error.response.data?.message || 'Произошла ошибка')
      }
    },
    showFormErrors(errors) {
      Object.values(errors).forEach(error => {
        if (Array.isArray(error)) {
          this.warning(error[0])
        } else {
          this.warning(error)
        }
      })
    }
  }
}
