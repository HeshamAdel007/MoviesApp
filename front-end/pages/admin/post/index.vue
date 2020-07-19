<template lang="pug" scoped>
  .post-page
    .text-gray-900.bg-gray-200
    .p-4.flex
      h1.text-3xl
        | posts
    nuxt-link(to="/admin/post/create")
      button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') create
    nuxt-link(to="/admin/post/trash")
      button.text-sm.bg-red-500.text-white.py-1.px-2.rounded(class='hover:bg-red-700 focus:outline-none focus:shadow-outline') trash
    .px-3.py-4.flex.justify-center
      table.w-full.text-md.bg-white.shadow-md.rounded.mb-4
        tbody
          tr.border-b
            th.text-left.p-3.px-5 #
            th.text-left.p-3.px-5 Title
            th.text-left.p-3.px-5 Author
            th.text-left.p-3.px-5 Status
            th.text-left.p-3.px-5 Categories
            th.text-left.p-3.px-5 Tags
            th.text-left.p-3.px-5 Like
            th Actions
          <!-- Spinner -->
          .spin
            spinner(v-if="show")
          tr.border-b.bg-gray-100(v-for="(post, index) in postInfo" :key="index" class='hover:bg-orange-100')
            td.p-3.px-5
              .bg-transparent {{ index+1 }}
            td.p-3.px-5
              .bg-transparent {{ post.title }}
            td.p-3.px-5
              .bg-transparent {{ post.user_id.name }}
            td.p-3.px-5
              .bg-transparent {{ post.post_status }}
            td.p-3.px-5
              .bg-transparent(v-for="(category, index) in post.categories") {{ index+1 }}. {{ category.name }}
            td.p-3.px-5
              .bg-transparent(v-for="(tag, index) in post.tags") {{ index+1 }}. {{ tag.name }}
            td.p-3.px-5
              .bg-transparent {{ post.post_like }}
            td.p-3.px-5.flex.justify-end
              button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') view
              nuxt-link(:to="{name: 'admin-post-id', params: {id: post.id}}")
                button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') edit
              button.text-sm.bg-red-500.text-white.py-1.px-2.rounded(@click="trashed(post.id)" class='hover:bg-red-700 focus:outline-none focus:shadow-outline') trash
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Post",
  components: {
    Spinner,
  },
  data() {
    return {
      postInfo: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.post({ token: userToken })
      .then(response => {
        this.show = false;
        this.postInfo = response.data.data;
      })
      .catch(error => {
        this.show = false;
        // console.log(error.response);
        if (error.response.status === 500) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Post", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      post: "post/postInfo",
      postDelete: "post/deletePost",
    }),
    trashed(id) {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const postId = id;
      const userToken = localStorage.getItem("token");
      this.postDelete({ id: postId, token: userToken })
        .then(response => {
          this.$snotify.success(response.data.message, "Delete", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-post-trash" });
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
