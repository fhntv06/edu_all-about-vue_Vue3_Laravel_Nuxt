<template>
  <form class="space-y-4" id="postForm" ref="refForm" @submit.prevent="createPost">
      <field
        :id="'title'"
        :name="'title'"
        :type="'text'"
        :label="'Название поста *'"
        :placeholder="'Введите название поста...'"
        v-model="post.title"
        :required="true"
      />
      <field
        :id="'author'"
        :name="'author'"
        :type="'text'"
        :label="'Автор *'"
        :placeholder="'Имя автора...'"
        v-model="post.author"
        :required="true"
      />
      <field
        :id="'content'"
        :name="'content'"
        :type="'textarea'"
        :label="'Содержание поста *'"
        :placeholder="'Напишите содержание вашего поста...'"
        v-model="post.content"
        :required="true"
      />

      <div class="flex gap-3">
        <Button
          :classes="'bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md font-medium transition-colors'"
          :type="'submit'"
        >
          Создать пост
        </Button>
        <Button
          :classes="'bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors'"
          @click="clearPost"
        >
          Очистить
        </Button>
      </div>
    </form>
</template>

<script>
  import { useTemplateRef } from 'vue'
  import { useRouter } from 'vue-router'
  import { config } from '@/api'

  export default {
    data() {
      return {
        url: config.baseURL,
        post: {
          title: '',
          content: '',
          author: '',
        }
      }
    },
    setup() {
      const refForm = useTemplateRef('refForm')
      const router = useRouter()

      return { refForm, router }
    },
    methods: {
      createPost() {
        fetch(this.url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            ...this.post,
          })
        })
          .then((response) => {
            if (response.ok) {
              console.warn('Post with created!')
              this.clearPost()
              this.router.push('/dashboard/posts')
            } else {
              throw new Error('Error request by create post with')
            }
          })
          .catch((error) => console.error(error))
      },
      clearPost() {
        this.refForm.reset()
        this.post = {
          title: '',
          content: '',
          author: '',
        }
      }
    }
  }
</script>

