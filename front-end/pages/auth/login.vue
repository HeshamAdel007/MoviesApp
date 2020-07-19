<template lang="pug" scoped>
  .login-page.capitalize
    <!-- Page Overlay -->
    .overlay
    <!-- Page Image -->
    img(:src="loginBack.imagePath" :alt="loginBack.altImg")
    <!-- Page Container -->
    .container.w-full.px-15.mx-auto
    <!-- Form Login Container -->
      .login-container
        .login-body
          .row.flex.flex-wrap.w-full.h-full
            <!-- Form Imge -->
            .login-img
              img(:src="formImg.imagePath" :alt="formImg.altImg")
            <!-- Login Form -->
            .login-form
              <!-- Login Form Header -->
              .form-header
                ul.flex
                  nuxt-link.form-nav(to="/auth/login" tag="li")
                    a.nav-link login
                  span /
                  nuxt-link.form-nav(to="/auth/register" tag="li")
                    a.nav-link register
              .social-login
                button.fb-btn(@click="loginFacebook")
                  span Login with Facebook
              <!-- Form -->
              form(@submit.prevent="loginUser")
                <!-- Input E-Mail-->
                .input-container
                  label.input-label(for="email") e-mail
                  .inputIcon.iconBg
                    input#email.form-control(type="email" name="email" v-model="loginForm.email" autocomplete="email" placeholder="E-Mail" autofocus)
                    i.fas.fa-envelope(aria-hidden="true")
                  span(v-if="errors.email") {{ errors.email[0] }}
                <!-- Input PassWord-->
                .input-container
                  label.input-label(for="password") password
                  .inputIcon.iconBg
                    input#password.form-control(type="password" name="password" v-model="loginForm.password" autocomplete="current-password" placeholder="Password")
                    i.fas.fa-unlock-alt(aria-hidden="true")
                  span(v-if="errors.password") {{ errors.password[0] }}
                <!-- Login Button -->
                .input-container.text-center
                  .form-btn
                    button.btn.capitalize(type='submit')
                      |login
                      i.fas.fa-long-arrow-alt-right(aria-hidden="true")
                  <!-- Forgot Link-->
                  .link-forgot
                    nuxt-link(to="/auth/password/forgot") forgot your password?
              <!-- Spinner -->
              spinner(v-if="show")

</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../components/loading/Spinner.vue";

export default {
  name: "Login",
  components: {
    Spinner,
  },
  data() {
    return {
      loginForm: {
        email: "",
        password: "",
      },
      errors: {},
      loginBack: {
        imagePath: require("../../static/image/bg-03.jpg"),
        altImg: "Login Page Background Img",
      },
      formImg: {
        imagePath: require("../../static/image/bg-02.jpg"),
        altImg: "Login Form Img",
      },
      show: false,
    };
  },
  methods: {
    ...mapActions({
      login: "auth/loginUser",
      facebookLogin: "auth/socialLoginRedirect",
    }),
    loginUser() {
      // Icon Image Snotify
      const iconSuccess = require("../../static/image/snotify_icon/login.png");
      const iconError = require("../../static/image/snotify_icon/warning.png");
      // Show Spinner ON Click
      this.show = true;
      this.login(this.loginForm)
        .then(response => {
          // Hidden Spinner When Get Response
          this.show = false;
          this.$snotify.success(response.data.message, "Login", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-dashboard" });
        })
        .catch(error => {
          // Hidden Spinner When Get Error
          this.show = false;
          this.errors = error.response.data.errors;
          if (error.response.status === 422) {
            this.$snotify.error("Check Your E-Mail and Password", "Login", {
              icon: iconError,
            });
          } else if (error.response.status === 400) {
            this.$snotify.error(error.response.data.message, "Login", {
              icon: iconError,
            });
            this.$router.push({ name: "auth-email-resendverify" });
          } else {
            this.$snotify.error(error.response.data.error, "Login", {
              icon: iconError,
            });
          }
        });
    },
    loginFacebook() {
      this.show = true;
      this.facebookLogin().then(response => {
        if (response.data.url) {
          // console.log(response.data.url);
          window.location.href = response.data.url;
          this.show = false;
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
// Login Page Style
@import "../../assets/scss/auth/login";
</style>
