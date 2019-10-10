import axios from 'axios'

const state = {
    discounts: {
        items: [],
        selected: {
            index: 0,
            users: []
        }
    }
}

const getters = {
    discounts(state) {
        return state.discounts.items
    },
    selectedDiscount(state) {
        return state.discounts.selected
    }
}

const mutations = {
    SET_ALL_DISCOUNTS: (state, discounts) => state.discounts.items = discounts,
    REMOVE_DISCOUNT: (state, index) => state.discounts.items.splice(index, 1),
    SET_SELECTED_DISCOUNT: (state, discount) => state.discounts.selected = discount,
    UPDATE_DISCOUNT: (state, { discount, index }) => state.discounts.items.splice(index, 1, discount),
    ADD_DISCOUNT: (state, discount) => state.discounts.items.push(discount)
}

const actions = {
    getDiscounts(context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/discounts`)
            .then(function (resp) {
                context.commit('SET_ALL_DISCOUNTS', resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Возникла проблемма при загрузке");
            });
    },
    getDiscount (context, { id }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/discounts/${id}`)
            .then(function (resp) {
                context.commit('SET_SELECTED_DISCOUNT', resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Возникла проблемма при загрузке категории пользователя");
            });
    },
    createDiscount(context, new_discount) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.post(`${context.getters.host}/api/v1/discounts`, new_discount)
            .then(function (resp) {
                context.commit('ADD_DISCOUNT', resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Could not create your discount");
            });
    },
    // TODO продумать передавать ли сюда в качестве параметра поля изменяего объекта (новые данные)
    updateDiscount(context, { discount, discount_id, index }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`
        axios.put(`${context.getters.host}/api/v1/discounts/${discount_id}`, discount)
            .then((resp) => {
                context.commit('UPDATE_DISCOUNT', { discount: resp.data, index });
            })
            .catch((resp) => {
                alert('Не получилось обновить скидку');
                console.log(resp);
            })
    },
    trashDiscount(context, { discount_id, index }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`
        axios.delete(`${context.getters.host}/api/v1/discounts/${discount_id}`)
            .then((resp) => {
                context.commit('REMOVE_DISCOUNT', index);
            })
            .catch((resp) => {
                alert('Не получилось обновить скидку');
                console.log(resp);
            })
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}
