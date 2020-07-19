<template lang="pug" scoped>
.tag-page
  <!-- Tag Info -->
  .tag-info.border-b.border-gray-800(v-for="tag in tagInfo")
    .container.mx-auto.px-4.py-16.flex.flex-col(class='md:flex-row')
      .flex-none
      .info(class='md:ml-24')
        h2.text-4xl.mt-4.font-semibold(class='md:mt-0')
        .flex.flex-wrap.items-center.text-gray-400.text-sm
          span.ml-1 tag Name:  {{ tag.name }}
  <!-- End Tag Info -->
  <!-- Tag Movie -->
  .movie-cast.border-b.border-gray-800(v-for="tag in tagInfo")
    .container.mx-auto.px-4.py-16
      h2.text-4xl.font-semibold Posts
      .inline-block.m-4.grid-cols-1.gap-8(v-for="post in tag.post" class='sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5')
        .mt-8
          NuxtLink(:to="{name: 'post-id', params: {id: post.id}}")
            img.transition.ease-in-out.duration-150(:src="post.photo", :alt="post.title", class='hover:opacity-75')
          .mt-2
            NuxtLink(:to="{name: 'post-id', params: {id: post.id}}").text-lg.mt-2 {{ post.title }}
  <!-- End Tag Movie -->
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "homeapp",
  name: "TagPage",
  data() {
    return {
      tagInfo: {},
    };
  },
  mounted() {
    const tagID = this.$route.params.id;
    this.info({ id: tagID }).then(response => {
      this.tagInfo = response.data.tag;
    });
  },
  methods: {
    ...mapActions({
      info: "frontend/tagPage",
    }),
  },
};
</script>
