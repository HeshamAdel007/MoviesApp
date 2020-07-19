<template lang="pug" scoped>
  .edit-page
    span.text-25 Edit Category [ {{ categoryInfo.name }} ]
    form(@submit.prevent="editCategory")
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="name") name
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="text" class="w-1/2" name="name" v-model="categoryEdit.name" placeholder="Category" autofocus)
      span.text-primary(v-if="errors.name") {{ errors.name[0] }}
      <!-- Sub Category -->
      .w-full.px-3.mb-6
        label.block.uppercase.tracking-wide.text-gray-700.text-xs.font-bold.mb-2(for='grid-state')
          | parent
        .relative(class="w-1/2")
          select#grid-state.block.appearance-none.bg-gray-200.border.border-gray-200.text-gray-700.py-3.px-4.pr-8.rounded.leading-tight(class='focus:outline-none focus:bg-white focus:border-gray-500' v-model="categoryEdit.parent_id")
            option select Role
            option(v-for="category in allCategory" name="parent_id" :value="category.id") {{ category.name }}
          .pointer-events-none.absolute.inset-y-0.right-0.flex.items-center.px-2.text-gray-700
            svg.fill-current.h-4.w-4(xmlns='http://www.w3.org/2000/svg' viewbox='0 0 20 20')
              path(d='M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z')
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
      categoryEdit: {
        name: "",
        parent_id: "",
      },
      categoryInfo: {},
      allCategory: {},
      errors: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const categoryID = this.$route.params.id;
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.categories({ id: categoryID, token: userToken })
      .then(response => {
        this.show = false;
        // console.log(response);
        this.categoryInfo = response.data.categories;
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
    this.getCategories({ token: userToken }).then(response => {
      // console.log(response);
      this.allCategory = response.data.data;
    });
  },
  methods: {
    ...mapActions({
      categories: "category/categoryEditInfo",
      getCategories: "category/categoryInfo",
      update: "category/updateCategory",
    }),
    editCategory() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const userID = this.$route.params.id;
      const userToken = localStorage.getItem("token");
      this.show = true;
      this.update({ id: userID, token: userToken, ...this.categoryEdit })
        .then(response => {
          this.show = false;
          this.$snotify.success(response.data.message, "Edit", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-category" });
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
.edit-page {
  .form-btn {
    @extend .form-btn;
  }
}
</style>
