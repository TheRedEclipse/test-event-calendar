import $axios from  './axios'
import store from  './store'
import { createApp } from 'vue/dist/vue.esm-bundler'
import App from './App.vue'
import router from './router'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueCookies from 'vue-cookies'

const app = createApp({
    components: {
        App
    }
})

app.config.globalProperties.$axios = $axios

app.use(router)
app.use(Toast)
app.use(VueCookies)
app.use(store)
app.mount('#app')