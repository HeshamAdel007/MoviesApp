<template lang="pug" scoped>
.user-page
  .text-gray-900.bg-gray-200
  .p-4.flex
    h1.text-3xl
      | Users
  nuxt-link(to="/admin/users/created")
    button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') create
  .px-3.py-4.flex.justify-center
    table.w-full.text-md.bg-white.shadow-md.rounded.mb-4
      tbody
        tr.border-b
          th.text-left.p-3.px-5 #
          th.text-left.p-3.px-5 img
          th.text-left.p-3.px-5 Name
          th.text-left.p-3.px-5 Email
          th.text-left.p-3.px-5 Role
          th Actions
        <!-- Spinner -->
        .spin
          spinner(v-if="show")
        tr.border-b.bg-gray-100(v-for="(user, index) in usersInfo" :key="index" class='hover:bg-orange-100')
          td.p-3.px-5
            .bg-transparent {{ index+1 }}
          td.p-3.px-5
            .bg-transparent {{ user.id }}
          td.p-3.px-5
            .bg-transparent {{ user.name }}
          td.p-3.px-5
            .bg-transparent {{ user.email }}
          td.p-3.px-5
            span.bg-transparent {{ user.role.name }}
          td.p-3.px-5.flex.justify-end
            button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') view
            nuxt-link(:to="{name: 'admin-users-id', params: {id: user.id}}")
              button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') edit
            button.text-sm.bg-red-500.text-white.py-1.px-2.rounded(@click="deleteUsers(user.id)" class='hover:bg-red-700 focus:outline-none focus:shadow-outline') delete
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Users",
  components: {
    Spinner,
  },
  data() {
    return {
      usersInfo: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.admin({ token: userToken })
      .then(response => {
        this.show = false;
        this.usersInfo = response.data.data;
      })
      .catch(error => {
        this.show = false;
        // console.log(error.response);
        if (error.response.status === 500) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Admins", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      admin: "user/userInfo",
      adminDelete: "user/deleteUser",
    }),
    deleteUsers(id) {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const userId = id;
      const userToken = localStorage.getItem("token");
      this.adminDelete({ id: userId, token: userToken })
        .then(response => {
          this.$snotify.success(response.data.message, "Delete", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-dashboard" });
        })
        .catch(error => {
          // console.log(error.response);
          if (error.response.status === 500) {
            this.$snotify.error("Can't Delete Admin Please Try Again Later", "Delete", {
              icon: iconError,
            });
          }
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.user-page {
  .spin {
    position: relative;
    left: 27em;
  }
}
</style>
