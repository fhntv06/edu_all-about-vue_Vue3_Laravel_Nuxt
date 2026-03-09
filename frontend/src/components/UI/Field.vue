<template>
  <label :for="name" class="block text-sm font-medium text-gray-700 mb-4">
    <p>{{label}}</p>
    <textarea
      v-if="type === 'textarea'"
      v-bind="filteredProps"
      @input="updateField"
      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-vertical"
    />
    <input
      v-else
      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      v-bind="filteredProps"
      @input="updateField"
    />
  </label>
</template>
<script>
  import { computed } from "vue";

  export default {
    name: 'field',
    props: {
      id: { type: String, default: 'title' },
      name: { type: String, default: 'title' },
      type: {type: String, default: 'text' },
      label: String,
      placeholder: String,
      required: Boolean
    },
    setup(props) {
      const filteredProps = computed(() => {
        const { label, ...inputProps } = props
        return inputProps
      })

      return {
        filteredProps
      }
    },
    methods: {
      updateField(event) {
        this.$emit('update:modelValue', event.target.value)
      }
    }
  }
</script>
