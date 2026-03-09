<template>
  <div class="app">
    <router-view />
  </div>
</template>

<script>
import {defineComponent} from "vue";
import Dashboard from "@/layouts/DashboardLayout.vue";

export default defineComponent({
  name: 'App',
  created() {
    // Инициализируем авторизацию при запуске приложения
    this.$store.dispatch('initializeAuth')
  },
  components: {Dashboard}
})

</script>
