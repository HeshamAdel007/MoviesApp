import axios from "../plugins/axios";

export const state = () => ({
  categories: {},
});

export const mutations = {
  SET_CATEGORYINFO(state, payload) {
    state.categories = payload;
  },
};

export const actions = {
  /**
    // Category Info
    # Fetch user Category Info
  **/
  categoryInfo(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/category", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_CATEGORYINFO", response.data.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Category Info

  /**
    // Category Edit Page Info
    # Fetch This Category Info
  **/
  categoryEditInfo(ctx, params, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/category/${params.id}?token=${params.token}`, payload)
        .then(response => {
          ctx.commit("SET_CATEGORYINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Category Edit Info

  /**
    // Create New Category
  **/
  creatCategory(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("admin/category", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Create Category

  /**
    // Update Category Info
  **/
  updateCategory(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/category/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Update Category

  /**
    // Delete Category
  **/
  deleteCategory(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/category/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Delete Category
};
