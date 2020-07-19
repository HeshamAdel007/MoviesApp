<template lang="pug" scoped>
  .dashboard-nav
    <!-- Admin -->
    .admin.flex.inline-block.mr-4.cursor-pointer
      button.logout(@click="loggedout")
        span.text-white.font-primary_font.text-16.font-semibold.ml-1.p-1 logout
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "NavBar",
  data() {
    return {
      adminImg: {
        imagePath: require("../../../static/image/admin/hesham.jpg"),
        altImg: "Admin Name",
      },
      admin: "",
      info: {},
      isDropDown: false,
    };
  },
  methods: {
    ...mapActions({
      exit: "auth/logoutUser",
    }),
    loggedout() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      this.exit();
      this.$snotify.success("LoggedOut Is Successfully", "LoginOut", {
        icon: iconSuccess,
      });
      this.$router.push({ name: "index" });
    },
  },
};
</script>

<style lang="scss" scoped>
.dashboard-nav {
  .admin {
    .logout {
      line-height: 3;
    }
  }
}
</style>
