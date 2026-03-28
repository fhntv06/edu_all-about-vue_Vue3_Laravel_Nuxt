import { createStore } from 'vuex'

import authStore from './auth'
import notificationStore from './notification'

const store = createStore({
  modules: { authStore, notificationStore },
})

export default store
