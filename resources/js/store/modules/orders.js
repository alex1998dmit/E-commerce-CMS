import axios from 'axios'

const state = {
    orders: {
        items: [],
        page: 1,
        pageCount: 0,
        current: {
            id: 0,
            name: null,
            user_id: 0,
            status: {
                name: null
            },
            user: {
                name: null,
                email: null,
                discount: {
                    discount: 0,
                }
            },
            order_items: [
                {
                    id: null,
                    product: {
                        id: null,
                        name: null,
                        category: {
                            name: null
                        }
                    },
                    amount: null
                }
            ]
        },
        order_history: []
    }
}

const getters = {
    orders(state) {
        return state.orders.items;
    },
    selectedOrder(state) {
        return state.orders.current;
    },
    orderHistory(state) {
        return state.orders.order_history;
    },
    ordersPageCount (state) {
        return state.orders.pageCount;
    }
}

const mutations = {
    SET_ALL_ORDERS : (state, orders) => { state.orders.items = orders },
    ADD_ORDER: (state, order) => { state.orders.items.unshift(order) },
    SET_ORDERS_PAGE_COUNT (state, pageCount) { state.orders.pageCount = pageCount },
    SET_ORDERS_CURRENT_PAGE (state, page) { state.orders.page = page },
    SET_SELECTED_ORDER: (state, order) => { state.orders.current = order },
    UPDATE_ORDER_ITEMS: (state, { order_index, order }) => { state.orders.items.splice(order_index, 1, order) },
    SET_SELECTED_ORDER_HISTORY: (state, order_history) => state.order_history = order_history,
    REMOVE_ORDERS_ITEM: (state, order_index) => { state.orders.items.splice(order_index, 1) },
}

const actions = {
    getOrders(context, page = 1) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios.get(`${context.getters.host}/api/v1/orders?page=${page}`)
            .then((resp) => {
                context.commit('SET_ALL_ORDERS', resp.data.data)
                context.commit('SET_ORDERS_PAGE_COUNT', resp.data.last_page)
                context.commit('SET_ORDERS_CURRENT_PAGE', resp.data.current_page)
            })
            .catch((resp) => {
                alert('Ошибка загрузки заказов');
                console.log(resp)
            });
    },
    getOrdersWithStatusId (context, { statusId, page }) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios.get(`${context.getters.host}/api/v1/orderStatuses/${statusId}?page=${page}`)
                .then((resp) => {
                    context.commit('SET_ALL_ORDERS', resp.data.orders.data)
                    context.commit('SET_ORDERS_PAGE_COUNT', resp.data.orders.last_page)
                    context.commit('SET_ORDERS_CURRENT_PAGE', resp.data.orders.current_page)
                    context.commit('SET_SELECTED_ORDER_STATUS', resp.data.status);
                    resolve(resp)
                })
                .catch((error) => {
                    alert('Ошибка загрузки заказов со статусом')
                    console.log(error)
                    reject(error)
                });
        })
    },
    getOrder(context, id) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios.get(`${context.getters.host}/api/v1/orders/` + id)
            .then((resp) => {
                context.commit('SET_SELECTED_ORDER', resp.data);
            })
            .catch((resp) => {
                alert('Ошибка загрузки заказов');
                console.log(resp);
            });
    },
    getOrderHistory(context, order_id) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios.get(`${context.getters.host}/api/v1/orders/${order_id}/history/`)
            .then((resp) => {
                context.commit('SET_SELECTED_ORDER_HISTORY', resp.data)
            })
            .catch((resp) => {
                alert('Ошибка загрузки заказов');
                console.log(resp);
            });
    },
    updateOrder(context, { order_id, order, index }) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios.put(`${context.getters.host}/api/v1/orders/${order_id}`, order)
                .then(resp => {
                    context.commit('UPDATE_ORDER_ITEMS', {  order_index: index, order:resp.data })
                    context.commit('SET_SELECTED_ORDER', resp.data)
                    resolve(resp)
                })
                .catch((error) => {
                    alert('Ошибка при обновлении заказа');
                    console.log(resp.data);
                    reject(error)
                })
        })

    },
    getFindedOrders (context) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios
            .post(`${context.getters.host}/api/v1/search/orders/`, { search_param: context.getters.searchParam })
            .then(resp => { context.commit('SET_ALL_ORDERS', resp.data) })
            .catch(error => console.log('Ошибка при поиске', error) )
    },
    trashOrder (context, { order_id, order_index }) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios.delete(`${context.getters.host}/api/v1/orders/${order_id}`)
            .then(resp => {
                context.commit(`REMOVE_ORDERS_ITEM`, order_index)
            })
            .catch(error => {
                console.log('Ошибка при удалении')
            })
    },
    findOrders (context, search_param) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios.post(`${context.getters.host}/api/v1/search/orders`, { search_param })
            .then(resp => {
                context.commit('SET_ALL_ORDERS', resp.data)
            })
            .catch(error => { alert('Ошибка при поиске', error) })
    },
    filterOrders (context, body) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
        axios.post(`${context.getters.host}/api/v1/filter/orders`, body)
            .then(resp => {
                context.commit('SET_ALL_ORDERS', resp.data.data)
            })
            .catch(error => { alert('Ошибка при поиске', error) })

    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}

