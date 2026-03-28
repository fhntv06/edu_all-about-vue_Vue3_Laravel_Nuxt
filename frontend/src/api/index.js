import { config } from "./config";
import { fetchLogin, fetchRegister, fetchLogout, fetchMe } from './auth'
import { fetchBroadcastingAuth } from './broadcasting'

export {
  // Config
  config,

  // Auth methods
  fetchLogin,
  fetchRegister,
  fetchLogout,
  fetchMe,

  // Broadcasting methods
  fetchBroadcastingAuth,

  // Posts methods
    // fetchGetPosts
    // fetchUpdatePost
    // fetchDeletePost
    // fetchCreatePost

  // Users methods
    // fetchGetUsers
    // fetchUpdateUser
    // fetchDeleteUser
    // fetchCreateUser
}
