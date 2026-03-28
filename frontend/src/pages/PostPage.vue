<template>
  <!-- Кнопка открытия модального окна -->
  <div class="flex flex-wrap gap-y-10 justify-between items-center mb-6">
    <div class="flex flex-wrap gap-3">
      <Select
        :label="'Вид отображения постов'"
        :options="[
          { value: 1, label: 'Список', icon: 'list' },
          { value: 0, label: 'Плитка', icon: 'grid' }
        ]"
        @changeValue="handleChangeViewType"
      />
      <Select
        :label="'Количество постов на странице'"
        @changeValue="handleChangeCountItemsOnPage"
      />
      <Filter
        :label="'Фильтр постов'"
        :data="posts"
        @filterChange="handleFilterChange"
      />
    </div>
    <router-link to="/dashboard/posts/create">
      <Button>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Добавить пост
      </Button>
    </router-link>
  </div>

  <loader :isLoading="isLoading" />

  <div class="grid grid-cols-1">
    <post-list :posts="posts" :isViewRows="isViewRows" @deletePost="deletePost" />
  </div>

  <div class="mt-8">
    <Pagination
      :currentPage="page"
      :totalItems="items"
      :totalPages="pages"
      :itemsPerPage="perPage"
      @pageChanged="handleChangePage"
    />
  </div>
</template>

<script>
import { ref } from "vue";
import PostForm from "@/components/Posts/PostForm.vue";
import PostList from "@/components/Posts/PostList.vue";
import Loader from "@/components/UI/Loader.vue";
import PostFilter from "@/components/UI/Filter.vue";
import { config } from '@/api'

export default {
  components: {
    PostFilter,
    Loader,
    PostList,
    PostForm,
  },
  data() {
    return {
      url: config.baseURL,
      isModalOpen: false,
      isLoading: false,
      page: 1,
      perPage: 2,
      pages: 1,
      items: 0,
      isViewRows: true,
    }
  },
  setup() {
    const posts = ref([])
    return {posts}
  },
  mounted() {
    this.isLoading = true

    this.updatePosts()
  },
  methods: {
    handleChangeViewType(value) {
      this.isViewRows = Boolean(value)
    },
    handleFilterChange(filteredPosts) {
      this.posts = filteredPosts
    },
    handleChangeCountItemsOnPage(count) {
      this.perPage = count

      this.updatePosts()
    },
    handleChangePage(page) {
      this.page = page

      this.updatePosts()
    },
    updatePosts() {
      this.isLoading = true

      const url = new URL(this.url);

      if (this.page) {
        url.searchParams.append('page', this.page);
      }
      if (this.perPage) {
        url.searchParams.append('per_page', this.perPage);
      }
      setTimeout(() => {
        fetch(url)
          .then((response) => {
            if (response.ok) return response.json()
            else throw new Error(`Status updatePosts is ${response.status}`)
          })
          .then(({ data, meta }) => {
            this.posts = data
            this.pages = meta.last_page
            this.items = meta.total
            this.page = meta.current_page
          })
          .catch((error) => console.error('Error get posts ', error))
          .finally(() => {
            this.isLoading = false
          })
      }, 1000)
    },
    deletePost(post) {
      fetch(`${this.url}/${post.id}`, {method: 'DELETE'})
        .then((response) => {
          if (response.ok) {
            console.warn(`Post with id="${post.id}" deleted!`)
            this.updatePosts()
          } else {
            throw new Error(`Status not ok, in deletePost! Status deletePost is ${response.status}`)
          }
        })
        .catch((e) => console.error(`Error delete post with id="${post.id}", ${e}`))
    }
  },
}
</script>
