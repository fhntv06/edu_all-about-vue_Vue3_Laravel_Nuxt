<!-- components/UI/Pagination.vue -->
<template>
  <div v-if="totalItems" class="flex items-center justify-between">
    <!-- Мобильная версия -->
    <div class="flex flex-1 gap-y-3 justify-between md:hidden flex-wrap">
      <button
        @click="goToPage(currentPage - 1)"
        :disabled="currentPage === 1"
        class="relative inline-flex items-center mr-3 px-4 py-2 text-sm font-medium rounded-md transition-colors order-1"
        :class="[
          currentPage === 1
            ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
            : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
        ]"
      >
        Назад
      </button>
      <div class="flex justify-center gap-x-3 md:hidden order-3 md:order-2 w-full">
        <!-- Номера страниц -->
        <button
          v-for="page in visiblePages"
          :key="page"
          @click="goToPage(page)"
          class="relative inline-flex items-center px-4 py-2 text-sm font-semibold transition-colors"
          :class="[
                page === currentPage
                  ? 'z-10 bg-blue-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600'
                  : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 bg-white'
              ]"
          aria-current="page"
        >
          {{ page }}
        </button>
      </div>
      <button
        @click="goToPage(currentPage + 1)"
        :disabled="currentPage === totalPages"
        class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors order-2 md:order-3"
        :class="[
          currentPage === totalPages
            ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
            : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
        ]"
      >
        Вперед
      </button>
    </div>

    <!-- Десктопная версия -->
    <div class="hidden md:flex md:flex-1 md:items-center md:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Показано
          <span class="font-medium">{{ startItem }}</span>
          -
          <span class="font-medium">{{ endItem }}</span>
          из
          <span class="font-medium">{{ totalItems }}</span>
          результатов
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <!-- Кнопка "Назад" -->
          <button
            @click="goToPage(currentPage - 1)"
            :disabled="currentPage === 1"
            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 transition-colors"
            :class="[
              currentPage === 1
                ? 'cursor-not-allowed bg-gray-50'
                : 'hover:bg-gray-50 bg-white'
            ]"
          >
            <span class="sr-only">Предыдущая</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
            </svg>
          </button>

          <!-- Номера страниц -->
          <button
            v-for="page in visiblePages"
            :key="page"
            @click="goToPage(page)"
            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold transition-colors"
            :class="[
              page === currentPage
                ? 'z-10 bg-blue-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600'
                : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 bg-white'
            ]"
            aria-current="page"
          >
            {{ page }}
          </button>

          <!-- Кнопка "Вперед" -->
          <button
            @click="goToPage(currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 transition-colors"
            :class="[
              currentPage === totalPages
                ? 'cursor-not-allowed bg-gray-50'
                : 'hover:bg-gray-50 bg-white'
            ]"
          >
            <span class="sr-only">Следующая</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l4.5-4.25a.75.75 0 111.04 1.08L11.168 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 01.02-.02z" clip-rule="evenodd" />
            </svg>
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    currentPage: {
      type: Number,
      required: true,
      default: 1
    },
    totalItems: {
      type: Number,
      required: true,
      default: 0
    },
    itemsPerPage: {
      type: Number,
      default: 10
    },
    totalPages: {
      type: Number,
      default: 1
    },
    maxVisiblePages: {
      type: Number,
      default: 5
    }
  },
  computed: {
    startItem() {
      return (this.currentPage - 1) * this.itemsPerPage + 1
    },
    endItem() {
      const end = this.currentPage * this.itemsPerPage
      return end > this.totalItems ? this.totalItems : end
    },
    visiblePages() {
      const pages = []
      let startPage = Math.max(1, this.currentPage - Math.floor(this.maxVisiblePages / 2))
      let endPage = startPage + this.maxVisiblePages - 1

      if (endPage > this.totalPages) {
        endPage = this.totalPages
        startPage = Math.max(1, endPage - this.maxVisiblePages + 1)
      }

      for (let i = startPage; i <= endPage; i++) {
        pages.push(i)
      }

      return pages
    }
  },
  methods: {
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages && page !== this.currentPage) {
        this.$emit('pageChanged', page)
      }
    }
  },
}
</script>

<style scoped>
/* Плавные переходы для всех интерактивных элементов */
button {
  transition: all 0.2s ease-in-out;
}

/* Улучшение фокуса для доступности */
button:focus-visible {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
</style>
