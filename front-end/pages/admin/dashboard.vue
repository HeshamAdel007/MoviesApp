<template lang="pug" scoped>
  .dashboard-page
    .flex.flex-wrap.mb-2.w-full
      .w-full.pt-3.px-3(class='md:w-1/2 xl:w-1/3 md:pr-2')
        .bg-green-600.border.rounded.shadow.p-2
          .flex.flex-row.items-center
            .flex-shrink.pl-1.pr-4
              i.fa.fa-wallet.fa-2x.fa-fw.fa-inverse
            .flex-1.text-right
              h5.text-white Total Admin
              h3.text-white.text-3xl
                | {{ dashboardInfo.user }}
                span.text-green-400
                  i.fas.fa-caret-down
      .w-full.pt-3.px-3(class='md:w-1/2 xl:w-1/3 md:pl-2')
        .bg-blue-600.border.rounded.shadow.p-2
          .flex.flex-row.items-center
            .flex-shrink.pl-1.pr-4
              i.fas.fa-users.fa-2x.fa-fw.fa-inverse
            .flex-1.text-right
              h5.text-white Total Post
              h3.text-white.text-3xl
                | {{ dashboardInfo.post }}
                span.text-blue-400
                  i.fas.fa-caret-up
      .w-full.pt-3.px-3(class='md:w-1/2 xl:w-1/3 md:pr-2 xl:pr-3 xl:pl-1')
        .bg-orange-600.border.rounded.shadow.p-2
          .flex.flex-row.items-center
            .flex-shrink.pl-1.pr-4
              i.fas.fa-user-plus.fa-2x.fa-fw.fa-inverse
            .flex-1.text-right.pr-1
              h5.text-white Total Category
              h3.text-white.text-3xl
                | {{ dashboardInfo.category }}
                span.text-orange-400
                  i.fas.fa-caret-up
      .w-full.pt-3.px-3(class='md:w-1/2 xl:w-1/3 md:pl-2 xl:pl-3 xl:pr-2')
        .bg-purple-600.border.rounded.shadow.p-2
          .flex.flex-row.items-center
            .flex-shrink.pl-1.pr-4
              i.fas.fa-server.fa-2x.fa-fw.fa-inverse
            .flex-1.text-right
              h5.text-white Total Tag
              h3.text-white.text-3xl {{ dashboardInfo.tag }}
      .w-full.pt-3.px-3(class='md:w-1/2 xl:w-1/3 md:pr-2 xl:pl-2 xl:pr-3')
        .bg-red-600.border.rounded.shadow.p-2
          .flex.flex-row.items-center
            .flex-shrink.pl-1.pr-4
              i.fas.fa-tasks.fa-2x.fa-fw.fa-inverse
            .flex-1.text-right
              h5.text-white Total
              h3.text-white.text-3xl 00000
      .w-full.pt-3.px-3(class='md:w-1/2 xl:w-1/3 md:pl-2 xl:pl-1')
        .bg-pink-600.border.rounded.shadow.p-2
          .flex.flex-row.items-center
            .flex-shrink.pl-1.pr-4
              i.fas.fa-inbox.fa-2x.fa-fw.fa-inverse
            .flex-1.text-right
              h5.text-white Total
              h3.text-white.text-3xl
                | 00000
                span.text-pink-400
                  i.fas.fa-caret-up
    spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Dashboard",
  components: {
    Spinner,
  },
  data() {
    return {
      dashboardInfo: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../static/image/snotify_icon/warning.png");
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.info({ token: userToken })
      .then(response => {
        this.show = false;
        this.dashboardInfo = response.data;
      })
      .catch(error => {
        this.show = false;
        if (error.response.status === 500) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Dashboard", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      info: "setting_dash/appDashboard",
    }),
  },
};
</script>
