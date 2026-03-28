<template>
  <div class="app">
    <router-view />
  </div>
</template>

<script>
import {defineComponent} from "vue";
import Dashboard from "@/layouts/DashboardLayout.vue";
import { configureEcho } from '@laravel/echo-vue';
import { broadcastingConfig } from "@/config";
export default defineComponent({
  name: 'App',
  created() {
    // Инициализируем авторизацию при запуске приложения
    this.$store.dispatch('initializeAuth')

    configureEcho(broadcastingConfig)
  },
  components: {Dashboard}
})

</script>
