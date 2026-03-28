import { http, config } from './config'

const fetchBroadcastingAuth = (data) => http.post('/broadcasting/auth', data, { baseURL: config.appUrl })

export { fetchBroadcastingAuth }
