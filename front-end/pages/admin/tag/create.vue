<template lang="pug" scoped>
  .tagcreate-page
    span.text-25 Create Tag
    form(@submit.prevent="newTag")
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="name") name
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="text" class="w-1/2" name="name" v-model="tag.name" placeholder="Tag" autofocus)
      span.text-primary(v-if="errors.name") {{ errors.name[0] }}
      <!-- Create -->
      .form-btn
        button.btn(type='submit') Create
      spinner(v-if="show")
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Create",
  components: {
    Spinner,
  },
  data() {
    return {
      tag: {
        name: "",
      },
      errors: {},
      show: false,
    };
  },
  methods: {
    ...mapActions({
      addTag: "tag/creatTag",
    }),
    newTag() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const tokens = localStorage.getItem("token");
      this.show = true;
      this.addTag({ ...this.tag, token: tokens })
        .then(response => {
          // console.log(response);
          this.show = false;
          this.$snotify.success(response.data.message, "Create", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-tag" });
        })
        .catch(error => {
          // console.log(error.response);
          this.errors = error.response.data.errors;
          this.show = false;
          this.$snotify.error(error.response.data.message, "Create", {
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
.tagcreate-page {
  .form-btn {
    @extend .form-btn;
  }
}
</style>
