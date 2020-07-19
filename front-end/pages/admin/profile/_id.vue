<template lang="pug" scoped>
.profile-page
  .rounded-lg.shadow-lg.bg-gray-600.w-full.h-profile_img.overflow-hidden.flex.flex-row.flex-wrap.p-3.antialiased(style="\
  background-image: url('https://images.unsplash.com/photo-1578836537282-3171d77f8632?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80');\
  background-repeat: no-repat;\
  background-size: cover;\
  background-blend-mode: multiply;\
  ")
    .w-full.h-full(class='md:w-1/3')
      img.rounded-lg.shadow-lg.antialiased.h-full(:src="adminInfo.avatar" :alt="adminInfo.nickname")
    .w-full.px-3.flex(class='md:w-2/3')
      .w-full.text-right.text-gray-700.font-semibold.relative.pt-3(class='md:pt-0')
        .text-2xl.text-white.leading-tight Admin User
        .text-normal.text-gray-300.cursor-pointer(class='hover:text-gray-400')
          span.border-b.border-dashed.border-gray-500.pb-1 Administrator
  <!-- form -->
  form(@submit.prevent="profileUpdate" method="POST" enctype="multipart/form-data")
    <!-- Input Nickname -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="nickname") nickname / {{ adminInfo.nickname }}
      .inputIcon.iconBg
        input#nickname.form-control(type="text" name="nickname" v-model="profileInfo.nickname" autocomplete="nickname" placeholder="Nickname" autofocus)
        i.fas.fa-user(aria-hidden="true")
      span(v-if="errors.nickname") {{ errors.nickname[0] }}
    <!-- Input Description -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="email") description / {{ adminInfo.description }}
      .inputIcon.iconBg
        input#description.form-control(type="text" name="description" v-model="profileInfo.description" autocomplete="description" placeholder="Description" autofocus)
        i.fas.fa-envelope(aria-hidden="true")
      span(v-if="errors.description") {{ errors.description[0] }}
    <!-- Input About -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="about") about / {{ adminInfo.about }}
      .inputIcon.iconBg
        input#about.form-control(type="text" name="about" v-model="profileInfo.about" placeholder="About")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.about") {{ errors.about[0] }}
    <!-- Input Phone -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="phone") phone / {{ adminInfo.phone }}
      .inputIcon.iconBg
        input#phone.form-control(type="text" name="phone" v-model="profileInfo.phone" placeholder="Phone")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.phone") {{ errors.phone[0] }}
    <!-- Input Facebook -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="facebook") facebook / {{ adminInfo.facebook }}
      .inputIcon.iconBg
        input#facebook.form-control(type="text" name="facebook" v-model="profileInfo.facebook" autocomplete="facebook" placeholder="Efacebook" autofocus)
        i.fas.fa-envelope(aria-hidden="true")
      span(v-if="errors.facebook") {{ errors.facebook[0] }}
    <!-- Input Twitter -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="twitter") twitter / {{ adminInfo.twitter }}
      .inputIcon.iconBg
        input#twitter.form-control(type="text" name="twitter" v-model="profileInfo.twitter" placeholder="twitter")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.twitter") {{ errors.twitter[0] }}
    <!-- Input Instagram -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="instagram") instagram / {{ adminInfo.instagram }}
      .inputIcon.iconBg
        input#instagram.form-control(type="text" name="instagram" v-model="profileInfo.instagram" placeholder="instagram")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.instagram") {{ errors.instagram[0] }}
    <!-- Input Youtube -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="youtube") youtube / {{ adminInfo.youtube }}
      .inputIcon.iconBg
        input#youtube.form-control(type="text" name="youtube" v-model="profileInfo.youtube" placeholder="youtube")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.youtube") {{ errors.youtube[0] }}
    <!-- Input Avater -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="avatar") avatar
      .inputIcon.iconBg
        input#avatar.form-control(type="file" name="avatar" v-on:change="handleImgUpload" enctype="multipart/form-data")
    <!-- Edit Button -->
    .input-container.text-center
      .form-btn
        button.btn.capitalize(type='submit')
          | update
          i.fas.fa-long-arrow-alt-right(aria-hidden="true")
        <!-- Spinner -->
        .absolute.top-0.left-8
          spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Profile",
  components: {
    Spinner,
  },
  data() {
    return {
      profileInfo: {
        nickname: "",
        description: "",
        about: "",
        phone: "",
        facebook: "",
        twitter: "",
        instagram: "",
        avatar: "",
        youtube: "",
      },
      errors: {},
      adminInfo: {},
      show: false,
    };
  },
  mounted() {
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userID = this.$route.params.id;
    const userToken = localStorage.getItem("token");
    this.profile({ id: userID, token: userToken })
      .then(response => {
        // console.log(response, "page");
        this.adminInfo = response.data.profile;
      })
      .catch(error => {
        // console.log(error.response);
        if (error) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Profile", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      profile: "user/userProfile",
      update: "user/updateProfile",
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
        vm.profileInfo.avatar = event.target.result;
      };
      reader.readAsDataURL(file);
    },
    profileUpdate() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const userID = this.$route.params.id;
      const userToken = localStorage.getItem("token");
      this.show = true;
      this.update({
        id: userID,
        token: userToken,
        ...this.profileInfo,
      })
        .then(response => {
          // console.log(response);
          this.show = false;
          this.$snotify.success(response.data.message, "Profile Edit", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-users" });
        })
        .catch(error => {
          // console.log(error.response);
          this.errors = error.response.data.errors;
          this.show = false;
          this.$snotify.error(error.response.data.message, "Profile Edit", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/scss/stage/helped/mixins";
@import "../../../assets/scss/stage/helped/variables";
// Input Style
@import "../../../assets/scss/stage/componed/form-input";
// Button Style
@import "../../../assets/scss/stage/componed/form-btn";

.profile-page {
  form {
    @extend .input-form;
    .inputIcon {
      margin-left: 5px;
      width: 30em;
    }
  }
}
</style>
