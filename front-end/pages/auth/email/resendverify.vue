<template lang="pug" scoped>
  .resendverify-page.capitalize
    <!-- Page Overlay -->
    .overlay
    <!-- Page Image -->
    img(:src="verifyBack.imagePath" :alt="verifyBack.altImg")
    <!-- Page Container -->
    .container.w-full.px-15.mx-auto
    <!-- Resend E-Mail Verify Container -->
      .resendverify-container
        .resendverify-body
          .row.flex.flex-wrap.w-full.h-full
            <!-- Resend E-Mail Verify Imge -->
            .resendverify-img
              img(:src="formImg.imagePath" :alt="formImg.altImg")
            <!-- Resend E-Mail Verify Form -->
            .resendverify-form
              <!-- Resend E-Mail Verify Form Header -->
              .form-header
                ul.flex
                  nuxt-link.form-nav(to="/auth/email/resend-verify" tag="li")
                    a.nav-link resend e-mail verify
              <!-- Form -->
              form(@submit.prevent="resendVerifyEmail")
                <!-- Input E-Mail-->
                .input-container
                  label.input-label(for="email") e-mail
                  .inputIcon.iconBg
                    input#email.form-control(type="email" name="email" v-model="verifyForm.email" autocomplete="email" placeholder="E-Mail" autofocus)
                    i.fas.fa-envelope(aria-hidden="true")
                  span(v-if="errors.email") {{ errors.email[0] }}
                <!-- Resend E-Mail Verify Button -->
                .input-container.text-center
                  .form-btn
                    button.btn.capitalize(type='submit')
                      |send verify link
                      i.fas.fa-long-arrow-alt-right(aria-hidden="true")
              spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  name: "ResendVerify",
  components: {
    Spinner,
  },
  data() {
    return {
      verifyForm: {
        email: "",
      },
      errors: {},
      verifyBack: {
        imagePath: require("../../../static/image/bg-03.jpg"),
        altImg: "Resend E-Mail Verify Page Background Img",
      },
      formImg: {
        imagePath: require("../../../static/image/bg-02.jpg"),
        altImg: "Resend E-Mail Verify Form Img",
      },
      show: false,
    };
  },
  methods: {
    ...mapActions({
      resendVerify: "auth/resendVerifyEmail",
    }),
    resendVerifyEmail() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/email.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      // Show Spinner ON Click
      this.show = true;
      this.resendVerify(this.verifyForm)
        .then(response => {
          // console.log(response.data.message);
          // Hidden Spinner When Get Response
          this.show = false;
          this.$snotify.success(response.data.message, "Resend E-Mail Verify", {
            icon: iconSuccess,
          });
        })
        .catch(error => {
          // console.log(error.response.data.message);
          this.errors = error.response.data.errors;
          // Hidden Spinner When Get Error
          this.show = false;
          this.$snotify.error(error.response.data.message, "Resend E-Mail Verify", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
// Resend E-Mail Verify Page Style
@import "../../../assets/scss/auth/email/resend-verify";
</style>
