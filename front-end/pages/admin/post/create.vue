<template lang="pug" scoped>
.create-post
  .p-4.flex
    h1.text-3xl
      | Create New Post
  form(@submit.prevent="newPost")
    .bg-white.shadow.rounded-lg.p-6
      .grid.gap-6(class='lg:grid-cols-2')
        <!-- Post Title -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              label.bg-white.text-gray-600.px-1(for='title') title *
          p
            input#title.py-1.px-1.text-gray-900.outline-none.block.h-full.w-full(autocomplete='false' tabindex='0' v-model="postInfo.title" name="title" type='text')
          span.text-primary(v-if="errors.title") {{ errors.title[0] }}
        <!-- Post Content -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              label.bg-white.text-gray-600.px-1(for='content') content *
          p
            textarea#content.py-1.px-1.outline-none.block.h-64.w-full(type="text" name="content" v-model="postInfo.content" placeholder="add your content")
          span.text-primary(v-if="errors.content") {{ errors.content[0] }}
        <!-- Post Trailer -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              label.bg-white.text-gray-600.px-1(for='trailer') trailer *
          p
            input#trailer.py-1.px-1.text-gray-900.outline-none.block.h-full.w-full( v-model="postInfo.trailer" tabindex='0' name="trailer" type='text')
        <!-- Post Actor -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              .bg-white.text-gray-600.px-1 actors *
          .actor.inline-block.p-4(v-for="(act, index) in actor" :key="index" )
            .bg-white.border-2.rounded.border-gray-400.inline-block.w-6.h-6.flex-shrink-0.justify-center.items-center.mr-2(class="focus-within:border-blue-500")
              input(type="checkbox" :id="act.name" name="actors[]" v-model="postInfo.actors" class="opacity-0 absolute" :value="act.id")
              svg.fill-current.hidden.w-4.h-4.text-green-500.pointer-events-none(viewBox="0 0 20 20")
                path(d="M0 11l2-2 5 5L18 3l2 2L7 18z")
            label(:for="act.name") {{ act.name }}
          span.text-primary(v-if="errors.actors") {{ errors.actors[0] }}
        <!-- Post Category -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              .bg-white.text-gray-600.px-1 categories *
          .category.inline-block.p-4(v-for="(categorys, index) in category" :key="index" )
            .bg-white.border-2.rounded.border-gray-400.inline-block.w-6.h-6.flex-shrink-0.justify-center.items-center.mr-2(class="focus-within:border-blue-500")
              input(type="checkbox" :id="categorys.name" name="categories[]" v-model="postInfo.categories" class="opacity-0 absolute" :value="categorys.id")
              svg.fill-current.hidden.w-4.h-4.text-green-500.pointer-events-none(viewBox="0 0 20 20")
                path(d="M0 11l2-2 5 5L18 3l2 2L7 18z")
            label(:for="categorys.name") {{ categorys.name }}
          span.text-primary(v-if="errors.categories") {{ errors.categories[0] }}
        <!-- Post Tag -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              .bg-white.text-gray-600.px-1 tags *
          .category.inline-block.p-4(v-for="(tags, index) in tag" :key="index" )
            .bg-white.border-2.rounded.border-gray-400.inline-block.w-6.h-6.flex-shrink-0.justify-center.items-center.mr-2(class="focus-within:border-blue-500")
              input(type="checkbox" :id="tags.name" name="tags[]" v-model="postInfo.tags" class="opacity-0 absolute" :value="tags.id")
              svg.fill-current.hidden.w-4.h-4.text-green-500.pointer-events-none(viewBox="0 0 20 20")
                path(d="M0 11l2-2 5 5L18 3l2 2L7 18z")
            label(:for="tags.name") {{ tags.name }}
          span.text-primary(v-if="errors.tags") {{ errors.tags[0] }}
        <!-- Post Photo -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              label.bg-white.text-gray-600.px-1(for='photo') photo *
          input#photo.p-4(type="file" name="photo" v-on:change="handleImgUpload" enctype="multipart/form-data")
        <!-- Post Status -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              label.bg-white.text-gray-600.px-1 status *
          .relative.inline-flex.p-4
            svg.w-2.h-2.absolute.top-0.right-0.m-4.pointer-events-none(xmlns='http://www.w3.org/2000/svg' viewbox='0 0 412 232')
              path(d='M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z' fill='#648299' fill-rule='nonzero')
            select.border.border-gray-300.rounded-full.text-gray-600.h-10.pl-5.pr-10.bg-white.appearance-none(class='hover:border-gray-400 focus:outline-none' v-model="postInfo.post_status")
              option(disabled value="") Post a Status
              option(value="publish") publish
              option(value="draft") draft
        <!-- Post Comment Status -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              label.bg-white.text-gray-600.px-1 comment *
          .relative.inline-flex.p-4
            svg.w-2.h-2.absolute.top-0.right-0.m-4.pointer-events-none(xmlns='http://www.w3.org/2000/svg' viewbox='0 0 412 232')
              path(d='M206 171.144L42.678 7.822c-9.763-9.763-25.592-9.763-35.355 0-9.763 9.764-9.763 25.592 0 35.355l181 181c4.88 4.882 11.279 7.323 17.677 7.323s12.796-2.441 17.678-7.322l181-181c9.763-9.764 9.763-25.592 0-35.355-9.763-9.763-25.592-9.763-35.355 0L206 171.144z' fill='#648299' fill-rule='nonzero')
            select.border.border-gray-300.rounded-full.text-gray-600.h-10.pl-5.pr-10.bg-white.appearance-none(v-model="postInfo.comment_status" class='hover:border-gray-400 focus:outline-none')
              option(disabled value="") comment status
              option(value="open") open
              option(value="close") close
      <!-- Create Button -->
      .form-btn
        button.btn(type='submit') Create
      <!-- Spinner -->
      .spin
        spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "PostCreate",
  components: {
    Spinner,
  },
  data() {
    return {
      postInfo: {
        title: "",
        content: "",
        photo: "",
        user_id: "",
        categories: [],
        actors: [],
        trailer: "",
        tags: [],
        post_status: "",
        comment_status: "",
      },
      category: [],
      tag: [],
      actor: [],
      errors: {},
      show: false,
    };
  },
  mounted() {
    const tokens = localStorage.getItem("token");
    this.show = true;
    this.getCategory({ token: tokens }).then(response => {
      this.show = false;
      this.category = response.data.data;
    });
    this.getTag({ token: tokens }).then(response => {
      this.show = false;
      this.tag = response.data.data;
    });
    this.getActor({ token: tokens }).then(response => {
      this.show = false;
      this.actor = response.data.data;
    });
    this.postInfo.user_id = localStorage.getItem("adminID");
  },
  methods: {
    ...mapActions({
      getCategory: "category/categoryInfo",
      getTag: "tag/tagInfo",
      getActor: "actor/actorInfo",
      addPost: "post/creatPost",
    }),
    handleImgUpload(event) {
      const files = event.target.files || event.dataTransfer.files;
      if (!files.length) {
        return;
      }
      this.createImage(files[0]);
    },
    createImage(file) {
      const reader = new FileReader();
      const vm = this;
      reader.onload = event => {
        vm.postInfo.photo = event.target.result;
      };
      reader.readAsDataURL(file);
    },
    newPost() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const tokens = localStorage.getItem("token");
      this.show = true;
      this.addPost({ token: tokens, ...this.postInfo })
        .then(response => {
          this.show = false;
          this.$snotify.success(response.data.message, "Create", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-post" });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.show = false;
          this.$snotify.error(error.response.data.message, "Create", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/scss/stage/helped/variables";
@import "../../../assets/scss/stage/helped/mixins";
// Button Style
@import "../../../assets/scss/stage/componed/form-btn";

input:checked + svg {
  display: block;
}
.category {
  label {
    display: inline-block;
    position: relative;
    bottom: 6px;
    margin-right: 10px;
  }
}
.create-post {
  .form-btn {
    @extend .form-btn;
  }
}
</style>
