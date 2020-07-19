<template lang="pug" scoped>
  .dashboard-sidebar.capitalize
    <!-- SideBar App Info -->
    .brand
      .logo
        img(:src="settingApp.logo" :alt="settingApp.name")
      .app-name
        span {{ settingApp.name }}
    <!-- SideBar Admin Info -->
    .admin-info
      .img
        img(:src="userInfo.avatar" :alt="userInfo.nickname")
      .name
        span {{ userInfo.nickname }}
    <!-- SideBar Links -->
    sidebar-links
      ul
        nuxt-link.user-link(to="/admin/dashboard" tag="li")
          a.link dashboard
        nuxt-link.user-link(to="/admin/post" tag="li")
          a.link post
        nuxt-link.user-link(to="/admin/category" tag="li")
          a.link category
        nuxt-link.user-link(to="/admin/tag" tag="li")
          a.link tag
        nuxt-link.user-link(to="/admin/actor" tag="li")
          a.link actors
        nuxt-link.user-link(to="/admin/users" tag="li")
          a.link admin
        nuxt-link.user-link(to="/admin/contact" tag="li")
          a.link contact
        nuxt-link.user-link(:to="{name: 'admin-profile-id', params: {id: admin}}" tag="li")
          a.link profile
        nuxt-link.user-link(to="/admin/setting" tag="li")
          a.link settings
</template>

<script>
import { mapActions } from "vuex";

export default {
  layout: "adminpanel",
  name: "SideBar",
  data() {
    return {
      userInfo: {},
      settingApp: {},
      admin: "",
      adminImg: {
        imagePath: require("../../../static/image/admin/hesham.jpg"),
        altImg: "Logo",
      },
    };
  },
  mounted() {
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userID = localStorage.getItem("adminID");
    const userToken = localStorage.getItem("token");
    this.admin = userID;
    this.profile({ id: userID, token: userToken })
      .then(response => {
        this.userInfo = response.data.profile;
      })
      .catch(error => {
        // console.log(error.response);
        if (error) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Error!", {
            icon: iconError,
          });
        }
      });
    this.setting({ token: userToken })
      .then(response => {
        this.settingApp = response.data.setting;
      })
      .catch(error => {
        // console.log(error.response);
        if (error) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Error!", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      profile: "user/userProfile",
      setting: "setting_dash/appSetting",
    }),
  },
};
</script>
