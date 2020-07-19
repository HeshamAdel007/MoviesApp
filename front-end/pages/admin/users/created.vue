<template lang="pug" scoped>
  .create-page
    span.text-25 Create Admin
    form(@submit.prevent="newAdmin")
      <!-- Name -->
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="name") name
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="text" class="w-1/2" name="name" v-model="admin.name" autocomplete="name" placeholder="UserName" autofocus)
      span.text-primary(v-if="errors.name") {{ errors.name[0] }}
      <!-- Email -->
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="email") e-mail
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="email" class="w-1/2" name="email" v-model="admin.email" autocomplete="email" placeholder="E-Mail" autofocus)
      span.text-primary(v-if="errors.email") {{ errors.email[0] }}
      <!-- Password -->
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="password") password
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="password" class="w-1/2" name="password" v-model="admin.password" autocomplete="current-password" placeholder="Password")
      span.text-primary(v-if="errors.password") {{ errors.password[0] }}
      <!--- Password Confirmation -->
      label.block.text-gray-700.text-sm.font-bold.mb-2.px-3(for="password") password confirmation
      input.bg-white.border.border-gray-300.rounded-lg.py-2.px-4.block.appearance-none.leading-normal(type="password" class="w-1/2" name="password_confirmation" v-model="admin.password_confirmation" autocomplete="new-password" placeholder="password Confirmation")
      span.text-primary(v-if="errors.password") {{ errors.password[1] }}
      <!-- Roles -->
      .w-full.px-3.mb-6
        label.block.uppercase.tracking-wide.text-gray-700.text-xs.font-bold.mb-2(for='grid-state')
          | role
        .relative(class="w-1/2")
          select#grid-state.block.appearance-none.bg-gray-200.border.border-gray-200.text-gray-700.py-3.px-4.pr-8.rounded.leading-tight(class='focus:outline-none focus:bg-white focus:border-gray-500' v-model="admin.role")
            option select Role
            option(v-for="role in userRole" name="role[]" :value="role.id") {{ role.name }}
          .pointer-events-none.absolute.inset-y-0.right-0.flex.items-center.px-2.text-gray-700
            svg.fill-current.h-4.w-4(xmlns='http://www.w3.org/2000/svg' viewbox='0 0 20 20')
              path(d='M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z')
        span.text-primary(v-if="errors.role") {{ errors.role[0] }}
      <!-- user Permissions -->
        .border.transition-all.duration-500.relative.rounded.p-1(class='focus-within:border-blue-500 focus-within:text-blue-500')
          .-mt-4.absolute.tracking-wider.px-1.uppercase.text-xs
            p
              .bg-white.text-gray-600.px-1 permissions *
          .permissions.inline-block.p-4(v-for="(permission, index) in userPermissions" :key="index" )
            .bg-white.border-2.rounded.border-gray-400.inline-block.w-6.h-6.flex-shrink-0.justify-center.items-center.mr-2(class="focus-within:border-blue-500")
              input(type="checkbox" :id="permission.name" name="permissions[]" v-model="admin.permissions" class="opacity-0 absolute" :value="permission.id")
              svg.fill-current.hidden.w-4.h-4.text-green-500.pointer-events-none(viewBox="0 0 20 20")
                path(d="M0 11l2-2 5 5L18 3l2 2L7 18z")
            label(:for="permission.name") {{ permission.display_name }}
          span.text-primary(v-if="errors.permissions") {{ errors.permissions[0] }}

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
      userRole: {},
      userPermissions: {},
      admin: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        role: [],
        permissions: [],
      },
      errors: {},
      show: false,
    };
  },
  mounted() {
    const tokens = localStorage.getItem("token");
    this.roles({ token: tokens }).then(response => {
      this.userRole = response.data.roles;
      this.userPermissions = response.data.permissions;
    });
  },
  methods: {
    ...mapActions({
      roles: "user/adminRole",
      addUser: "user/creatUser",
    }),
    newAdmin() {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const tokens = localStorage.getItem("token");
      this.show = true;
      this.addUser({ ...this.admin, token: tokens })
        .then(response => {
          // console.log(response);
          this.show = false;
          this.$snotify.success(response.data.message, "Create", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-users" });
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
input:checked + svg {
  display: block;
}
.permissions {
  label {
    display: inline-block;
    position: relative;
    bottom: 6px;
    margin-right: 10px;
  }
}
.create-page {
  .form-btn {
    @extend .form-btn;
  }
}
</style>
