import axios from "../plugins/axios";

export const state = () => ({
  movies: {},
  moviesInfos: {},
  actorInfo: {},
  categoryInfo: {},
  tagInfo: {},
  commentInfo: {},
  replyInfo: {},
});

export const mutations = {
  SET_MOVIES(state, payload) {
    state.movies = payload;
  },
  SET_MOVIESINFO(state, payload) {
    state.moviesInfos = payload;
  },
  SET_ACTORINFO(state, payload) {
    state.actorInfo = payload;
  },
  SET_CATEGORYINFO(state, payload) {
    state.categoryInfo = payload;
  },
  SET_TAGINFO(state, payload) {
    state.tagInfo = payload;
  },
};

export const actions = {
  /**
  // Movies Info
  # Get Movies Info
  **/
  movies(ctx) {
    return new Promise((resolve, reject) => {
      axios
        .get("/home")
        .then(response => {
          ctx.commit("SET_MOVIES", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Movies Info
  /**
  // Post Info
  # Get Movies Post Info
  **/
  singlePage(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/post/${params.id}`)
        .then(response => {
          ctx.commit("SET_MOVIESINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Movies Post Info
  likePost(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post(`/like/${payload.id}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  /**
  // Actors
  # Get All Actor
  **/
  allActor(ctx) {
    return new Promise((resolve, reject) => {
      axios
        .get("/actors")
        .then(response => {
          ctx.commit("SET_ACTORINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Get All Actor
  /**
  // Actor Info
  # Get Actor Info
  **/
  actorPage(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/actor/${params.id}`)
        .then(response => {
          ctx.commit("SET_ACTORINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Actor Info
  /**
  // Categories
  # Get All Categories
  **/
  allCategory(ctx) {
    return new Promise((resolve, reject) => {
      axios
        .get("/categories")
        .then(response => {
          ctx.commit("SET_CATEGORYINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Get All Categories
  /**
  // Category Info
  # Get Category Info
  **/
  categoryPage(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/category/${params.id}`)
        .then(response => {
          ctx.commit("SET_CATEGORYINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Category Info
  /**
  // Tag Info
  # Get Tag Info
  **/
  tagPage(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/tag/${params.id}`)
        .then(response => {
          ctx.commit("SET_TAGINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Tag Info
  /**
  // Search Info
  **/
  searchPage(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/search?data=${params.data}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Search Info
  /**
  // Add Comment
  **/
  addComment(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("/comment", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Add Comment
  /**
  // Add Reply
  **/
  addReply(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("/reply", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Add Reply
  /**
  // Get Comments
  **/
  getComment(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/post/comment/${params.id}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Get Comments
  /**
  // Get Replys
  **/
  getReply(ctx, params) {
    return new Promise((resolve, reject) => {
      axios
        .get(`/post/reply/${params.id}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Get Replys
};
