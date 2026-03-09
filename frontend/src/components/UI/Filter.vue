<template>
  <div class="w-full sm:w-auto">
    <label for="post-filter" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
    </label>
    <select
      id="post-filter"
      :value="selectedValue"
      @change="handleFilterChange"
      class="w-full sm:w-64 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white text-gray-700"
    >
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'Filter',
  props: {
    data: {
      type: Array,
      default: () => []
    },
    label: {
      type: String,
      default: 'Фильтр'
    },
    options: {
      type: Array,
      default: () => [
        { value: 'recent', label: 'Новые записи' },
        { value: 'oldest', label: 'Старые записи' },
        { value: 'title_asc', label: 'По названию (А-Я)' },
        { value: 'title_desc', label: 'По названию (Я-А)' }
      ]
    }
  },
  data() {
    return {
      selectedValue: 'recent'
    }
  },
  computed: {
    filteredPosts() {
      switch (this.selectedValue) {
        case 'recent':
          return [...this.data].sort((a, b) => this.parseDate(b.date) - this.parseDate(a.date))
        case 'oldest':
          return [...this.data].sort((a, b) => this.parseDate(a.date) - this.parseDate(b.date))
        case 'title_asc':
          return [...this.data].sort((a, b) => a.title?.localeCompare(b.title || ''))
        case 'title_desc':
          return [...this.data].sort((a, b) => b.title?.localeCompare(a.title || ''))
        default:
          return this.data
      }
    }
  },
  methods: {
    handleFilterChange(event) {
      this.selectedValue = event.target.value
      this.$emit('filterChange', this.filteredPosts)
    },

    // Парсинг даты из строки формата "DD.MM.YYYY"
    parseDate(dateString) {
      if (!dateString) return new Date(0)

      const parts = dateString.split('.')
      if (parts.length !== 3) return new Date(0)

      const day = parseInt(parts[0], 10)
      const month = parseInt(parts[1], 10) - 1
      const year = parseInt(parts[2], 10)

      return new Date(year, month, day)
    },
  },
}
</script>
