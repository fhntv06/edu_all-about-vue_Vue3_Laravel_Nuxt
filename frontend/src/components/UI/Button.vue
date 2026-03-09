<template>
  <button
    @click="handleClick"
    :class="classes"
    :type="type"
    :disabled="disabled"
  >
    <slot />
  </button>
</template>

<script>
  export default {
    name: 'Button',
    props: {
      classes: {
        type: String,
        default: 'h-max bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2'
      },
      type: {
        type: String,
        default: 'button'
      },
      disabled: {
        type: Boolean,
        default: false
      }
    },
    methods: {
      handleClick(event) {
        this.$emit('click', event);
      }
    }
  }
</script>
