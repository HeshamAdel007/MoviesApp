<template lang="pug" scoped>
.singlepage
  <!-- Movie Info -->
  .movie-info.border-b.border-gray-800(v-for="info in moviesInfo")
    .container.mx-auto.px-4.py-16.flex.flex-col(class='md:flex-row')
      .flex-none
        img.w-64(:src="info.photo", :alt="info.title", class='lg:w-96')
      .info(class='md:ml-24')
        h2.text-4xl.mt-4.font-semibold(class='md:mt-0')
        .flex.flex-wrap.items-center.text-gray-400.text-sm
          svg.fill-current.text-orange-500.w-4(viewBox='0 0 24 24')
            g(data-name='Layer 2')
              path(d='M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z', data-name='star')
          span.ml-1 {{ info.title }}
          span.mx-2 |
          span {{ info.date }}
          span.mx-2 |
          span(v-for="categories in info.categories")
            NuxtLink(:to="{name: 'category-id', params: {id: categories.id}}" class="hover:text-red-400") {{ categories.name }}   ,
        span.text-gray-300.mt-8(v-for="tag in info.tags") Tags:
          NuxtLink(:to="{name: 'tag-id', params: {id: tag.id}}" class="hover:text-red-400") {{ tag.name }}
        .text-gray-300.mt-8 {{ info.trailer }}
        .like-btn
          button.border-red-800(@click="likeIt(info.id)" name="post_like")
            i.fas.fa-thumbs-up
            | Like {{ likes }}
        p.text-gray-300.mt-8
          | {{ info.content }}
  <!-- End Movie Info -->
  <!-- Movie Cast -->
  .movie-cast.border-b.border-gray-800(v-for="info in moviesInfo")
    .container.mx-auto.px-4.py-16
      h2.text-4xl.font-semibold Cast
      .inline-block.m-4.grid-cols-1.gap-8(v-for="actors in info.actors" class='sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5')
        .mt-8
          NuxtLink(:to="{name: 'actor-id', params: {id: actors.id}}")
            img.transition.ease-in-out.duration-150(:src="actors.photo", :alt="actors.name", class='hover:opacity-75')
          .mt-2
            NuxtLink(:to="{name: 'actor-id', params: {id: actors.id}}").text-lg.mt-2 {{ actors.name }}
  <!-- End Movie Cast -->
  <!-- Comment Form -->
  .comment.border-b.border-gray-800
    .comment-form
      .flex.mx-auto.items-center.justify-center.shadow-lg.mt-56.mx-8.mb-4.max-w-lg
      form.w-full.max-w-xl.rounded-lg.px-4.pt-2(@submit.prevent="newComment")
        h2.px-4.pt-3.pb-2.text-white.text-lg Add a new comment
        <!-- Comment Name -->
        .w-64
          input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='text' name='name', placeholder='Type Your Name', required='' v-model="commentForm.name")
        <!-- Comment E-mail -->
        .w-64
          input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='email' name='email', placeholder='Type Your E-mail', required='' v-model="commentForm.email")
        <!-- Comment Post ID -->
        .w-64
          input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='hidden' name='post_id' v-model="commentForm.post_id")
        <!-- Comment User ID -->
        .w-64
          input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='hidden' name='user_id' v-model="commentForm.user_id")
        <!-- Comment Body -->
        .w-full.px-3.mb-2.mt-2(class='md:w-full')
          textarea.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.h-20.py-2.px-3.font-medium.placeholder-gray-700(type='text' name='body', placeholder='Type Your Comment', required='' v-model="commentForm.body")
        .w-full.flex.items-start.px-3(class='md:w-full md:w-full')
          .flex.items-start.text-white.px-2.mr-auto(class='w-1/2')
            svg.w-5.h-5.text-gray-600.mr-1(fill='none', viewBox='0 0 24 24', stroke='currentColor')
              path(stroke-linecap='round', stroke-linejoin='round', stroke-width='2', d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z')
            p.text-xs.pt-px your email will not published.
          .-mr-1
            button.bg-white.text-gray-700.font-medium.py-1.px-4.border.border-gray-400.rounded-lg.tracking-wide.mr-1(type='submit', class='hover:bg-gray-100') Comment
    <!-- End Comment Form -->
  <!-- Comments -->
  .comment-info.border-b.border-gray-800
    .container.mx-auto.px-4.py-16
      h2.text-4xl.font-semibold Comment [ {{ commentCount }} ]
      .flex.flex-wrap.items-center.text-gray-400.text-sm(v-for="comment in comments")
        .text-orange-500.w-full
          p Name:
            span.text-gray-400 {{ comment.name }}
        .text-orange-500.w-full
          p Comment:
            span.text-gray-400 {{ comment.body }}
          .rep(v-for="reply in replys")
            .repy(v-if="reply.parent_id == comment.id")
              .text-orange-500.w-full
                p Reply Name:
                  span.text-gray-400 {{ reply.name }}
              .text-orange-500.w-full
                p Reply Comment:
                  span.text-gray-400 {{ reply.body }}
            .repy(v-if="reply.parent_id != comment.id")
              <!-- Replay Form -->
              .comment-form.relative.bottom-16
                .flex.mx-auto.items-center.justify-center.shadow-lg.mt-56.mx-8.mb-4.max-w-lg
                form.w-full.max-w-xl.rounded-lg.px-4.pt-2(@submit.prevent="replay(comment.id)")
                  h2.px-4.pt-3.pb-2.text-white.text-lg Add Reply
                  <!-- Comment Name -->
                  .w-64
                    input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='text' name='name', placeholder='Type Your Name', required='' v-model="replayForm.name")
                  <!-- Comment E-mail -->
                  .w-64
                    input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='email' name='email', placeholder='Type Your E-mail', required='' v-model="replayForm.email")
                  <!-- Comment Post ID -->
                  .w-64
                    input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='hidden' name='post_id' v-model="replayForm.post_id")
                  <!-- Comment User ID -->
                  .w-64
                    input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='hidden' name='user_id' v-model="replayForm.user_id")
                  <!-- Comment ID -->
                  .w-64
                    input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='hidden' name='comment_id' v-model="replayForm.comment_id")
                  <!-- Comment Body -->
                  .w-full.px-3.mb-2.mt-2(class='md:w-full')
                    textarea.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.h-20.py-2.px-3.font-medium.placeholder-gray-700(type='text' name='body', placeholder='Type Your Comment', required='' v-model="replayForm.body")
                  .w-full.flex.items-start.px-3(class='md:w-full md:w-full')
                    .flex.items-start.text-white.px-2.mr-auto(class='w-1/2')
                      svg.w-5.h-5.text-gray-600.mr-1(fill='none', viewBox='0 0 24 24', stroke='currentColor')
                        path(stroke-linecap='round', stroke-linejoin='round', stroke-width='2', d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z')
                      p.text-xs.pt-px your email will not published.
                    .-mr-1
                      button.bg-white.text-gray-700.font-medium.py-1.px-4.border.border-gray-400.rounded-lg.tracking-wide.mr-1(type='submit', class='hover:bg-gray-100') reply
              <!-- End Replay Form -->
        .border-b.border-red-300

  <!-- End Comments -->
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "homeapp",
  name: "SinglePage",
  data() {
    return {
      moviesInfo: {},
      likes: "",
      comments: {},
      replys: {},
      commentCount: "",
      commentForm: {
        name: "",
        email: "",
        body: "",
        user_id: "",
        post_id: "",
      },
      replayForm: {
        name: "",
        email: "",
        body: "",
        user_id: "",
        post_id: "",
        comment_id: "",
      },
    };
  },
  mounted() {
    const movieID = this.$route.params.id;
    this.info({ id: movieID }).then(response => {
      this.moviesInfo = response.data.singlePost;
      this.likes = this.moviesInfo[0].post_like;
    });
    this.getComments({ id: movieID }).then(response => {
      this.comments = response.data.comments;
      this.commentCount = response.data.count;
    });
    this.getReplys({ id: movieID }).then(response => {
      this.replys = response.data.replys;
    });
  },
  methods: {
    ...mapActions({
      info: "frontend/singlePage",
      like: "frontend/likePost",
      comment: "frontend/addComment",
      replays: "frontend/addReply",
      getComments: "frontend/getComment",
      getReplys: "frontend/getReply",
    }),
    likeIt(id) {
      const postId = id;
      this.like({ id: postId }).then(response => {
        this.likes++;
      });
    },
    newComment() {
      // Icon Image Snotify
      const iconSuccess = require("../../static/image/snotify_icon/double-tick.png");
      this.commentForm.user_id = localStorage.getItem("adminID");
      this.commentForm.post_id = this.$route.params.id;
      this.comment(this.commentForm).then(response => {
        this.comments.unshift(response.data);
        this.commentForm.body = "";
        this.commentForm.name = "";
        this.commentForm.email = "";
        this.commentForm.body = "";
        this.commentForm.user_id = "";
        this.commentForm.post_id = "";
        this.$snotify.success("Add Comment Is Successfully", "Comment", {
          icon: iconSuccess,
        });
      });
    },
    replay(id) {
      // Icon Image Snotify
      const iconSuccess = require("../../static/image/snotify_icon/double-tick.png");
      this.replayForm.user_id = localStorage.getItem("adminID");
      this.replayForm.post_id = this.$route.params.id;
      this.replayForm.comment_id = id;
      this.replays(this.replayForm).then(response => {
        this.replys.unshift(response.data);
        this.replys.body = "";
        this.replys.name = "";
        this.replys.email = "";
        this.replys.body = "";
        this.replys.user_id = "";
        this.replys.post_id = "";
        this.replys.comment_id = "";
        this.$snotify.success("Add Replay Is Successfully", "Replay", {
          icon: iconSuccess,
        });
      });
    },
  },
};
</script>
