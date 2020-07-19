import axios from "../plugins/axios";

export const state = () => ({
  dashboard: {},
  settings: {},
});

export const mutations = {
  SET_DASHBOARD(state, payload) {
    state.dashboard = payload;
  },
  SET_SETTING(state, payload) {
    state.settings = payload;
  },
};

export const actions = {
  /**
    // App Info
    # Fetch App Info
  **/
  appDashboard(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/dashboard", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_DASHBOARD", response.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End App Info

  /**
    // App Setting
    # Fetch App Setting
  **/
  appSetting(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/setting/1", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_SETTING", response.data.setting);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End App Setting

  /**
    // Edit App Settings
  **/
  updateSetting(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/setting/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // Edit App Settings
};
