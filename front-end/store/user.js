import axios from "../plugins/axios";

export const state = () => ({
  userDetails: {},
  userRole: {},
  userEdit: {},
});

export const mutations = {
  SET_USERINFO(state, payload) {
    state.userDetails = payload;
  },
  SET_USEREDIT(state, payload) {
    state.userEdit = payload;
  },
  SET_USEREDITROLE(state, payload) {
    state.userRole = payload;
  },
};

export const actions = {
  /**
    // User Info
    # Fetch user User Info
  **/
  userInfo(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/user", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_USERINFO", response.data.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Info

  /**
    // User Edit Page Info
    # Fetch This User Info & Role
  **/
  userEditInfo(ctx, params, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/user/${params.id}?token=${params.token}`, payload)
        .then(response => {
          ctx.commit("SET_USEREDIT", response.data.users);
          ctx.commit("SET_USEREDITROLE", response.data.roles);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Edit Info

  /**
    // Create New User
  **/
  creatUser(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("admin/user", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Create User

  /**
    // Update User Info
  **/
  updateUser(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/user/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Update User

  /**
    // Delete User
  **/
  deleteUser(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/user/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Delete User

  /**
    // User Roles
    # Fetch Role
  **/
  adminRole(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/roles", { params: payload })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Role

  /**
    // User Profile
  **/
  userProfile(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/profile/${payload.id}?token=${payload.token}`)
        .then(response => {
          ctx.commit("SET_USERINFO", response.data.profile);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Profile

  /**
    // Update User Profile
  **/
  updateProfile(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/profile/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Update User Profile
};
