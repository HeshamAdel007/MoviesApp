<template lang="pug" scoped>
.Search
  <!-- Search -->
  .app-container.container.mx-auto.px-4.pt-16
    .inline-block.grid-cols-1.gap-8.m-8(class="sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5"
    v-for="post in searchInfo")
      .mt-8.w-15.h-20
        NuxtLink(:to="{name:'post-id', params: {id: post.id}}" )
          img.relative.w-full.h-full(:src="post.photo" :alt="post.title" class="hover:opacity-75 transition ease-in-out duration-150")
        .mt-2
          NuxtLink(:to="{name:'post-id', params: {id: post.id}}" class="text-lg mt-2 hover:text-gray-300") {{ post.title}}
          .flex.items-center.text-gray-400.text-sm.mt-1
            svg.fill-current.text-orange-500.w-4(viewBox='0 0 24 24')
              g(data-name='Layer 2')
                path(d='M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z', data-name='star')
  <!-- End Search -->
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "homeapp",
  name: "Search",
  data() {
    return {
      searchInfo: {},
    };
  },
  mounted() {
    const search = localStorage.getItem("search");
    this.posts({ data: search }).then(response => {
      this.searchInfo = response.data.posts;
      localStorage.removeItem("search");
    });
  },
  methods: {
    ...mapActions({
      posts: "frontend/searchPage",
    }),
  },
};
</script>
