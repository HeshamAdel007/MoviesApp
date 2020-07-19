<template lang="pug" scoped>
.actor-page
  <!-- Actor Info -->
  .actor-info.border-b.border-gray-800(v-for="actor in actorInfo")
    .container.mx-auto.px-4.py-16.flex.flex-col(class='md:flex-row')
      .flex-none
        img.w-64(:src="actor.photo", :alt="actor.name", class='lg:w-96')
      .info(class='md:ml-24')
        h2.text-4xl.mt-4.font-semibold(class='md:mt-0')
        .flex.flex-wrap.items-center.text-gray-400.text-sm
          svg.fill-current.text-orange-500.w-4(viewBox='0 0 24 24')
            g(data-name='Layer 2')
              path(d='M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z', data-name='star')
          span.ml-1 {{ actor.name }}
        p.text-gray-300.mt-8
          | {{ actor.description }}
  <!-- End Actor Info -->
  <!-- Actor Movie -->
  .movie-cast.border-b.border-gray-800(v-for="actor in actorInfo")
    .container.mx-auto.px-4.py-16
      h2.text-4xl.font-semibold Posts
      .inline-block.m-4.grid-cols-1.gap-8(v-for="post in actor.post" class='sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5')
        .mt-8
          NuxtLink(:to="{name: 'post-id', params: {id: post.id}}")
            img.transition.ease-in-out.duration-150(:src="post.photo", :alt="post.title", class='hover:opacity-75')
          .mt-2
            NuxtLink(:to="{name: 'post-id', params: {id: post.id}}").text-lg.mt-2 {{ post.title }}
  <!-- End Actor Movie -->
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "homeapp",
  name: "ActorPage",
  data() {
    return {
      actorInfo: {},
    };
  },
  mounted() {
    const actorID = this.$route.params.id;
    this.info({ id: actorID }).then(response => {
      this.actorInfo = response.data.actor;
    });
  },
  methods: {
    ...mapActions({
      info: "frontend/actorPage",
    }),
  },
};
</script>
