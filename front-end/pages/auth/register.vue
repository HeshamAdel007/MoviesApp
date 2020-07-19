<template lang="pug" scoped>
  .register-page.capitalize
    <!-- Page Overlay -->
    .overlay
    <!-- Page Image -->
    img(:src="registerBack.imagePath" :alt="registerBack.altImg")
    <!-- Page Container -->
    .container.w-full.px-15.mx-auto
    <!-- Form Register Container -->
      .register-container
        .register-body
          .row.flex.flex-wrap.w-full.h-full
            <!-- Form Imge -->
            .register-img
              img(:src="formImg.imagePath" :alt="formImg.altImg")
            <!-- Register Form -->
            .register-form
              <!-- Register Form Header -->
              .form-header
                ul.flex
                  nuxt-link.form-nav(to="/auth/login" tag="li")
                    a.nav-link login
                  span /
                  nuxt-link.form-nav(to="/auth/register" tag="li")
                    a.nav-link register
              <!-- Form -->
              form(@submit.prevent="signUp")
                <!-- Input UserName -->
                .input-container
                  label.input-label(for="name") user name
                  .inputIcon.iconBg
                    input#name.form-control(type="text" name="name" v-model="userSingUp.name" autocomplete="name" placeholder="UserName" autofocus)
                    i.fas.fa-user(aria-hidden="true")
                  span(v-if="errors.name") {{ errors.name[0] }}
                <!-- Input E-Mail -->
                .input-container
                  label.input-label(for="email") e-mail
                  .inputIcon.iconBg
                    input#email.form-control(type="email" name="email" v-model="userSingUp.email" autocomplete="email" placeholder="E-Mail" autofocus)
                    i.fas.fa-envelope(aria-hidden="true")
                  span(v-if="errors.email") {{ errors.email[0] }}
                <!-- Input PassWord -->
                .input-container
                  label.input-label(for="password") password
                  .inputIcon.iconBg
                    input#password.form-control(type="password" name="password" v-model="userSingUp.password" autocomplete="current-password" placeholder="Password")
                    i.fas.fa-unlock-alt(aria-hidden="true")
                  span(v-if="errors.password") {{ errors.password[0] }}
                <!-- Input PassWord Confirmation -->
                .input-container
                  label.input-label(for="password_confirmation") password confirmation
                  .inputIcon.iconBg
                    input#password_confirmation.form-control(type="password" name="password_confirmation" v-model="userSingUp.password_confirmation" autocomplete="new-password" placeholder="password Confirmation")
                    i.fas.fa-unlock-alt(aria-hidden="true")
                  span(v-if="errors.password") {{ errors.password[1] }}
                <!-- Register Button -->
                .input-container.text-center
                  .form-btn
                    button.btn.capitalize(type='submit')
                      | register
                      i.fas.fa-long-arrow-alt-right(aria-hidden="true")
                    <!-- Spinner -->
                    .absolute.top-0.left-8
                      spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../components/loading/Spinner.vue";

export default {
  name: "Register",
  components: {
    Spinner,
  },
  data() {
    return {
      userSingUp: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: {},
      registerBack: {
        imagePath: require("../../static/image/bg-01.jpg"),
        altImg: "register Page Background Img",
      },
      formImg: {
        imagePath: require("../../static/image/bg-04.jpg"),
        altImg: "register Form Img",
      },
      show: false,
    };
  },
  methods: {
    ...mapActions({
      register: "auth/signUp",
    }),
    signUp() {
      // Icon Image Snotify
      const iconSuccess = require("../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../static/image/snotify_icon/warning.png");
      // Show Spinner ON Click
      this.show = true;
      this.register(this.userSingUp)
        .then(response => {
          // console.log(response);
          // Show Spinner ON Click
          this.show = false;
          this.$snotify.success(response.data.message, "Register", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "auth-login" });
        })
        .catch(error => {
          // console.log(error);
          this.errors = error.response.data.errors;
          // Hidden Spinner When Get Error
          this.show = false;
          this.$snotify.error(error.response.data.message, "Register", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
// Register Page Style
@import "../../assets/scss/auth/register";
</style>
