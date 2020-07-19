import Vue from "vue";
import Snotify, { SnotifyPosition } from "vue-snotify";

const options = {
  toast: {
    position: SnotifyPosition.rightTop,
    timeout: 6000,
    titleMaxLength: 30,
    bodyMaxLength: 150,
    bold: false,
  },
};

Vue.use(Snotify, options);

export default Snotify;
