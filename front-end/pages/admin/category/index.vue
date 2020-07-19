<template lang="pug" scoped>
  .category-page
    .text-gray-900.bg-gray-200
    .p-4.flex
      h1.text-3xl
        | category
    nuxt-link(to="/admin/category/create")
      button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') create
    .px-3.py-4.flex.justify-center
      table.w-full.text-md.bg-white.shadow-md.rounded.mb-4
        tbody
          tr.border-b
            th.text-left.p-3.px-5 #
            th.text-left.p-3.px-5 Name (Parent)
            th.text-left.p-3.px-5 Children
            th Actions
          <!-- Spinner -->
          .spin
            spinner(v-if="show")
          tr.border-b.bg-gray-100(v-for="(category, index) in categoryInfo" :key="index" class='hover:bg-orange-100')
            td.p-3.px-5
              .bg-transparent {{ index+1 }}
            td.p-3.px-5
              .bg-transparent {{ category.name }}
            td.p-3.px-5
              .bg-transparent(v-for="(child, index) in category.parent_id") {{ index+1 }}. {{ child.name }}
                nuxt-link(:to="{name: 'admin-category-id', params: {id: child.id}}")
                  button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') edit
                button.text-sm.bg-red-500.text-white.py-1.px-2.rounded(@click="deleteCategory(child.id)" class='hover:bg-red-700 focus:outline-none focus:shadow-outline') delete
            td.p-3.px-5.flex.justify-end
              nuxt-link(:to="{name: 'admin-category-id', params: {id: category.id}}")
                button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') edit
              button.text-sm.bg-red-500.text-white.py-1.px-2.rounded(@click="deleteCategory(category.id)" class='hover:bg-red-700 focus:outline-none focus:shadow-outline') delete
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Category",
  components: {
    Spinner,
  },
  data() {
    return {
      categoryInfo: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.category({ token: userToken })
      .then(response => {
        this.show = false;
        this.categoryInfo = response.data.data;
      })
      .catch(error => {
        this.show = false;
        // console.log(error.response);
        if (error.response.status === 500) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "category", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      category: "category/categoryInfo",
      categoryDelete: "category/deleteCategory",
    }),
    deleteCategory(id) {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const categoryId = id;
      const userToken = localStorage.getItem("token");
      this.categoryDelete({ id: categoryId, token: userToken })
        .then(response => {
          this.$snotify.success(response.data.message, "Delete", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-dashboard" });
        })
        .catch(error => {
          // console.log(error.response);
          if (error.response.status === 500) {
            this.$snotify.error("Can't Delete Admin Please Try Again Later", "Delete", {
              icon: iconError,
            });
          }
        });
    },
  },
};
</script>
