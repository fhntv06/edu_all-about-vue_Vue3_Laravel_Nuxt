<template>
  <post-form @createPost="handleCreatePost" />
</template>

<script>
import PostForm from "@/components/Posts/PostForm.vue";
import {useRouter} from "vue-router";

export default {
  name: "PostCreatePage" ,
  components: {PostForm},
  setup() {
    const router = useRouter()

    return {
      router
    }
  },
  methods: {
    handleCreatePost(post) {
      this.createPost(post)
    },
    createPost(post) {
      const id = Date.now().toString()
      const postDate = new Date()

      fetch(this.url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          ...post,
          id,
          date: `${postDate.getDate()}.${postDate.getMonth() + 1}.${postDate.getFullYear()}`
        })
      })
        .then((response) => {
          if (response.ok) {
            console.warn(`Post with id="${id}" created!`)
            this.router.push('/dashboard/posts')
          } else {
            throw new Error(`Error request by create post with id="${id}"`)
          }
        })
        .catch((error) => console.error(error))
    },
  }
}
</script>
