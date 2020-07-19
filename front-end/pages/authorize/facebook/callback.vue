<template lang="pug" scoped>
  .social-login-page
    .overlay
    <!-- Page Image -->
    img(:src="pageImg.imagePath" :alt="pageImg.altImg")
    .container
      .social-container
        .social-body
          .social-card.text-center
            .social-msg
              span Login with FaceBook, please wait!
            <!-- Spinner -->
            spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  name: "CallBack",
  components: {
    Spinner,
  },
  data() {
    return {
      pageImg: {
        imagePath: require("../../../static/image/bg-03.jpg"),
        altImg: "Login With FaceBook Page ",
      },
      show: false,
    };
  },
  mounted() {
    this.socialLogin();
  },
  methods: {
    ...mapActions({
      loginFace: "auth/socialLoginCallback",
    }),
    socialLogin() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/login.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      this.show = true;
      this.loginFace({ code: this.$route.query.code })
        .then(response => {
          if (response.data.access_token) {
            // console.log(response.data);
            // Hidden Spinner When Get Response
            this.show = false;
            this.$snotify.success(response.data.message, "Login", {
              icon: iconSuccess,
            });
            this.$router.push({ name: "admin-dashboard" });
          }
        })
        .catch(error => {
          // console.log(error.response.data);
          // Hidden Spinner When Get Response
          this.show = false;
          this.$snotify.error(error.response.data.message, "Login", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
//  Page Style
@import "../../../assets/scss/auth/social-login";
</style>
