import axios from 'axios'

const state = {
    order_notifications: [],
}

const getters = {
    orderNotifications(state) {
        return state.order_notifications;
    },
}

const mutations = {
    SET_ORDER_NOTIFICATIONS: (state, notifications) => state.order_notifications = notifications,
    ADD_ORDER_NOTIFICATION: (state, notification) => state.order_notifications.push(notification),
    REMOVE_ORDER_NOTIFICATION: (state, index) => { state.order_notifications.splice(index, 1) },
    REMOVE_ALL_ORDER_NOTIFICATIONS: (state) => state.order_notifications.splice(0, state.order_notifications.length),
}

const actions = {
    getOrderNotifications(context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/notifications/orders`)
            .then((resp) => {
                context.commit('SET_ORDER_NOTIFICATIONS', resp.data);
            })
            .catch((resp) => {
                console.log('Ошибка при загрузке уведомлений');
                console.log(resp);
            });
    },
    checkOrderNotification(context, { index, notification_id }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.post(`${context.getters.host}/api/v1/notificatons/orders/${notification_id}/check`)
            .then((resp) => {
                context.commit('REMOVE_ORDER_NOTIFICATION', index);
            })
            .catch((resp) => {
                console.log('Ошибка при обновлении уведомлений');
                console.log(resp);
            });
    },
    checkAllNotification(context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.post(`${context.getters.host}/api/v1/notificatons/check/orders`)
            .then((resp) => {
                context.commit('REMOVE_ALL_ORDER_NOTIFICATIONS');
            })
            .catch((resp) => {
                console.log('Ошибка при обновлении уведомлений');
                console.log(resp);
            });
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}

