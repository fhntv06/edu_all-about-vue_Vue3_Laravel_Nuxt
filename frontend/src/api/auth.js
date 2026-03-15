import axios from "axios";
import { apiConfig } from "@/config";

const url = apiConfig.baseURL
const fetchLogin = (data) => axios.post(`${url}/auth/login`, data)
const fetchRegister = (data) => axios.post(`${url}/auth/register`, data)
const fetchMe = (data) => axios.post(`${url}/auth/me`, data)
const fetchLogout = (data) => axios.post(`${url}/auth/logout`, data)

export { fetchLogin, fetchRegister, fetchMe, fetchLogout }
