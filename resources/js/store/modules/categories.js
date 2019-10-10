import axios from 'axios'

const state = {
    categories: [],
    trashed_categories: [],
    selected_category: {
        id: 0,
        name: "",
        parent_id: 0,
        product: [],
    },
    final_categories: []
}

const getters = {
    categories(state) {
        return state.categories;
    },
    finalCategories(state) {
        return state.final_categories;
    },
    selectedCategory(state) {
        return state.selected_category;
    },
    trashedCategories(state) {
        return state.trashed_categories;
    },
}

const mutations = {
    ADD_NEW_CATEGORY_TO_CATEGORIES: (state, payload) => { state.categories.push(payload) },
    SET_CURRENT_CATEGORY: (state, category) =>  state.selected_category = category,
    SET_FINAL_CATEGORIES: (state, final_categories) => state.final_categories = final_categories,
    UPDATE_CATEGORIES: (state, { category_index, updated_category }) => state.categories[category_index] = updated_category,
    SET_TRASHED_CATEGORIES: (state, trashed_categories) => state.trashed_categories = trashed_categories,
    REMOVE_FROM_TRASHED_CATEGORIES: (state, index) => state.trashed_categories.splice(index, 1),
    SET_ALL_CATEGORIES: (state, categories) => state.categories = categories,
}

const actions = {
    getCategories(context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`
        // console.log(`${context.getters.host}/api/v1/categories`)
        axios.get(`${context.getters.host}/api/v1/categories`)
            .then((resp) => {
                context.commit('SET_ALL_CATEGORIES', resp.data);
            })
            .catch((resp) => {
                console.log('error showing categories');
                console.log(resp);
            });
    },
    getFinalCategories(context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/finalCategories`)
            .then((resp) => {
                context.commit('SET_FINAL_CATEGORIES', resp.data);
            })
            .catch((resp) => {
                alert('Ошибка при загрузке конечных категорий');
                console.log(resp);
            })
    },
    createCategory(context, category) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.post(`${context.getters.host}/api/v1/categories`, category)
            .then((resp) => {
                context.commit('ADD_NEW_CATEGORY_TO_CATEGORIES', resp.data);
            })
            .catch((resp) => {
                console.log('error adding categories');
                console.log(resp);
            })
    },
    trashCategory(context, category) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/categories/trash/` + category.id)
            .then((resp) => {
                context.dispatch('getCategories');
            })
            .catch((resp) => {
                console.log('error with trash category');
                console.log(resp);
            });
    },
    updateCategory(context, { category_id, updating_category }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.patch(`${context.getters.host}/api/v1/categories/${category_id}`, updating_category)
            .catch((resp) => {
                console.log('error with update category');
                console.log(resp);
            })
    },
    getTrashedCategories(context) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/trashedCategories`)
            .then((resp) => {
                context.commit('SET_TRASHED_CATEGORIES', resp.data);
            })
            .catch((resp) => {
                alert('Ошибка при загрузке удаленных категорий');
                console.log(resp);
            })
    },
    restoreCategory(context, { category_id, category_index }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.get(`${context.getters.host}/api/v1/categories/restore/` + category_id)
            .then((resp) => {
                context.commit('ADD_NEW_CATEGORY_TO_CATEGORIES', resp.data);
                context.commit('REMOVE_FROM_TRASHED_CATEGORIES', category_index);
            })
            .catch((resp) => {
                alert('Ошибка при загрузке удаленных категорий');
                console.log(resp);
            })
    },
    deleteCategory(context, { category_id, category_index }) {
        axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
        axios.delete(`${context.getters.host}/api/v1/categories/` + category_id)
            .then((resp) => {
                context.dispatch('getTrashedCategories');
            })
            .catch((resp) => {
                alert('Ошибка при загрузке удаленных категорий');
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
