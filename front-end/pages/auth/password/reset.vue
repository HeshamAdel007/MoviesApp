<template lang="pug" scoped>
  .reset-password-page.capitalize
    <!-- Page Overlay -->
    .overlay
    <!-- Page Image -->
    img(:src="resetBack.imagePath" :alt="resetBack.altImg")
    <!-- Page Container -->
    .container.w-full.px-15.mx-auto
    <!-- Form Reset PassWord Container -->
      .reset-container
        .reset-body
          .row.flex.flex-wrap.w-full.h-full
            <!-- Form Imge -->
            .reset-img
              img(:src="formImg.imagePath" :alt="formImg.altImg")
            <!-- Reset PassWord Form -->
            .reset-form
              <!-- Reset PassWord Form Header -->
              .form-header
                ul.flex
                  nuxt-link.form-nav(to="/auth/password/reset" tag="li")
                    a.nav-link reset password
              <!-- Form -->
              form(@submit.prevent="newPassword")
                <!-- Input E-Mail -->
                .input-container
                  label.input-label(for="email") e-mail
                  .inputIcon.iconBg
                    input#email.form-control(type="email" name="email" v-model="resetForm.email" autocomplete="email" placeholder="E-Mail" autofocus)
                    i.fas.fa-envelope(aria-hidden="true")
                  span(v-if="errors.email") {{ errors.email[0] }}
                <!-- Input PassWord -->
                .input-container
                  label.input-label(for="password") password
                  .inputIcon.iconBg
                    input#password.form-control(type="password" name="password" autocomplete="current-password" v-model="resetForm.password" placeholder="Password")
                    i.fas.fa-unlock-alt(aria-hidden="true")
                  span(v-if="errors.password") {{ errors.password[0] }}
                <!-- Input PassWord Confirmation -->
                .input-container
                  label.input-label(for="password_confirmation") password confirmation
                  .inputIcon.iconBg
                    input#password_confirmation.form-control(type="password" name="password_confirmation" v-model="resetForm.password_confirmation" autocomplete="new-password" placeholder="password Confirmation")
                    i.fas.fa-unlock-alt(aria-hidden="true")
                  span(v-if="errors.password") {{ errors.password[1] }}
                <!-- Reset PassWord Button -->
                .input-container.text-center
                  .form-btn
                    button.btn.capitalize(type='submit')
                      | reset password
                      i.fas.fa-long-arrow-alt-right(aria-hidden="true")
                    <!-- Spinner -->
                    .absolute.top-0.left-11
                      spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  name: "Reset",
  components: {
    Spinner,
  },
  data() {
    return {
      resetForm: {
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: {},
      resetBack: {
        imagePath: require("../../../static/image/bg-01.jpg"),
        altImg: "Reset Password Page Background Img",
      },
      formImg: {
        imagePath: require("../../../static/image/bg-04.jpg"),
        altImg: "Reset Password Form Img",
      },
      show: false,
    };
  },
  methods: {
    ...mapActions({
      resetPassword: "auth/resetPassword",
    }),
    newPassword() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      // Show Spinner ON Click
      this.show = true;
      // Save Token From Url To Use IN Process Reset Password
      const token = this.$route.query.token;
      this.resetPassword({ ...this.resetForm, token })
        .then(response => {
          // console.log(response.data);
          // Hidden Spinner When Get Response
          this.show = false;
          this.$snotify.success(response.data.message, "Reset Password", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "auth-login" });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          // Hidden Spinner When Get Error
          this.show = false;
          this.$snotify.error(error.response.data.message, "Reset Password", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
// Reset Password Page Style
@import "../../../assets/scss/auth/password/reset-password";
</style>
