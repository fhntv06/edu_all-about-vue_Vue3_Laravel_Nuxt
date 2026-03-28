<!-- components/GlobalNotification.vue -->
<template>
  <Teleport to="body">
    <div
      class="fixed z-[9999] pointer-events-none"
      :class="positionClasses"
    >
      <TransitionGroup
        :enter-active-class="enterAnimation"
        :leave-active-class="leaveAnimation"
        :enter-from-class="enterFromClass"
        :enter-to-class="enterToClass"
        :leave-from-class="leaveFromClass"
        :leave-to-class="leaveToClass"
        tag="div"
        class="flex flex-col gap-2 pointer-events-auto"
        :class="directionClass"
      >
        <div
          v-for="notification in notifications"
          :key="notification.id"
          :class="[
            'relative min-w-[320px] p-4 rounded-lg shadow-lg cursor-pointer overflow-hidden',
            'backdrop-blur-sm bg-opacity-95 transition-all',
            typeClasses[notification.type]
          ]"
          @click="handleNotificationClick(notification)"
        >
          <div class="flex items-start gap-3">
            <!-- Иконка -->
            <span class="text-lg font-bold mt-0.5">
              {{ icons[notification.type] }}
            </span>

            <!-- Сообщение -->
            <span class="flex-1 text-sm leading-5">
              {{ notification.message }}
            </span>

            <!-- Кнопка закрытия -->
            <button
              class="text-gray-400 hover:text-gray-600 transition-colors text-xl leading-none -mt-1"
              :class="closeButtonClasses[notification.type]"
              @click.stop="handleClose(notification.id)"
            >
              ×
            </button>
          </div>

          <!-- Прогресс-бар -->
          <div
            v-if="notification.duration > 0"
            class="absolute bottom-0 left-0 h-1 animate-progress"
            :class="progressBarClasses[notification.type]"
            :style="{ animationDuration: notification.duration + 'ms' }"
          />
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<script setup>
import {computed, watch} from 'vue'
import { storeToRefs } from 'pinia'
import { useNotificationStore } from '@/stores/notificationStore'

// ============ PROPS ============
const props = defineProps({
  position: {
    type: String,
    default: 'top-right',
    validator: (value) => ['top-right', 'top-left', 'bottom-right', 'bottom-left', 'top-center', 'bottom-center'].includes(value)
  },
  maxNotifications: {
    type: Number,
    default: 5
  },
  closeOnClick: {
    type: Boolean,
    default: true
  }
})

// ============ STORE ============
const notificationStore = useNotificationStore()
const { items: notifications } = storeToRefs(notificationStore)

// ============ EMITS ============
const emit = defineEmits(['notification-click', 'notification-close'])

// ============ CONSTANTS ============
const icons = {
  success: '✓',
  error: '✗',
  warning: '⚠',
  info: 'ℹ'
}

const typeClasses = {
  success: 'bg-green-50 border-l-4 border-green-500 text-green-800',
  error: 'bg-red-50 border-l-4 border-red-500 text-red-800',
  warning: 'bg-orange-50 border-l-4 border-orange-500 text-orange-800',
  info: 'bg-blue-50 border-l-4 border-blue-500 text-blue-800'
}

const closeButtonClasses = {
  success: 'hover:text-green-600',
  error: 'hover:text-red-600',
  warning: 'hover:text-orange-600',
  info: 'hover:text-blue-600'
}

const progressBarClasses = {
  success: 'bg-green-500 bg-opacity-30',
  error: 'bg-red-500 bg-opacity-30',
  warning: 'bg-orange-500 bg-opacity-30',
  info: 'bg-blue-500 bg-opacity-30'
}

// ============ COMPUTED ============
const positionClasses = computed(() => {
  const positions = {
    'top-right': 'top-5 right-5',
    'top-left': 'top-5 left-5',
    'bottom-right': 'bottom-5 right-5',
    'bottom-left': 'bottom-5 left-5',
    'top-center': 'top-5 left-1/2 -translate-x-1/2',
    'bottom-center': 'bottom-5 left-1/2 -translate-x-1/2'
  }
  return positions[props.position]
})

const directionClass = computed(() => {
  const directions = {
    'top-right': 'items-end',
    'top-left': 'items-start',
    'bottom-right': 'items-end flex-col-reverse',
    'bottom-left': 'items-start flex-col-reverse',
    'top-center': 'items-center',
    'bottom-center': 'items-center flex-col-reverse'
  }
  return directions[props.position]
})

const enterAnimation = computed(() => 'transform ease-out duration-300 transition')
const leaveAnimation = computed(() => 'transition ease-in duration-200')

const enterFromClass = computed(() => {
  if (props.position.includes('right')) return 'translate-x-5 opacity-0'
  if (props.position.includes('left')) return '-translate-x-5 opacity-0'
  if (props.position.includes('top')) return '-translate-y-5 opacity-0'
  if (props.position.includes('bottom')) return 'translate-y-5 opacity-0'
  return 'scale-95 opacity-0'
})

const enterToClass = computed(() => 'translate-x-0 translate-y-0 scale-100 opacity-100')
const leaveFromClass = computed(() => 'opacity-100 scale-100')
const leaveToClass = computed(() => 'opacity-0 scale-95')

// ============ METHODS ============
const handleNotificationClick = (notification) => {
  emit('notification-click', notification)
  if (props.closeOnClick) {
    notificationStore.remove(notification.id)
  }
}

const handleClose = (id) => {
  emit('notification-close', id)
  notificationStore.remove(id)
}

// Ограничение количества уведомлений
const limitNotifications = () => {
  if (notifications.value.length > props.maxNotifications) {
    const toRemove = notifications.value.slice(0, notifications.value.length - props.maxNotifications)
    toRemove.forEach(n => notificationStore.remove(n.id))
  }
}

// Следим за количеством уведомлений
watch(() => notifications.value.length, () => {
  limitNotifications()
})
</script>

<style scoped>
@keyframes progress {
  from { width: 100%; }
  to { width: 0%; }
}

.animate-progress {
  animation: progress linear forwards;
}
</style>
