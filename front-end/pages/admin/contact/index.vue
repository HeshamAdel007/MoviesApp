<template lang="pug" scoped>
  .message-page
    .text-gray-900.bg-gray-200
    .p-4.flex
      h1.text-3xl
        | messages
    .px-3.py-4.flex.justify-center
      table.w-full.text-md.bg-white.shadow-md.rounded.mb-4
        tbody
          tr.border-b
            th.text-left.p-3.px-5 #
            th.text-left.p-3.px-5 Name
            th.text-left.p-3.px-5 E-Mail
            th Actions
          <!-- Spinner -->
          .spin
            spinner(v-if="show")
          tr.border-b.bg-gray-100(v-for="(msg, index) in contactInfo" :key="index" class='hover:bg-orange-100')
            td.p-3.px-5
              .bg-transparent {{ msg.index }}
            td.p-3.px-5
              .bg-transparent {{ msg.name }}
            td.p-3.px-5
              .bg-transparent {{ msg.email }}
            td.p-3.px-5.flex.justify-end
              nuxt-link(:to="{name: 'admin-contact-id', params: {id: msg.id}}")
                button.mr-3.text-sm.bg-blue-500.text-white.py-1.px-2.rounded(type='button' class='hover:bg-blue-700 focus:outline-none focus:shadow-outline') show
              button.text-sm.bg-red-500.text-white.py-1.px-2.rounded(@click="msgsDelete(msg.id)" class='hover:bg-red-700 focus:outline-none focus:shadow-outline') delete
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../../components/loading/Spinner.vue";

export default {
  layout: "adminpanel",
  name: "Contact",
  components: {
    Spinner,
  },
  data() {
    return {
      contactInfo: {},
      show: false,
    };
  },
  mounted() {
    // Icon Image Snotify
    const iconError = require("../../../static/image/snotify_icon/warning.png");
    const userToken = localStorage.getItem("token");
    this.show = true;
    this.msg({ token: userToken })
      .then(response => {
        this.show = false;
        this.contactInfo = response.data.contact;
      })
      .catch(error => {
        this.show = false;
        if (error.response.status === 500) {
          this.$snotify.error("Can't Featch Property Please Try Again Later", "Actorss", {
            icon: iconError,
          });
        }
      });
  },
  methods: {
    ...mapActions({
      msg: "contact/contactMsge",
      msgDelete: "contact/deleteMessages",
    }),
    msgsDelete(id) {
      // Icon Image Snotify
      const iconSuccess = require("../../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../../static/image/snotify_icon/warning.png");
      const msgId = id;
      const userToken = localStorage.getItem("token");
      this.msgDelete({ id: msgId, token: userToken })
        .then(response => {
          this.$snotify.success(response.data.message, "Delete", {
            icon: iconSuccess,
          });
          this.$router.push({ name: "admin-dashboard" });
        })
        .catch(error => {
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
