<template lang="pug" scoped>
.contact-us
  <!-- Contact-Us -->
  h2.text-center Contact Us
  .info
    p.text-white
      | Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words
  <!-- Form -->
  .msg.border-b.border-gray-800
    .msg-form
      .flex.mx-auto.items-center.justify-center.shadow-lg.mt-56.mx-8.mb-4.max-w-lg
      form.w-full.max-w-xl.rounded-lg.px-4.pt-2(@submit.prevent="sendNewMsg")
        h2.px-4.pt-3.pb-2.text-white.text-lg Add a new comment
        <!-- Name -->
        .w-64
          input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='text' name='name', placeholder='Type Your Name', required='' v-model="msgForm.name")
        <!-- E-mail -->
        .w-64
          input.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.py-2.px-3.font-medium.placeholder-gray-700(type='email' name='email', placeholder='Type Your E-mail', required='' v-model="msgForm.email")
        <!-- Message -->
        .w-full.px-3.mb-2.mt-2(class='md:w-full')
          textarea.bg-gray-900.text-white.rounded.border.border-gray-400.leading-normal.resize-none.w-full.h-20.py-2.px-3.font-medium.placeholder-gray-700(type='text' name='message', placeholder='Type Your message', required='' v-model="msgForm.message")
          .-mr-1
            button.bg-white.text-gray-700.font-medium.py-1.px-4.border.border-gray-400.rounded-lg.tracking-wide.mr-1(type='submit', class='hover:bg-gray-100') Send Msge
          <!-- Spinner -->
          .spin
            spinner(v-if="show")
    <!-- End Form -->
  <!-- End Contact-Us -->
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../components/loading/Spinner.vue";

export default {
  layout: "homeapp",
  name: "Contactus",
  components: {
    Spinner,
  },
  data() {
    return {
      msgForm: {
        name: "",
        email: "",
        message: "",
      },
      errors: {},
      show: false,
    };
  },
  methods: {
    ...mapActions({
      infoMsgSend: "contact/sendMessages",
    }),
    sendNewMsg() {
      // Icon Image Snotify
      const iconSuccess = require("../../static/image/snotify_icon/double-tick.png");
      const iconError = require("../../static/image/snotify_icon/warning.png");
      this.show = true;
      this.infoMsgSend(this.msgForm)
        .then(response => {
          this.show = false;
          this.$snotify.success(response.data.message, "Message", {
            icon: iconSuccess,
          });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.show = false;
          this.$snotify.error(error.response.data.message, "Message", {
            icon: iconError,
          });
        });
    },
  },
};
</script>
