# MoviesApp
> Use Nuxt-js v2.13.0

SPA Project Used [Laravel & Nuxtjs]

## Installation

### 1. Downloade Project
Run This At The Command Line:
```bash
git clone git@github.com:HeshamAdel007/MoviesApp.git
```

### 2. Install Nuxt Files
Go To Front-End File & Run This At The Command Line For Local Setup:
```bash
npm install
npm run dev
```
- Change Axios BaseURL To Your API Url
```js
// Will Find This In [ plugins/axios.js ]
const myaxios = axios.create({
  baseURL: "http://127.0.0.1:8000/api/v1/"
});
```
- Change Snotify Options IF You Need
```js
// Will Find This In [ plugins/snotify.js ]
const options = {
  toast: {
    position: SnotifyPosition.rightTop,
    timeout: 6000,
    titleMaxLength: 30,
    bodyMaxLength: 150,
    bold: false
  }
};
```

## 3. Vuex

- Get Token From ( API => JWT ) & Save Token IN Browser LocalStorage

Save Token Whene User Normal Login Or Use Social Login
```js
// Will Find This In [ store/auth.js ] Vuex Actions
localStorage.setItem("token", response.data.access_token);
```
- IN Reset Password Get Token From Url, Whene Verification E-Mail Get User ID & Has From Url, and When Login Used Facebook Get Code From Calllback Url, Use Route Query
```js
// Reset Password Path [ pages/auth/password/reset.vue]
const token = this.$route.query.token;

// E-Mail Verification Path [ pages/auth/email/verification.vue]
this.verifyEmail(this.$route.query)

// Facebook CallBack Path [ pages/authorize/facebook/callback.vue]
this.loginFace({ code: this.$route.query.code })
```

## License

The Project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
