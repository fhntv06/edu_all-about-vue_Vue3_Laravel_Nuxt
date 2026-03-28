import axios from "axios";

const axiosConfig = {
  protocol: import.meta.env.VITE_APP_API_PROTOCOL,
  host: import.meta.env.VITE_APP_API_HOST,
  port: import.meta.env.VITE_APP_API_PORT,
  baseURL: `${import.meta.env.VITE_APP_API_PROTOCOL}://${import.meta.env.VITE_APP_API_HOST}:${import.meta.env.VITE_APP_API_PORT}/api`,
  timeout: 5000,
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true,
  withXSRFToken: true,
}
export const config = {
  ...axiosConfig,

  // Other property
  appUrl: `${import.meta.env.VITE_APP_API_PROTOCOL}://${import.meta.env.VITE_APP_API_HOST}:${import.meta.env.VITE_APP_API_PORT}`,
}

export const http = axios.create(axiosConfig)
