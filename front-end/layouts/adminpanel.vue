<template lang="pug" scoped>
  #dashboard
    vue-snotify
    .dashboardpanel.capitalize
      <!-- Dahsboard SideBar -->
      .sidebar(:class="{ close_sidebar: isCloseSideBar }")
        <!-- SideBar Component -->
        side-bar
      <!-- Dahsboard NavBar -->
      .content-area(:class="{ close_sidebar: isCloseSideBar }")
        <!-- NavBar Toggler -->
        .main-nav
          i.fas.fa-bars.fa-lg(@click="isCloseSideBar = !isCloseSideBar")
          <!-- Navegations -->
          .navegat
            <!-- NavBar Component -->
            nav-bars
        .content
          nuxt
</template>

<script>
import SideBar from "../components/dashboard/global/SideBar.vue";
import NavBars from "../components/dashboard/global/NavBars.vue";

export default {
  components: {
    SideBar,
    NavBars,
  },
  data() {
    return {
      isCloseSideBar: false,
    };
  },
};
</script>
