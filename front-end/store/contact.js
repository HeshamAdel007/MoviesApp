import axios from "../plugins/axios";

export const state = () => ({
  messages: {},
});

export const mutations = {
  SET_CONTACTINFO(state, payload) {
    state.messages = payload;
  },
};

export const actions = {
  /**
    // Contact Messages Info
    # Fetch  Contact Messages Info
  **/
  contactMsge(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/contact-us", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_CONTACTINFO", response.data.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Contact Messages Info

  /**
    # Show Contact Messages
  **/
  showContactMsge(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/contact-us/${params.id}?token=${params.token}`)
        .then(response => {
          ctx.commit("SET_CONTACTINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Show Contact Messages

  /**
    // Send Messages
  **/
  sendMessages(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("/contact-us/sendmsg", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Send Messages

  /**
    // Delete Messages
  **/
  deleteMessages(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/contact-us/delete/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Delete Messages
};
