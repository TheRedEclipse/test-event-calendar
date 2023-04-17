import axios from 'axios';
import { useToast } from "vue-toastification";
import { camelizeKeys, decamelizeKeys } from 'humps';
import router from './router'
import store from  './store'

const $axios = axios.create({
    baseURL: `/api/`,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
})

const $toast = useToast()

$axios.interceptors.request.use(
    (config) => {
        // config.headers.common.Authorization = `Bearer ${$cookies.get('token') || this.$store.state.user.currentUser.accessToken}`
        config.headers.Authorization = `Bearer ${$cookies.get('token')}`
        return config
    },
    (error) => {
        return Promise.reject(error)
    }
)

/**
 * Session, messages and errors handling
 */
$axios.interceptors.response.use(
    (success) => {
        if (success.data.hasOwnProperty('messages')) {
            const obj = success.data.messages
            if (typeof obj === 'string') {
                if (success.data.success) {
                    if (process.client) $toast.success(obj)
                } else if (process.client) $toast.error(obj)
            } else {
                for (const key in obj) {
                    if (success.data.success) {
                        if (process.client) $toast.success(obj[key])
                    } else if (process.client) $toast.error(obj[key])
                }
            }
        }

        if (success.data.success && success.data.hasOwnProperty('redirect')) {
            if (success.data.redirect.type === 'back') {
                app.router.go(-1)
            } else if (success.data.redirect.type === 'external') {
                if (process.client) document.location = success.data.redirect.link
            } else if (process.client) router.push(success.data.redirect.link)
            return
        }

        return Promise.resolve(success)
    },
    (error) => {
        if (
            error.response &&
            error.response.status === 401
        ) {
            $toast.error('Сессия истекла')

            store.commit('logout')

            router.push('/sign-in')
            
            cookies.remove('token')
            return Promise.reject(error)
        }

        if (
            error.response &&
            error.response.status === 405
        ) {
            $toast.error('Ошибка сервера, запрос отклонён')
        }
        if (
            error.response &&
            error.response.status === 500
        ) {
            $toast.error('Ошибка сервера')
        }
        if (
            error.response &&
            !error.response.data.success &&
            error.response.data.hasOwnProperty('messages')
        ) {
            const obj = error.response.data.messages
            if (typeof obj === 'string') {
                $toast.error(obj)
            } else {
                for (const key in obj) {
                    $toast.error(obj[key][0])
                }
            }
        } else if (
            error.response &&
            !error.response.data.success &&
            error.response.data.hasOwnProperty('errors')
        ) {
            const obj = error.response.data.errors
            if (typeof obj === 'string') {
                $toast.error(obj)
            } else {
                for (const key in obj) {
                    $toast.error(obj[key][0])
                }
            }
        } else if (error.response && error.response.status >= 500) {
            if (process.client) $toast.error('Ошибка сервера')
        }

        return Promise.reject(error)

    },
)

/**
* Camel case handling
*/
$axios.interceptors.response.use((response) => {
    if (
        response.data &&
        response.headers['content-type'] === 'application/json'
    ) {
        response.data = camelizeKeys(response.data);
    }
    return response;
})

/**
* Snake case handling
*/
$axios.interceptors.request.use((config) => {
    if (config.headers['Content-Type'] === 'multipart/form-data') {
        return config;
    }
    if (config.params) {
        config.params = decamelizeKeys(config.params);
    }
    if (config.data) {
        config.data = decamelizeKeys(config.data);
    }
    return config;
});

export default $axios