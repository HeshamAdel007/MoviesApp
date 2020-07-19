<template lang="pug" scoped>
.category-page
  <!-- category Info -->
  .category-info.border-b.border-gray-800(v-for="category in categoryInfo")
    .container.mx-auto.px-4.py-16.flex.flex-col(class='md:flex-row')
      .flex-none
      .info(class='md:ml-24')
        h2.text-4xl.mt-4.font-semibold(class='md:mt-0')
        .flex.flex-wrap.items-center.text-gray-400.text-sm
          span.ml-1 Category Name:  {{ category.name }}
        p.text-gray-300.mt-8(v-for="child in category.parent_id")
          | CategoryChildern:>> {{ child.name }}
  <!-- End category Info -->
  <!-- category Movie -->
  .movie-cast.border-b.border-gray-800(v-for="category in categoryInfo")
    .container.mx-auto.px-4.py-16
      h2.text-4xl.font-semibold Posts
      .inline-block.m-4.grid-cols-1.gap-8(v-for="post in category.post" class='sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5')
        .mt-8
          NuxtLink(:to="{name: 'post-id', params: {id: post.id}}")
            img.transition.ease-in-out.duration-150(:src="post.photo", :alt="post.title", class='hover:opacity-75')
          .mt-2
            NuxtLink(:to="{name: 'post-id', params: {id: post.id}}").text-lg.mt-2 {{ post.title }}
  <!-- End category Movie -->
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "homeapp",
  name: "CategoryPage",
  data() {
    return {
      categoryInfo: {},
    };
  },
  mounted() {
    const categoryID = this.$route.params.id;
    this.info({ id: categoryID }).then(response => {
      this.categoryInfo = response.data.categories;
    });
  },
  methods: {
    ...mapActions({
      info: "frontend/categoryPage",
    }),
  },
};
</script>
