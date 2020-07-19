<template lang="pug" scoped>
  .tagid-page
    span.text-25 Edit Tag [ {{ tagInfo.name }} ]
    form(@submit.prevent="editTag")
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="name") name
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="text" class="w-1/2" name="name" v-model="tagEdit.name" placeholder="Tag" autofocus)
      span.text-primary(v-if="errors.name") {{ errors.name[0] }}
      <!-- Update -->
      .form-btn
        button.btn(type='submit') update
      spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Id",
  components: {
    Spinner,
  },
  data() {
    return {
      tagEdit: {
        name: "",
      },
      tagInfo: {},
      errors: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const tagID = this.$route.params.id;
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.tags({ id: tagID, token: userToken })
      .then(response => {
        this.show = false;
        // console.log(response.data.tags.name);
        this.tagInfo = response.data.tags;
      })
      .catch(error => {
        // console.log(error.response);
        this.show = false;
        if (error.response.status === 500) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Edit", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      tags: "tag/tagEditInfo",
      update: "tag/updateTag",
    }),
    editTag() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const userID = this.$route.params.id;
      const userToken = localStorage.getItem("token");
      this.show = true;
      this.update({ id: userID, token: userToken, ...this.tagEdit })
        .then(response => {
          this.show = false;
          this.$snotify.success(response.data.message, "Edit", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-tag" });
        })
        .catch(error => {
          // console.log(error.response);
          this.errors = error.response.data.errors;
          this.show = false;
          this.$snotify.error(error.response.data.message, "Edit", {
            icon: iconError,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/scss/stage/helped/variables";
@import "../../../assets/scss/stage/helped/mixins";
// Button Style
@import "../../../assets/scss/stage/componed/form-btn";
.tagid-page {
  .form-btn {
    @extend .form-btn;
  }
}
</style>
