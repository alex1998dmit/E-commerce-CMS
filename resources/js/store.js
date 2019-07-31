import Vue from 'vue';

export default {
    state: {
        host: 'http://passportapi',
        product_images_forlder: 'upload/products',

        // auth
        currentUser: JSON.parse(localStorage.getItem('user')) || { role: [] },
        loading: false,
        auth_error: null,
        token: localStorage.getItem('access_token') || null,

        // categories
        categories: [],
        trashed_categories: [],
        selected_category: {
            id: 0,
            name: "",
            parent_id: 0,
            product: [],
        },
        final_categories: [],

        // discount
        discounts: [],
        selected_discount: {
            users: [],
        },

        // products
        products: [],
        opened_product: {
            category: {},
            order: {},
            wish_list: {},
            photo: [],
        },
        opened_product_images: [],
        updating_product: {
            id: 0,
            category: {},
            order: {},
            wish_list: {},
            photo: [],
        },

        // Orders
        orders:[],
        selected_order: {
            id: 0,
            name: "",
            user_id: 0,
            product: {
                name: "",
                category: {},
            },
            user: {},
            status: {}
        },

        // Order statuses
        order_statuses: [],
        selected_order_status: {
            name: "",
            description: "",
        },

        // users
        users: [],
        selected_user: {},
    },

    getters: {
        // auth
        isLoggedIn(state) {
            return state.token !== null;
        },
        currentUser(state) {
            return state.currentUser;
        },

        // categories
        categories(state) {
            return state.categories;
        },
        finalCategories(state) {
            return state.final_categories;
        },
        selectedCategory(state) {
            return state.selected_category;
        },
        categoryByIndex(state) {
            return (index) => {
                return state.categories[index] ? state.categories[index] : { name: "", parent_id: 0 };
            };
        },
        trashedCategories(state) {
            return state.trashed_categories;
        },

        // discount
        discounts(state) {
            return state.discounts;
        },
        selectedDiscount(state) {
            return state.selected_discount;
        },

        // products
        products(state) {
            return state.products;
        },
        openedProduct(state) {
            return state.opened_product;
        },
        productImages(state) {
            return state.opened_product_images;
        },
        updatingProduct(state) {
            return state.updating_product;
        },

        // orders
        orders(state) {
            return state.orders;
        },
        selectedOrder(state) {
            return state.selected_order;
        },

        // orderstatuses
        orderStatuses(state) {
            return state.order_statuses;
        },
        selectedOrderStatus(state) {
            return state.selected_order_status;
        },

        // users
        users(state) {
            return state.users;
        },
        selectedUser(state) {
            return state.selected_user;
        }
    },
    mutations: {
        // categories
        ADD_NEW_CATEGORY_TO_CATEGORIES: (state, payload) => { state.categories.push(payload) },
        removeCategory: (state, categories) => {
            state.categories.splice(0, state.categories.length);
            state.categories = categories;
        },
        SET_CURRENT_CATEGORY: (state, category) =>  state.selected_category = category,
        SET_FINAL_CATEGORIES: (state, final_categories) => state.final_categories = final_categories,
        UPDATE_CATEGORIES: (state, { category_index, updated_category }) => state.categories[category_index] = updated_category,
        SET_TRASHED_CATEGORIES: (state, trashed_categories) => state.trashed_categories = trashed_categories,
        REMOVE_FROM_TRASHED_CATEGORIES: (state, index) => state.trashed_categories.splice(index, 1),
        SET_ALL_CATEGORIES: (state, categories) => state.categories = categories,

        // discounts
        GET_ALL_DISCOUNTS: (state, discounts) => state.discounts = discounts,
        REMOVE_DISCOUNT: (state, index) => state.discounts.splice(index, 1),
        SET_SELECTED_DISCOUNT: (state, discount) => state.selected_discount = discount,
        UPDATE_DISCOUNT: (state, { discount, index }) => state.discounts[index] = discount,
        ADD_DISCOUNT: (state, discount) => state.discounts.push(discount),

        // products
        GET_ALL_PRODUCTS(state, products) {
            state.products = products;
        },
        SET_CURRENT_PRODUCT(state, product) {
            state.opened_product = Object.assign({}, state.opened_product, product);
        },
        SET_OPENED_PRODUCT_IMAGES(state) {
            let photos = [];
            for(let index in state.opened_product.photo) {
               photos.push(`${state.host}/${state.product_images_forlder}/${state.opened_product.photo[index].path}`);
            }
            state.opened_product_images = photos;
        },
        SET_UPDATING_PRODUCT_PARAMS(state, product) {
            state.updating_product = product;
        },
        REMOVE_PHOTOS_FROM_UPDATING_PRODUCT(state, photo_index) {
            state.updating_product.photo.splice(photo_index, 1);
        },
        REMOVE_PRODUCT(state, product_index) {
            state.products.splice(product_index, 1);
        },
        UPDATE_PRODUCTS(state, product, index) {
            state.products[index] = product;
        },

        // Orders
        SET_ALL_ORDERS : (state, orders) => state.orders = orders,
        SET_SELECTED_ORDER: (state, order) => state.selected_order = order,
        UPDATE_ORDER: (state, { order_index, order }) => state.orders[order_index] = order,

        // Order statuses
        SET_ORDER_STATUSES: (state, order_statuses) => state.order_statuses = order_statuses,
        SET_SELECTED_ORDER_STATUS: (state, order_status) => state.selected_order_status = order_status,

        // users
        SET_ALL_USERS: (state, users) => {
            state.users = users;
            // Vue.set(state, 'users', [...users]);
        },
        SET_SELECTED_USER: (state, user) => state.selected_user = user,
        CLEAR_USERS: (state) => state.users.splice(0, state.users.length),

        // auth
        SET_USER_TOKEN: (state, token) => state.token = token,
        DESTROY_TOKEN: (state) => state.token = null,
        REMOVE_USER_PARAMS: (state) => state.currentUser = null,
        SET_CURRENT_USER_PARAMS: (state, user) => state.currentUser = user,
        UDPATE_USER: (state, { user, index }) => state.users.splice(index, 1, user),
    },
    actions: {
        // auth
        register(context, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/v1/register', {
                    name: data.name,
                    email: data.email,
                    password: data.password
                })
                .then((resp) => {
                    resolve(resp);
                })
                .catch((resp) => {
                    console.log('Ошибка при регистрации');
                    console.log(resp);
                    reject(error);
                })
            })
        },
        retrieveToken(context, credentials) {
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/login', {
                    username: credentials.username,
                    password: credentials.password,
                })
                    .then((resp) => {
                        const token = resp.data.access_token;
                        localStorage.setItem('access_token', token);
                        context.commit('SET_USER_TOKEN', token);
                        resolve(resp);
                    })
                    .catch((resp) => {
                        console.log('Ошибка при входе');
                        console.log(resp);
                        reject(error);
                    })
            });
        },
        destroyToken(context) {
            axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
            if (context.getters.isLoggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('api/v1/logout')
                        .then((resp) => {
                            localStorage.removeItem('access_token')
                            context.commit('DESTROY_TOKEN')
                            resolve(resp);
                        })
                        .catch((resp) => {
                            localStorage.removeItem('access_token')
                            localStorage.removeItem('user')
                            context.commit('DESTROY_TOKEN')
                            context.commit('REMOVE_USER_PARAMS');
                            console.log('Ошибка при вызоде');
                            console.log(resp);
                            reject(error);
                        })
                });
            }
        },
        getUserInfo(context) {
            return new Promise((resolve, reject) => {
                if (context.state.token) {
                    axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
                    axios.get('api/v1/user')
                        .then((resp) => {
                            localStorage.setItem('user', JSON.stringify(resp.data));
                            context.commit('SET_CURRENT_USER_PARAMS', resp.data)
                            resolve(resp.data);
                        })
                        .catch((resp) => {
                            console.log('Ошибка при получении информации о пользователе');
                            console.log(resp);
                            reject(resp);
                        })
                }
            });
        },

        // categories
        getCategories(context) {
            axios.get('/api/v1/categories')
                .then((resp) => {
                    context.commit('SET_ALL_CATEGORIES', resp.data);
                })
                .catch((resp) => {
                    console.log('error showing categories');
                    console.log(resp);
                });
        },
        getFinalCategories(context) {
            axios.get('/api/v1/finalCategories')
                .then((resp) => {
                    context.commit('SET_FINAL_CATEGORIES', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка при загрузке конечных категорий');
                    console.log(resp);
                })
        },
        createCategory(context, category) {
            axios.post('/api/v1/categories', category)
                .then((resp) => {
                    context.commit('ADD_NEW_CATEGORY_TO_CATEGORIES', resp.data);
                })
                .catch((resp) => {
                    console.log('error adding categories');
                    console.log(resp);
                })
        },
        trashCategory(context, category) {
            axios.get('/api/v1/categories/trash/' + category.id)
                .then((resp) => {
                    context.dispatch('getCategories');
                })
                .catch((resp) => {
                    console.log('error with trash category');
                    console.log(resp);
                });
        },
        updateCategory(context, { category_id, updating_category }) {
            axios.patch(`/api/v1/categories/${category_id}`, updating_category)
                .catch((resp) => {
                    console.log('error with update category');
                    console.log(resp);
                })
        },
        getTrashedCategories(context) {
            axios.get('/api/v1/trashedCategories')
                .then((resp) => {
                    context.commit('SET_TRASHED_CATEGORIES', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка при загрузке удаленных категорий');
                    console.log(resp);
                })
        },
        restoreCategory(context, { category_id, category_index }) {
            axios.get('/api/v1/categories/restore/' + category_id)
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
            axios.delete('/api/v1/categories/' + category_id)
                .then((resp) => {
                    context.dispatch('getTrashedCategories');
                })
                .catch((resp) => {
                    alert('Ошибка при загрузке удаленных категорий');
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
                context.commit('ADD_DISCOUNT', resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Could not create your discount");
            });
        },
        // TODO продумать передавать ли сюда в качестве параметра поля изменяего объекта (новые данные)
        updateDiscount(context, { discount, discount_id }) {
            const index = context.getters.discounts.map((discount) => discount.id).indexOf(discount_id);
            axios.put(`/api/v1/discounts/${discount_id}`, discount)
                .then((resp) => {
                    context.commit('UPDATE_DISCOUNT', { discount: resp.data, index });
                })
                .catch((resp) => {
                    alert('Не получилось обновить скидку');
                    console.log(resp);
                })
        },
        trashDiscount(context, discount_id) {
            const index = context.getters.discounts.map((discount) => discount.id).indexOf(discount_id);
            axios.delete(`/api/v1/discounts/${discount_id}`)
                .then((resp) => {
                    context.commit('REMOVE_DISCOUNT', index);
                })
                .catch((resp) => {
                    alert('Не получилось обновить скидку');
                    console.log(resp);
                })
        },


        // proiucts
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
        getUpdatingProduct(context, id) {
            axios.get('/api/v1/products/' + id)
                .then((resp) => {
                    context.commit('SET_UPDATING_PRODUCT_PARAMS', resp.data);
                })
                .catch((resp)=> {
                    alert('Возникла ошибка при загрузки обновляемого продукта');
                    console.log(resp);
                })
        },
        removePhotoFromUpdatingProduct(context, image_id) {
            const product_id = context.getters.updatingProduct.id;
            const photoAndProductsIds = { product_id, image_id };
            const photoIndex = context.getters.updatingProduct.photo.map((obj) => obj.id).indexOf(image_id);
            axios.delete('/api/v1/products/images', { data: photoAndProductsIds })
                .then((resp) => {
                    context.commit('REMOVE_PHOTOS_FROM_UPDATING_PRODUCT', photoIndex);
                })
                .catch((resp)=> {
                alert('Возникла ошибка при загрузки обновляемого продукта');
                    console.log(resp);
                })

        },
        createProduct(context, product){
            axios.post('/api/v1/products/store', product)
                .then((resp) => {
                })
                .catch((resp) => {
                    alert('Ошибка при создании продукта');
                    console.log(resp);
                })
        },
        trashProduct(context, product_id) {
            const product_index = context.getters.products.map((obj) => obj.id).indexOf(product_id);
            axios.delete('/api/v1/products/trash/' + product_id)
                .then((resp) => {
                    context.commit('REMOVE_PRODUCT', product_index);
                })
                .catch((resp)=> {
                    alert('Возникла ошибка при удалении продукта');
                    console.log(resp);
                })
        },
        updateProduct(context, product) {
            const id = context.getters.updatingProduct.id;
            const product_index = context.getters.products.map((obj) => obj.id).indexOf(id);
            // TODO !!! обновить на пут потом
            axios.post('/api/v1/products/update/' + id, product)
                .then((resp) => {
                    context.commit('UPDATE_PRODUCTS', resp.data, product_index);
                    // context.commit('REMOVE_PHOTOS_FROM_UPDATING_PRODUCT', photoIndex);
                })
                .catch((resp)=> {
                    alert('Возникла ошибка при обновлении продукта');
                    console.log(resp);
                })
        },

        // Orders
        getOrders(context) {
            axios.get('/api/v1/orders')
            .then((resp) => {
                context.commit('SET_ALL_ORDERS', resp.data);
            })
            .catch((resp) => {
                alert('Ошибка загрузки заказов');
                console.log(resp);
            });
        },
        updateOrder(context, { order_id, order }) {
            const order_index = context.getters.orders.map((order) => order.id).indexOf(order_id);
            console.log('------', order ,order_id);
            axios.put('/api/v1/orders/' + order_id, order)
                .then(resp => {
                    context.commit('UPDATE_ORDER', {  order_index, order:resp.data })
                })
                .catch((resp) => {
                    alert('Ошибка при обновлении заказа');
                    console.log(resp.data);
                })
        },

        // Order statuses
        getOrderStatuses(context) {
            axios.get('/api/v1/orderStatuses')
                .then((resp) => {
                    context.commit('SET_ORDER_STATUSES', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки статусов заказов');
                    console.log(resp);
                });
        },
        getSelectedOrderStatus(context, status_id) {
            axios.get('/api/v1/orderStatuses/' + status_id)
                .then((resp) => {
                    context.commit('SET_SELECTED_ORDER_STATUS', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки статусов заказов');
                    console.log(resp);
                });
        },

        // users
        getUsers(context) {
            axios.get('/api/v1/users/')
            .then((resp) => {
                console.log(resp);
                context.commit('SET_ALL_USERS', resp.data);
            })
            .catch((resp) => {
                alert('Ошибка при загрузке пользователей');
                console.log(resp);
            });
        },
        updateUser(context, { user_id, user}) {
            const index = context.getters.users.map((user) => user.id).indexOf(user_id);
            axios.put(`/api/v1/users/${user_id}`, user)
                .then(resp => {
                    context.commit('UDPATE_USER', { user: resp.data, index});
                })
                .catch(error => {
                    alert('Ошибка при обновлении пользоватля');
                    console.log(error);
                })
        },
        replaceUsersDiscountId(context, { old_discount_id, new_discount_id }) {
            console.log('object is ', { new_discount_id });
            axios.put(`/api/v1/users/replaceDiscounts/${old_discount_id}`, { new_discount_id })
                .then(resp => {
                    context.commit('CLEAR_USERS', resp.data);
                    context.commit('SET_ALL_USERS', resp.data);
                })
                .catch(error => {
                    alert('Ошибка при обновлении категорий пользователей');
                    console.log(error);
                })
        }
    }
}
