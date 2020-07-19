<template lang="pug" scoped>
  .actorid-page
    .p-4.flex
      h1.text-3xl
        | Edit Post
    form(@submit.prevent="editActor")
      .bg-white.shadow.rounded-lg.p-6
        .grid.gap-6(class='lg:grid-cols-2')
            <!-- Actor Name -->
            .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
              .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
                p
                  label.bg-white.text-gray-600.px-1(for='name') name *
              p
                input#name.py-1.px-1.text-gray-900.outline-none.block.h-full.w-full(autocomplete='false' tabindex='0' v-model="actor.name" name="name" type='text')
              span.text-primary(v-if="errors.name") {{ errors.name[0] }}
            <!-- Actor Description -->
            .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
              .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
                p
                  label.bg-white.text-gray-600.px-1(for='description') description *
              p
                textarea#description.py-1.px-1.outline-none.block.h-64.w-full(type="text" name="description" v-model="actor.description")
              span.text-primary(v-if="errors.description") {{ errors.description[0] }}
            <!-- Post Photo -->
            .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
              .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
                p
                  label.bg-white.text-gray-600.px-1(for='photo') photo *
              input#photo.p-4(type="file" name="photo" v-on:change="handleImgUpload" enctype="multipart/form-data")
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
  name: "ActorEdit",
  components: {
    Spinner,
  },
  data() {
    return {
      actor: {
        name: "",
        photo: "",
        description: "",
      },
      actorInfo: {},
      errors: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const actorID = this.$route.params.id;
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.actors({ id: actorID, token: userToken })
      .then(response => {
        this.show = false;
        this.actorInfo = response.data.actor;
        // Data Return
        this.actor.name = this.actorInfo.name;
        this.actor.description = this.actorInfo.description;
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
      actors: "actor/actorEditInfo",
      update: "actor/updateActor",
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
        vm.actor.photo = event.target.result;
      };
      reader.readAsDataURL(file);
    },
    editActor() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const actorID = this.$route.params.id;
      const userToken = localStorage.getItem("token");
      this.show = true;
      this.update({ id: actorID, token: userToken, ...this.actor })
        .then(response => {
          this.show = false;
          this.$snotify.success(response.data.message, "Edit", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-actor" });
        })
        .catch(error => {
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

input:checked + svg {
  display: block;
}
.actorid-page {
  .form-btn {
    @extend .form-btn;
  }
}
</style>
