<template>
  <ul
    v-if="posts.length"
    class="grid gap-2 sm:gap-4"
    :class="isViewRows ? 'grid-cols-1' : 'grid-cols-2'"
  >
    <TransitionGroup name="list">
      <post-item v-for="post in posts" :key="post.id" :post="post" @deletePost="deletePost" />
    </TransitionGroup>
  </ul>
  <h3 v-else>Список постов пуст</h3>
</template>

<script>
import PostItem from "@/components/Posts/PostItem.vue";

export default {
  components: {PostItem},
  props: {
    posts: { type: Array, default: [] },
    isViewRows: { type: Boolean, default: true }
  },
  methods: {
    deletePost(post) {
      this.$emit('deletePost', post)
    }
  }
}
</script>
<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
