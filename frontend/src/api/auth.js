import { http, config } from './config'

const fetchLogin = (data) => http.post('/auth/login', data)
const fetchRegister = (data) => http.post('/auth/register', data)
const fetchMe = (data) => http.get('/auth/me', data)
const fetchLogout = (data) => http.post('/auth/logout', data)
const fetchAuthSanctum = () => http.get('/sanctum/csrf-cookie', { baseURL: config.appUrl })

export { fetchLogin, fetchRegister, fetchMe, fetchLogout, fetchAuthSanctum }
