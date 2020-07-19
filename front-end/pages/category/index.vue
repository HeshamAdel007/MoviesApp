<template lang="pug" scoped>
.categories
  <!-- Category -->
  .app-container.container.mx-auto.px-4.pt-16
    .inline-block.grid-cols-1.gap-8.m-8(class="sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5"
    v-for="category in categoriesInfo")
      .mt-8.w-15.h-20
        .mt-2
          NuxtLink(:to="{name: 'category-id', params: {id: category.id}}" class="text-lg mt-2 hover:text-gray-300") {{ category.name }}
  <!-- End Category -->
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "homeapp",
  name: "Categories",
  data() {
    return {
      categoriesInfo: {},
      paginations: {},
      page: "",
    };
  },
  mounted() {
    this.categories().then(response => {
      this.categoriesInfo = response.data.data;
      this.paginations = response.data.meta;
    });
  },
  methods: {
    ...mapActions({
      categories: "frontend/allCategory",
    }),
  },
};
</script>
