const apiConfig = {
  baseURL: import.meta.env.VITE_APP_URL_API,
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json',
  }
}

export default apiConfig
