import { createStore } from 'vuex'

import authStore from './auth.js'

const store = createStore({
  modules: { authStore }
})

export default store
