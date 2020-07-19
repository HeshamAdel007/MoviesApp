<template lang="pug" scoped>
.setting-page
  form(@submit.prevent="settingUpdate")
    <!-- Input Name -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="name") name
      .inputIcon.iconBg
        input#name.form-control(type="text" name="name" v-model="settingApp.name" autocomplete="name" placeholder="name" autofocus)
        i.fas.fa-user(aria-hidden="true")
      span(v-if="errors.name") {{ errors.name[0] }}
    <!-- Input Description -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="description") description
      .inputIcon.iconBg
        input#description.form-control(type="text" name="description" v-model="settingApp.description" autocomplete="description" placeholder="Description" autofocus)
        i.fas.fa-envelope(aria-hidden="true")
      span(v-if="errors.description") {{ errors.description[0] }}
    <!-- Input Email -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="email") email
      .inputIcon.iconBg
        input#email.form-control(type="email" name="email" v-model="settingApp.email" placeholder="email")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.email") {{ errors.email[0] }}
    <!-- Input Adress -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="adress") adress
      .inputIcon.iconBg
        input#adress.form-control(type="text" name="adress" v-model="settingApp.adress" placeholder="adress")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.adress") {{ errors.adress[0] }}
    <!-- Input Facebook -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="facebook") facebook
      .inputIcon.iconBg
        input#facebook.form-control(type="text" name="facebook" v-model="settingApp.facebook" autocomplete="facebook" placeholder="Efacebook" autofocus)
        i.fas.fa-envelope(aria-hidden="true")
      span(v-if="errors.facebook") {{ errors.facebook[0] }}
    <!-- Input Twitter -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="twitter") twitter
      .inputIcon.iconBg
        input#twitter.form-control(type="text" name="twitter" v-model="settingApp.twitter" placeholder="twitter")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.twitter") {{ errors.twitter[0] }}
    <!-- Input Instagram -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="instagram") instagram
      .inputIcon.iconBg
        input#instagram.form-control(type="text" name="instagram" v-model="settingApp.instagram" placeholder="instagram")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.instagram") {{ errors.instagram[0] }}
    <!-- Input Youtube -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="youtube") youtube
      .inputIcon.iconBg
        input#youtube.form-control(type="text" name="youtube" v-model="settingApp.youtube" placeholder="youtube")
        i.fas.fa-unlock-alt(aria-hidden="true")
      span(v-if="errors.youtube") {{ errors.youtube[0] }}
    <!-- Input Logo -->
    .input-container.inline-block(class="w-1/2")
      label.input-label(for="logo") logo
      .inputIcon.iconBg
        input#avatar.form-control(type="file" name="logo" v-on:change="handleImgUpload" enctype="multipart/form-data")
    <!-- Edit Button -->
    .input-container.text-center
      .form-btn
        button.btn.capitalize(type='submit')
          | update
          i.fas.fa-long-arrow-alt-right(aria-hidden="true")
        <!-- Spinner -->
        .absolute.top-0.left-8
          spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Setting",
  components: {
    Spinner,
  },
  data() {
    return {
      settingApp: {
        name: "",
        email: "",
        description: "",
        adress: "",
        facebook: "",
        twitter: "",
        instagram: "",
        logo: "",
        youtube: "",
      },
      errors: {},
      settingInfo: {},
      show: false,
    };
  },
  mounted() {
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userToken = localStorage.getItem("token");
    this.setting({ token: userToken })
      .then(response => {
        this.settingInfo = response.data.setting;
        // Data Return
        this.settingApp.name = this.settingInfo.name;
        this.settingApp.email = this.settingInfo.email;
        this.settingApp.description = this.settingInfo.description;
        this.settingApp.adress = this.settingInfo.adress;
        this.settingApp.facebook = this.settingInfo.facebook;
        this.settingApp.twitter = this.settingInfo.twitter;
        this.settingApp.instagram = this.settingInfo.instagram;
        this.settingApp.youtube = this.settingInfo.youtube;
      })
      .catch(error => {
        if (error) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Error!", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      setting: "setting_dash/appSetting",
      update: "setting_dash/updateSetting",
    }),
    handleImgUpload(event) {
      const files = event.target.files || event.dataTransfer.files;
      if (!files.length) {
        return;
      }
      this.createImage(files[0]);
    },
    createImage(file) {
      const reader = new FileReader();
      const vm = this;
      reader.onload = event => {
        vm.settingApp.logo = event.target.result;
      };
      reader.readAsDataURL(file);
    },
    settingUpdate() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const settingID = 1;
      const userToken = localStorage.getItem("token");
      this.show = true;
      this.update({
        id: settingID,
        token: userToken,
        ...this.settingApp,
      })
        .then(response => {
          this.show = false;
          this.$snotify.success(response.data.message, "Setting Edit", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-dashboard" });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.show = false;
          this.$snotify.error(error.response.data.message, "Setting Edit", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/scss/stage/helped/mixins";
@import "../../../assets/scss/stage/helped/variables";
// Input Style
@import "../../../assets/scss/stage/componed/form-input";
// Button Style
@import "../../../assets/scss/stage/componed/form-btn";

.setting-page {
  form {
    @extend .input-form;
    .inputIcon {
      margin-left: 5px;
      width: 30em;
    }
  }
}
</style>
