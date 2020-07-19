<template lang="pug" scoped>
  .forgot-password-page.capitalize
    <!-- Page Overlay -->
    .overlay
    <!-- Page Image -->
    img(:src="forgotBack.imagePath" :alt="forgotBack.altImg")
    <!-- Page Container -->
    .container.w-full.px-15.mx-auto
    <!-- Form Forgot Password Container -->
      .forgot-container
        .forgot-body
          .row.flex.flex-wrap.w-full.h-full
            <!-- Form Imge -->
            .forgot-img
              img(:src="formImg.imagePath" :alt="formImg.altImg")
            <!-- Login Form -->
            .forgot-form
              <!-- Forgot Password Form Header -->
              .form-header
                ul.flex
                  nuxt-link.form-nav(to="/auth/password/forgot" tag="li")
                    a.nav-link forgot password
              <!-- Form -->
              form(@submit.prevent="forgotPasswordSend")
                <!-- Input E-Mail-->
                .input-container
                  label.input-label(for="email") e-mail
                  .inputIcon.iconBg
                    input#email.form-control(type="email" name="email" v-model="forgoForm.email" autocomplete="email" placeholder="E-Mail" autofocus)
                    i.fas.fa-envelope(aria-hidden="true")
                  span(v-if="errors.email") {{ errors.email[0] }}
                <!-- Forgot Password Button -->
                .input-container.text-center
                  .form-btn
                    button.btn.capitalize(type='submit')
                      |send e-mail
                      i.fas.fa-long-arrow-alt-right(aria-hidden="true")
              <!-- Spinner -->
              spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  name: "Forgot",
  components: {
    Spinner,
  },
  data() {
    return {
      forgoForm: {
        email: "",
      },
      errors: {},
      forgotBack: {
        imagePath: require("../../../static/image/bg-03.jpg"),
        altImg: "Forgot Page Background Img",
      },
      formImg: {
        imagePath: require("../../../static/image/bg-02.jpg"),
        altImg: "Forgot Form Img",
      },
      show: false,
    };
  },
  methods: {
    ...mapActions({
      forgotPassword: "auth/forgotPassword",
    }),
    forgotPasswordSend() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/email.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      // Show Spinner ON Click
      this.show = true;
      this.forgotPassword(this.forgoForm)
        .then(response => {
          // console.log(response.data);
          // Hidden Spinner When Get Response
          this.show = false;
          this.$snotify.success(response.data.message, "Password Reset", {
            icon: iconSuccess,
          });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          // Hidden Spinner When Get Error
          this.show = false;
          this.$snotify.error(error.response.data.message, "Password Reset", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
// ForgetPassword Page Style
@import "../../../assets/scss/auth/password/forgot-password";
</style>
