// import { getLocalUser } from './helpers/auth';

// const user = getLocalUser();

export default {
    state: {
        currentUser: {},
        isLoggedIn: 1,
        loading: false,
        auth_error: null,

        grant_type: "password",
        client_id: 2,
        client_secret: "WhYqHBDCWfGGecC4XcRc6yur09AJxxCvn3FiPJJT",

        categories: [],
        new_category: {
            name: "",
            parent_id: 0
        },

        discounts: [],
        new_discount: {
            name: "",
            discount: "",
        },
        updating_discount: {
            index: 0,
            discount: "",
        },

        products: [],
        opened_product: {
            category: {},
            order: {},
            wish_list: {},
            photos: [],
        },
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

        // categories
        categories(state) {
            return state.categories;
        },
        newCategory(state) {
            return state.new_category;
        },

        // discount
        updatingDiscount(state){
            return state.updating_discount;
        },
        newDiscount(state){
            return state.new_discount;
        },
        discounts(state) {
            return state.discounts;
        },

        // products
        products(state) {
            return state.products;
        },
        openedProduct(state) {
            return state.opened_product;
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
        },
        updateCategory(state, categories) {
            state.categories.splice(0, state.categories.length);
            state.categories = categories;
        },

        // discounts
        GET_ALL_DISCOUNTS(state, discounts) {
            state.discounts = discounts;
        },
        CREATE_NEW_DISCOUNT(state, new_discount) {
            state.discounts.push(new_discount);
        },
        REMOVE_DISCOUNT(state, index) {
            state.discounts.splice(index, 1);
        },
        UPDATE_DISCOUNT(state, discount, index) {
            state.discounts[index] = discount;
        },
        SET_NEW_DISCOUNT_PARAM(state, discount) {
            state.updating_discount = Object.assign({}, state.updating_discount, discount);
        },

        // products
        GET_ALL_PRODUCTS(state, products) {
            state.products = products;
        },
        SET_CURRENT_PRODUCT(state, product) {
            console.log(product);
            state.opened_product = Object.assign({}, state.opened_product, product);
        }
    },
    actions: {
        // categories
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
        },
        updateCategory(context, category) {
            axios.patch(`/api/v1/categories/${category.id}`, category)
                .then((resp) => {
                    context.commit('updateCategory', resp.data);
                })
                .catch((resp) => {
                    console.log('error with update category');
                    console.log(resp);
                })
        },

        // discounts
        getDiscounts(context) {
            axios.get('/api/v1/discounts')
                .then(function (resp) {
                    context.commit('GET_ALL_DISCOUNTS', resp.data);
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Возникла проблемма при загрузке");
                });
        },
        createDiscount(context, new_discount) {
            axios.post('/api/v1/discounts', new_discount)
            .then(function (resp) {
                context.commit('CREATE_NEW_DISCOUNT', resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Could not create your discount");
            });
        },
        removeDiscount(context, id) {
            // TODO закинуть в helpers и импортировать сюда
            const index = this.getters.discounts.map((obj) => obj.id).indexOf(id);
            axios.delete('/api/v1/discounts/' + id)
                .then(function (resp) {
                    context.commit('REMOVE_DISCOUNT', index);
                })
                .catch(function (resp) {
                    alert("Удаление не удалось", resp);
                });
        },
            // TODO продумать передавать ли сюда в качестве параметра поля изменяего объекта (новые данные)
        updateDiscount(context) {
            const discount = this.getters.updatingDiscount.discount;
            const index = this.getters.updatingDiscount.index;
            axios.put('/api/v1/discounts/' + discount.id, discount)
                .then((resp) => {
                    context.commit('UPDATE_DISCOUNT', resp.data, index);
                })
                .catch((resp) => {
                    alert('Не получилось обновить скидку');
                    console.log(resp);
                })
        },
        getNewDiscountParam(context, params) {
            context.commit('SET_NEW_DISCOUNT_PARAM', params);
        },

        // products
        getProducts(context) {
            axios.get('/api/v1/products')
                .then((resp) => {
                    context.commit('GET_ALL_PRODUCTS', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки продуктов');
                    console.log(resp);
                });
        },
    }
}
