<!-- components/UI/Breadcrumbs.vue -->
<template>
  <nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
      <li class="flex items-center" v-for="(breadcrumb, index) in formattedBreadcrumbs" :key="breadcrumb.name">
        <div class="flex items-center">
          <router-link
            v-if="breadcrumb.to && index !== formattedBreadcrumbs.length - 1"
            :to="breadcrumb.to"
            class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200"
          >
            {{ breadcrumb.name }}
          </router-link>
          <span
            v-else
            class="text-sm font-medium text-gray-900"
            :aria-current="index === formattedBreadcrumbs.length - 1 ? 'page' : undefined"
          >
            {{ breadcrumb.name }}
          </span>
        </div>
        <svg
          v-if="index < formattedBreadcrumbs.length - 1"
          class="flex-shrink-0 h-5 w-5 text-gray-400 ml-2"
          fill="currentColor"
          viewBox="0 0 20 20"
          aria-hidden="true"
        >
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
      </li>
    </ol>
  </nav>
</template>

<script>
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default {
  name: 'Breadcrumbs',
  setup() {
    const route = useRoute()
    const router = useRouter()

    const breadcrumbs = computed(() => {
      const paths = route.path.split('/').filter(path => path)
      const breadcrumbsArray = []

      let accumulatedPath = ''
      paths.forEach((path, index) => {
        accumulatedPath += `/${path}`

        const routeRecord = router.resolve(accumulatedPath)
        const breadcrumbName = getBreadcrumbName(path, routeRecord, route.params)

        breadcrumbsArray.push({
          name: breadcrumbName,
          to: index === paths.length - 1 ? null : accumulatedPath
        })
      })

      return breadcrumbsArray
    })

    const formattedBreadcrumbs = computed(() => {
      return breadcrumbs.value.map(breadcrumb => ({
        ...breadcrumb,
        name: formatName(breadcrumb.name, route.params)
      }))
    })

    const getBreadcrumbName = (path, routeRecord, params) => {
      if (routeRecord.meta?.breadcrumb) {
        return routeRecord.meta.breadcrumb
      }

      if (routeRecord.name) {
        return routeRecord.name
      }

      // Для динамических параметров (например, ID)
      if (path in params) {
        return `#${params[path]}`
      }

      return formatPathName(path)
    }

    const formatName = (name, params) => {
      if (typeof name === 'function') {
        return name(params)
      }
      return name
    }

    const formatPathName = (path) => {
      const formatted = path.replace(/-/g, ' ') // example: forgot-password -> forgot password
      return formatted.charAt(0).toUpperCase() + formatted.slice(1) // example: forgot password => Forgot password
    }

    return {
      formattedBreadcrumbs
    }
  }
}
</script>
