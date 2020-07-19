import axios from "../plugins/axios";

export const state = () => ({
  posts: {},
});

export const mutations = {
  SET_POSTINFO(state, payload) {
    state.posts = payload;
  },
};

export const actions = {
  /**
  // Post Info
  # Fetch user Post Info
  **/
  postInfo(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/posts", { params: payload })
        .then(response => {
          if (localStorage.getItem("token")) {
            ctx.commit("SET_POSTINFO", response.data.data);
            resolve(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Post Info

  /**
    // Create New Post
  **/
  creatPost(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("admin/post", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Create Post

  /**
    // Post Edit Page Info
    # Fetch This Post Info
  **/
  postEditInfo(ctx, params, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/post/${params.id}?token=${params.token}`, payload)
        .then(response => {
          ctx.commit("SET_POSTINFO", response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Category Edit Info

  /**
    // Update Post Info
  **/
  updatePost(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .patch(`admin/post/${payload.id}?token=${payload.token}`, payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Update Post

  /**
    // Soft Delete Post { Move Post To Trash }
  **/
  deletePost(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/post/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Soft Delete Post { Move Post To Trash }

  /**
    // Show All Posts In Trash
  **/
  postTrash(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("admin/post/trash", { params: payload })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Show All Posts In Trash

  /**
    // Restore Post { Move Post From Trash To Normal Post }
  **/
  restorePost(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get(`admin/post/restore/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Restore Post { Move Post From Trash To Normal Post }

  /**
    // Hard Delete Post
  **/
  hardDelete(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .delete(`admin/post/delete/${payload.id}?token=${payload.token}`)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End Hard Delete Post
};
