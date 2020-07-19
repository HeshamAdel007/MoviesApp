<template lang="pug" scoped>
  #app
    vue-snotify
    nav-bar
    nuxt
    app-footer
</template>

<script>
import NavBar from "@/components/user/globale/NavBar.vue";
import AppFooter from "@/components/user/globale/AppFooter.vue";

export default {
  name: "HomeApp",
  components: {
    NavBar,
    AppFooter,
  },
  head() {
    return {
      bodyAttrs: {
        class: "bg-gray-900 text-white",
      },
    };
  },
};
</script>
