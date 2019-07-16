// import { getLocalUser } from './helpers/auth';

// const user = getLocalUser();

export default {
    state: {
        currentUser: {},
        isLoggedIn: 1,
        loading: false,
        auth_error: null,

        categories: [],
        new_category: {
            name: "",
            parent_id: 0
        },

        grant_type: "password",
        client_id: 2,
        client_secret: "WhYqHBDCWfGGecC4XcRc6yur09AJxxCvn3FiPJJT",
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        auth_error(state) {
            return state.auth_error;
        },
        categories(state) {
            return state.categories;
        },
        newCategory(state) {
            return state.new_category;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
        },
        loginFailed() {

        },
        updateCategories(state, payload) {
            state.categories = payload;
        },
        creaeteCategory(state, payload) {
            state.categories.push(payload);
        },
        addNewCategoryParams(state, payload) {
            for (let key in payload) {
                state.new_category[key] = payload[key];
            }
        },
        removeCategory(state, categories) {
            state.categories.splice(0, state.categories.length);
            state.categories = categories;
        }
    },
    actions: {
        getCategories(context) {
            axios.get('/api/v1/categories')
                .then((resp) => {
                    context.commit('updateCategories', resp.data);
                })
                .catch((resp) => {
                    console.log('error showing categories');
                    console.log(resp);
                });
        },
        createCategories(context, category) {
            axios.post('/api/v1/categories', context.state.new_category)
                .then((resp) => {
                    context.commit('creaeteCategory', resp.data);
                })
                .catch((resp) => {
                    console.log('error adding categories');
                    console.log(resp);
                })
        },
        addNewCategoryParam(context, paramAndValue) {
            context.commit('addNewCategoryParams', paramAndValue);
        },
        removeCategory(context, category) {
            axios.delete('/api/v1/categories/' + category.id)
                .then((resp) => {
                    context.commit('removeCategory', resp.data);
                })
                .catch((resp) => {
                    console.log('error with deleting category');
                    console.log(resp);
                });
        }
    }
}
