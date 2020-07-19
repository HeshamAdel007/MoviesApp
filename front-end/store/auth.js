import axios from "../plugins/axios";

/**
  # If User Login Change To True If Not Stay False
  # Change State By Mutations
**/
export const state = () => ({
  isLoggedIn: false,
});

/**
  # Return User State IF Login Or Logout
**/
export const getters = {
  loggedIn(state) {
    return state.isLoggedIn;
  },
};

/**
  # Use In Actions
  # Change State Value
  # { SET_LOGGEDIN } If User Login Change To True If Not Change To False
**/
export const mutations = {
  SET_LOGGEDIN(state, payload) {
    state.isLoggedIn = payload;
  },
};

export const actions = {
  /**
    // User Login
    # Check If User Login
    # Add Token In Local Storage
    # Change User State Form Flase To True
    # If Not Login Return Errors
  **/
  loginUser(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("user/login", payload)
        .then(response => {
          if (response.data.access_token) {
            localStorage.setItem("token", response.data.access_token);
            localStorage.setItem("adminID", response.data.userId);
            ctx.commit("SET_LOGGEDIN", true);
            resolve(response);
          } else {
            reject(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Login

  /**
    // User State
    # Change State User After Login Or Logout
    # And Use Check On User State IF Login OR No
  **/
  setLoggedInState(ctx) {
    return new Promise(resolve => {
      if (localStorage.getItem("token")) {
        ctx.commit("SET_LOGGEDIN", true);
        resolve(true);
      } else {
        ctx.commit("SET_LOGGEDIN", false);
        resolve(false);
      }
    });
  }, // End User State

  /**
    // User Register
    # Check If User Register
    # Add Token In Local Storage
    # Change User State Form Flase To True
    # If Not Rregister Return Errors
  **/
  signUp(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("user/register", payload)
        .then(response => {
          ctx.commit("SET_LOGGEDIN", true);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Register

  /**
    // User LogOut
    # IF User Make Logout
    # Remove Token From Local Storage
    # Change User State Form True To Flase
  **/
  logoutUser(ctx) {
    return new Promise(resolve => {
      localStorage.removeItem("token");
      localStorage.removeItem("adminID");
      ctx.commit("SET_LOGGEDIN", false);
      resolve(true);
    });
  }, // End User LogOut

  /**
    // User Forgot Password
    # User Add E-Mails
    # And Send Token To User Mail
    # Send Url To User Mail To Reset Password
  **/
  forgotPassword(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("user/forgot-password", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Forgot Password

  /**
    // User Reset Password
    # Rest Password User
    # Take Token From Url By [ Route Query]
  **/
  resetPassword(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("user/reset-password", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Reset Password

  /**
    // User Verify E-Mail
    # Verification User E-Mail
    # Take User ID & Hash From Url By [ Route Query]
  **/
  verifyEmail(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("user/email-verification", { params: payload })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Verify E-Mail

  /**
    // User Resend E-Mail Verify
    # Resend Verification User E-Mail
    # Send Hash & Expires To User MAil
    # Send Url To User Mail To Verification E-Mail
  **/
  resendVerifyEmail(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .post("user/resend-email-verify", payload)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }, // End User Resend E-Mail Verify
  /**
    // User Login By Facebook
    # Redirect User To Facebok Login Link
    # https://www.facebook.com/v3.3/dialog/oauth?client_id=
  **/
  socialLoginRedirect(ctx) {
    return new Promise((resolve, reject) => {
      axios
        .get("user/authorize/facebook/redirect")
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  /**
    // User Login By Facebook
    # Get Code From Router Query
    # Generate Token Whene Clalback & Add Token IN LocalStorge
  **/
  socialLoginCallback(ctx, payload) {
    return new Promise((resolve, reject) => {
      axios
        .get("user/authorize/facebook/callback", { params: payload })
        .then(response => {
          if (response.data.access_token) {
            localStorage.setItem("token", response.data.access_token);
            ctx.commit("SET_LOGGEDIN", true);
            resolve(response);
          } else {
            reject(response);
          }
        })
        .catch(error => {
          reject(error);
        });
    });
  },
};
