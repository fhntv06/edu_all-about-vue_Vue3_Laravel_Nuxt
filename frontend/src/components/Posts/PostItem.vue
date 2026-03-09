<template>
  <li class="relative w-full bg-white rounded-lg shadow-md p-2 sm:p-6 border border-gray-200 hover:shadow-lg active:shadow-lg transition-shadow">
    <h2 class="pr-6 sm:text-2xl font-bold text-gray-800 mb-3">{{ post.title }}</h2>
    <div class="text-gray-600 mb-4">
      <!-- Для десктопа показываем полный текст -->
      <span class="hidden sm:inline">{{ post.content }}</span>
      <!-- Для мобильных обрезаем через CSS -->
      <span class="sm:hidden mobile-truncate">{{ post.content }}</span>
    </div>
    <div class="flex items-center justify-between text-sm text-gray-500">
      <span>Автор: {{ post.author }}</span>
      <span>{{ post.created_at }}</span>
    </div>
    <button class="absolute top-[12px] right-[12px] text-gray-400 hover:text-red-500 transition-colors group cursor-pointer" @click="deletePost(post)">
      <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </li>
</template>

<script>
  export default {
    props: {
      post: {
        type: {
          id: Number,
          author: String,
          title: String,
          content: String,
          created_at: String,
          page: String,
          per_page: String,
          search: String,
          status: String,
          sort: String,
          order: String,
          start_date: String,
          end_date: String,
        },
        required: true
      }
    },
    methods: {
      deletePost(post) {
        this.$emit('deletePost', post)
      }
    },
  }
</script>
<style scoped>
.mobile-truncate {
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Ограничиваем 3 строками (примерно 8 слов) */
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
