import axios from "../plugins/axios";

export const state = () => ({
  tags: {},
});

export const mutations = {
  SET_TAGINFO(state, payload) {
    state.tags = payload;
  },
};

export const actions = {
  /**
    // Tag Info
    # Fetch user Tags Info
  **/
  tagInfo(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/tag", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_TAGINFO", response.data.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Tags Info

  /**
    // Tag Edit Page Info
    # Fetch This Tag Info
  **/
  tagEditInfo(ctx, params, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/tag/${params.id}?token=${params.token}`, payload)
        .then(response => {
          ctx.commit("SET_TAGINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Tag Edit Info

  /**
    // Create New Tag
  **/
  creatTag(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("admin/tag", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Create Tag

  /**
    // Update Tag Info
  **/
  updateTag(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/tag/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Update Tag

  /**
    // Delete Tags
  **/
  deleteTag(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/tag/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Delete Tags
};
