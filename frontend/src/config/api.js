export default {
  protocol: import.meta.env.VITE_APP_API_PROTOCOL,
  host: import.meta.env.VITE_APP_API_HOST,
  port: import.meta.env.VITE_APP_API_PORT,
  baseURL: `${import.meta.env.VITE_APP_API_PROTOCOL}://${import.meta.env.VITE_APP_API_HOST}:${import.meta.env.VITE_APP_API_PORT}`,
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json',
  }
}
