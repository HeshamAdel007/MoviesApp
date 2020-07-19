import axios from "../plugins/axios";

export const state = () => ({
  actors: {},
});

export const mutations = {
  SET_ACTORINFO(state, payload) {
    state.actors = payload;
  },
};

export const actions = {
  /**
    // actor Info
    # Fetch user actors Info
  **/
  actorInfo(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/actor", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_ACTORINFO", response.data.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End actors Info

  /**
    // actor Edit Page Info
    # Fetch This actor Info
  **/
  actorEditInfo(ctx, params, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/actor/${params.id}?token=${params.token}`, payload)
        .then(response => {
          ctx.commit("SET_ACTORINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End actor Edit Info

  /**
    // Create New actor
  **/
  creatActor(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("admin/actor", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Create actor

  /**
    // Update actor Info
  **/
  updateActor(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/actor/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Update actor

  /**
    // Delete actors
  **/
  deleteActor(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/actor/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Delete actors
};
