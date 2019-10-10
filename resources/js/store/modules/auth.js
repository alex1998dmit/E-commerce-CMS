import axios from 'axios'

const state = {
    currentUser: JSON.parse(localStorage.getItem('user')) || { role: [] },
    loading: false,
    auth_error: null,
    token: localStorage.getItem('access_token') || null,
    secret: process.env.MIX_SECRET_CODE,
}

const getters = {
    isLoggedIn(state) {
        return state.token !== null
    },
    currentUser(state) {
        return state.currentUser
    },
    authSecretCode (state) {
        return state.secret
    },
    // notifications
    orderNotifications(state) {
        return state.order_notifications;
    }
}

const mutations = {
    SET_USER_TOKEN: (state, token) => state.token = token,
    DESTROY_TOKEN: (state) => state.token = null,
    REMOVE_USER_PARAMS: (state) => state.currentUser = null,
    SET_CURRENT_USER_PARAMS: (state, user) => state.currentUser = user,
    UPDATE_USER: (state, { user, index }) => state.users.items.splice(index, 1, user)
}

const actions = {
    register (context, data) {
        return new Promise((resolve, reject) => {
            axios.post(`${context.getters.host}/api/v1/register`, {
                name: data.name,
                email: data.email,
                password: data.password
            })
                .then((resp) => {
                    resolve(resp);
                })
                .catch((error) => {
                    console.log('Ошибка при регистрации');
                    console.log(error);
                    reject(error);
                })
        })
    },
    retrieveToken (context, credentials) {
        return new Promise((resolve, reject) => {
            axios.post(`${context.getters.host}/api/v1/login`, {
                username: credentials.username,
                password: credentials.password,
                secret: context.getters.authSecretCode
            })
                .then((resp) => {
                    const token = resp.data.access_token
                    localStorage.setItem('access_token', token);
                    context.commit('SET_USER_TOKEN', token);
                    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
                    resolve(resp);
                })
                .catch((resp) => {
                    console.log('Ошибка при входе');
                    console.log(resp);
                    reject(resp);
                })
        });
    },
    destroyToken (context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        if (context.getters.isLoggedIn) {
            return new Promise((resolve, reject) => {
                axios.post(`${context.getters.host}/api/v1/logout`)
                    .then((resp) => {
                        localStorage.removeItem('access_token')
                        axios.defaults.headers.common["Authorization"] = `Bearer `
                        context.commit('DESTROY_TOKEN')
                        resolve(resp);
                    })
                    .catch((resp) => {
                        localStorage.removeItem('access_token')
                        localStorage.removeItem('user')
                        context.commit('DESTROY_TOKEN')
                        context.commit('REMOVE_USER_PARAMS');
                        axios.defaults.headers.common["Authorization"] = `Bearer `
                        console.log('Ошибка при выходе');
                        console.log(resp);
                        reject(error);
                    })
            });
        }
    },
    getUserInfo (context) {
        return new Promise((resolve, reject) => {
            if (context.state.token) {
                axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`
                axios.get(`${context.getters.host}/api/v1/user`)
                    .then((resp) => {
                        localStorage.setItem('user', JSON.stringify(resp.data));
                        context.commit('SET_CURRENT_USER_PARAMS', resp.data)
                        resolve(resp.data);
                    })
                    .catch((resp) => {
                        console.log('Ошибка при получении информации о пользователе')
                        console.log(resp)
                        reject(resp)
                    })
            }
        });
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}
