<template lang="pug">
  .email-verify-page.capitalize
    <!-- Page Overlay -->
    .overlay
    <!-- Page Image -->
    img(:src="verifyBack.backGroundImg" :alt="verifyBack.altImg")
    <!-- Page Container -->
    .container
      .verify-container
        .verify-body
          .veriyfy-card.text-center
            .veriyfy-head
              span.title e-mail verification
            .veriyfy-info
              .veriyfy-check(v-if="verifyMessage == ''")
                spinner
              .verify-msg(v-if="verifyMessage != ''")
                p.msg-content {{ verifyMessage }}
                .input-container.text-center
                  .form-btn
                    nuxt-link.verify-link(to="/auth/login")
                      button.btn.capitalize(type='submit') login
                        i.fas.fa-long-arrow-alt-right(aria-hidden="true")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  name: "Verification",
  components: {
    Spinner,
  },
  data() {
    return {
      verifyMessage: "",
      verifyBack: {
        backGroundImg: require("../../../static/image/bg-03.jpg"),
        altImg: "E-Mail Verify Page Background Img",
      },
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    this.verifyEmail(this.$route.query)
      .then(response => {
        this.verifyMessage = response.data.message;
        this.$snotify.success(response.data.message, "E-Mail Verified", {
          icon: iconSuccess,
        });
      })
      .catch(error => {
        this.verifyMessage = error.response.data.message;
        this.$snotify.error(error.response.data.message, "E-Mail Verified", {
          icon: iconError,
        });
      });
    // console.log(this.$route.query);
  },
  methods: {
    ...mapActions({
      verifyEmail: "auth/verifyEmail",
    }),
  },
};
</script>

<style lang="scss" scoped>
// E-Mail Verify Page Style
@import "../../../assets/scss/auth/email/verification";
</style>
