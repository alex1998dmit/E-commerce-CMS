import Vue from 'vue';

export default {
    state: {
        host: 'http://passportapi',
        product_images_forlder: 'upload/products',

        search_param: null,

        // auth
        currentUser: JSON.parse(localStorage.getItem('user')) || { role: [] },
        loading: false,
        auth_error: null,
        token: localStorage.getItem('access_token') || null,

        // notifications
        order_notifications: [],

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

        // requisites
        requisites: [],
        selected_requisite: {
            name: "",
            products: []
        },
        requisite_index: 0,
        trashed_requisites: [],

        // discount
        discounts: [],
        selected_discount: {
            users: [],
        },

        // products
        products: {
            items: [],
            filtered_items: {
                byName: [],
                byCategoryName: [],
                byProductId: []
            },
            page: 1,
            pageCount: 0,
            selected: {
            }
        },
        // products: [],
        product: {
            category: {},
            wish_list: [],
            order: [],
            photo: [],
            price_changings: [],
        },
        product_images: [],
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
        orders: {
            items: [],
            page: 1,
            pageCount: 0,
            selected: {
                id: 0,
                name: null,
                user_id: 0,
                status: {
                    name: null
                },
                user: {
                    name: null,
                    email: null
                },
                order_items: [
                    {
                        id: null,
                        product: {
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
        },

        // Order statuses
        order_statuses: [],
        selected_order_status: {
            name: "",
            description: "",
        },

        // users
        users: {
            items: [],
            page: 1,
            pageCount: 0,
            selected: {},
            filtered: []
        },
        selected_user: {},
    },

    getters: {
        searchParam (state) {
            return state.search_param
        },

        // auth
        isLoggedIn(state) {
            return state.token !== null;
        },
        currentUser(state) {
            return state.currentUser;
        },

        // notifications
        orderNotifications(state) {
            return state.order_notifications;
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

        // requisite
        requisites(state) {
            return state.requisites;
        },
        selectedRequisite(state) {
            return state.selected_requisite;
        },
        requisiteIndex(state) {
            return state.requisite_index;
        },
        trashedRequisites: (state) => state.trashed_requisites,

        // products
        products(state) {
            return state.products.items
        },
        filtered_products (state) {
            return state.products.filtered_items
        },
        currentProductPage(state) {
            return state.products.page
        },
        productsPageCount(state) {
            return state.products.pageCount
        },
        product(state) {
            return state.product;
        },
        selectedProductImages(state) {
            return state.product_images;
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
            return state.orders.items;
        },
        selectedOrder(state) {
            return state.orders.selected;
        },
        orderHistory(state) {
            return state.orders.order_history;
        },
        ordersPageCount (state) {
            return state.orders.pageCount;
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
            return state.users.items
        },
        selectedUser(state) {
            return state.users.selected_user
        },
        findedUsers (state) {
            return state.users.filtered
        }
    },
    mutations: {
        // search param
        SET_SEARCH_PARAM: (state, param) => state.search_param = param,

        // notifications - unCheckedOrders
        SET_ORDER_NOTIFICATIONS: (state, notifications) => state.order_notifications = notifications,
        ADD_ORDER_NOTIFICATION: (state, notification) => state.order_notifications.push(notification),
        REMOVE_ORDER_NOTIFICATION: (state, index) => { state.order_notifications.splice(index, 1) },
        REMOVE_ALL_ORDER_NOTIFICATIONS: (state) => state.order_notifications.splice(0, state.order_notifications.length),

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

        // requisites
        SET_ALL_REQUISITES: (state, requisites) => state.requisites = requisites,
        SET_SELECTED_REQUISITE: (state, requisite) => state.selected_requisite = requisite,
        UPDATE_REQUISITE: (state, { index, requisite }) => { state.requisites.splice(index, 1, requisite) },
        REMOVE_REQUISITE: (state, index) => state.requisites.splice(index, 1),
        ADD_REQUISITE: (state, requisite) => state.requisites.push(requisite),
        SET_REQUISITE_INDEX: (state, requisite_index) => state.requisite_index = requisite_index,
        SET_TRASHED_REQUISITES: (state, requisites) => state.trashed_requisites = requisites,
        REMOVE_TRASHED_REQUISITES: (state, index) => state.trashed_requisites.splice(index, 1),

        // discounts
        GET_ALL_DISCOUNTS: (state, discounts) => state.discounts = discounts,
        REMOVE_DISCOUNT: (state, index) => state.discounts.splice(index, 1),
        SET_SELECTED_DISCOUNT: (state, discount) => state.selected_discount = discount,
        UPDATE_DISCOUNT: (state, { discount, index }) => state.discounts[index] = discount,
        ADD_DISCOUNT: (state, discount) => state.discounts.push(discount),

        // products
        SET_PRODUCTS_ITEMS(state, products) { state.products.items = products },
        SET_PRODUCTS_PAGER_COUNT (state, pageCount) { state.products.pageCount = pageCount },
        SET_PRODUCTS_CURRENT_PAGE (state, page) { state.products.page = page },
        SET_PRODUCT: (state, product) => state.product = product,
        SET_PRODUCT_IMAGES: (state, photos) => {
            let images = [];
            for(let index in photos) {
                images.push(`${state.host}/${state.product_images_forlder}/${photos[index].path}`);
            }
            state.product_images = images;
        },
        SET_CURRENT_PRODUCT(state, product) { state.opened_product = Object.assign({}, state.opened_product, product) },
        SET_OPENED_PRODUCT_IMAGES(state) {
            let photos = [];
            for(let index in state.opened_product.photo) {
               photos.push(`${state.host}/${state.product_images_forlder}/${state.opened_product.photo[index].path}`);
            }
            state.opened_product_images = photos;
        },
        SET_UPDATING_PRODUCT_PARAMS(state, product) { state.updating_product = product },
        REMOVE_PHOTOS_FROM_UPDATING_PRODUCT(state, photo_index) { state.updating_product.photo.splice(photo_index, 1) },
        REMOVE_PRODUCT(state, product_index) { state.products.items.splice(product_index, 1) },
        UPDATE_PRODUCT: (state, { product, index }) => { state.products.items.splice(index, 1, product) },
        SET_FILTERED_PRODUCTS_ITEMS: (state, products) => {
            state.products.filtered_items.byName = products.by_name
            state.products.filtered_items.byCategoryName = products.by_category_name
            state.products.filtered_items.by_product_id = products.by_product_id
        },
        // Orders
        SET_ALL_ORDERS : (state, orders) => {
            state.orders.items = orders.data
            state.orders.pageCount = orders.last_page
        },
        SET_SELECTED_ORDER: (state, order) => {
            state.orders.selected = order
        },
        UPDATE_ORDER: (state, { order_index, order }) => {
            state.orders.items.splice(order_index, 1, order)
            state.orders.selected = order
        },
        SET_SELECTED_ORDER_HISTORY: (state, order_history) => state.order_history = order_history,
        REMOVE_ORDERS_ITEM: (state, order_index) => { state.orders.items.splice(order_index, 1) },
        ADD_ORDER: (state, order) => { state.orders.items.push(order) },

        // Order statuses
        SET_ORDER_STATUSES: (state, order_statuses) => state.order_statuses = order_statuses,
        SET_SELECTED_ORDER_STATUS: (state, order_status) => state.selected_order_status = order_status,

        // OrderItem
        // context.commit('UDPATE_ORDER_ITEM', { order_index, item_index, order_item: resp.data })
        UDPATE_ORDER_ITEM: (state, { order_index, item_index, order_item }) => { state.orders.selected.order_items.splice(item_index, 1, order_item) },
        ADD_ORDER_ITEM: (state, item) => {
            console.log('1', state.orders.selected.order_items)
            state.orders.selected.order_items.push(item)
            console.log('2', state.orders.selected.order_items)
        },
        REMOVE_ORDER_ITEM: (state, orderIndex) => { state.orders.selected.order_items.splice(orderIndex, 1) },

        // users
        SET_ALL_USERS: (state, users) => {
            state.users = users;
            // Vue.set(state, 'users', [...users]);
        },
        SET_SELECTED_USER: (state, user) => state.selected_user = user,
        CLEAR_USERS: (state) => state.users.splice(0, state.users.length),
        SET_FILTERED_USERS: (state, users) => {
            console.log('-', users)
            state.users.filtered = users
        },

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
        destroyToken(context) {
            axios.defaults.headers.common['Authorization']=`Bearer ${context.state.token}`;
            if (context.getters.isLoggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('api/v1/logout')
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

        // notifcations
        getOrderNotifications(context) {
            axios.get('/api/v1/notifications/orders')
                .then((resp) => {
                    context.commit('SET_ORDER_NOTIFICATIONS', resp.data);
                })
                .catch((resp) => {
                    console.log('Ошибка при загрузке уведомлений');
                    console.log(resp);
                });
        },
        checkOrderNotification(context, { index, notification_id }) {
            axios.post(`/api/v1/notificatons/orders/${notification_id}/check`)
                .then((resp) => {
                    console.log({ order_index: index, order: resp.data });
                    context.commit('REMOVE_ORDER_NOTIFICATION', index);
                })
                .catch((resp) => {
                    console.log('Ошибка при обновлении уведомлений');
                    console.log(resp);
                });
        },
        checkAllNotification(context) {
            axios.post(`/api/v1/notificatons/check/orders`)
                .then((resp) => {
                    context.commit('REMOVE_ALL_ORDER_NOTIFICATIONS');
                })
                .catch((resp) => {
                    console.log('Ошибка при обновлении уведомлений');
                    console.log(resp);
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

        // requisites
        getRequisites(context) {
            axios.get('/api/v1/requisites')
                .then(function (resp) {
                    context.commit('SET_ALL_REQUISITES', resp.data);
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Возникла проблемма при загрузке реквизитов");
                });
        },
        createRequisite(context, requisite) {
            axios.post('/api/v1/requisites', requisite)
            .then(function (resp) {
                context.commit('ADD_REQUISITE', resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Не получилось создать реквизит");
            });
        },
        updateRequisite(context, { requisite, requisite_id, index }) {
            console.log({ requisite, requisite_id, index });
            axios.put(`/api/v1/requisites/${requisite_id}`, requisite)
                .then((resp) => {
                    context.commit('UPDATE_REQUISITE', { requisite: resp.data, index });
                })
                .catch((resp) => {
                    alert('Не получилось обновить скидку');
                    console.log(resp);
                })
        },
        trashRequisite(context, { requisite_id, index }) {
            axios.delete(`/api/v1/requisites/${requisite_id}`)
                .then((resp) => {
                    context.commit('REMOVE_REQUISITE', index);
                })
                .catch((resp) => {
                    alert('Не получилось удалить реквизит');
                    console.log(resp);
                })
        },
        getTrashedRequisites(context) {
            axios.get(`/api/v1/trashed/requisites`)
                .then((resp) => {
                    context.commit('SET_TRASHED_REQUISITES', resp.data);
                })
                .catch((resp) => {
                    alert('Не получилось получить удаленные реквизиты');
                    console.log(resp);
                })
        },
        restoreTrashedRequisite(context, { requisite_id, index }) {
            axios.get(`/api/v1/requisites/restore/${requisite_id}`)
                .then((resp) => {
                    context.commit('REMOVE_TRASHED_REQUISITES', index);
                })
                .catch((resp) => {
                    alert('Не получилось восстановить реквизит');
                    console.log(resp);
                })
        },

        // requisite-product
        createProductRequisite(context, { requisite_id, product_id, requsite_index, product_index }) {
            axios.post(`/api/v1/products/${product_id}/requisite`, { requisite_id })
                .then(function (resp) {
                    context.commit('UPDATE_REQUISITE', { requisite: resp.data.requisite, index: requsite_index });
                    context.commit('UPDATE_PRODUCT', { product: resp.data.product, index: product_index });
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не получилось создать реквизит");
                });
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
        getProducts(context, page = 1) {
            axios.get(`/api/v1/products?page=${page}`)
                .then((resp) => {
                    context.commit('SET_PRODUCTS_ITEMS', resp.data.data)
                    context.commit('SET_PRODUCTS_PAGER_COUNT', resp.data.last_page)
                })
                .catch((resp) => {
                    alert('Ошибка загрузки продуктов');
                    console.log(resp);
                });
        },
        getFilteredProducts (context, search_param) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/v1/search/products?param=${search_param}`)
                    .then((resp) => {
                        context.commit('SET_FILTERED_PRODUCTS_ITEMS', resp.data)
                        resolve(resp)
                    })
                    .catch((error) => {
                        alert('Ошибка загрузки продуктов');
                        console.log(resp);
                        reject(error)
                    });
            })

        },
        getProduct(context, id) {
            axios.get('/api/v1/products/' + id)
                .then((resp) => {
                    context.commit('SET_PRODUCT', resp.data);
                    console.log()
                    context.commit('SET_PRODUCT_IMAGES', resp.data.photo);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки продукта');
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
        updateProduct(context, {id, product, index }) {
            // TODO !!! обновить на пут потом
            axios.post('/api/v1/products/update/' + id, product)
                .then((resp) => {
                    console.log({ product: resp.data, index })
                    context.commit('UPDATE_PRODUCT', { product: resp.data, index });
                    // context.commit('REMOVE_PHOTOS_FROM_UPDATING_PRODUCT', photoIndex);
                })
                .catch((resp)=> {
                    alert('Возникла ошибка при обновлении продукта');
                    console.log(resp);
                })
        },

        // Orders
        getOrders(context, page = 1) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios.get(`/api/v1/orders?page=${page}`)
                .then((resp) => {
                    context.commit('SET_ALL_ORDERS', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки заказов');
                    console.log(resp)
                });
        },
        getOrdersWithStatusId (context, statusId) {
            return new Promise((resolve, reject) => {
                axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
                axios.get(`/api/v1/orderStatus/${statusId}/orders`)
                    .then((resp) => {
                        context.commit('SET_ALL_ORDERS', resp.data)
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
            axios.get('/api/v1/orders/' + id)
                .then((resp) => {
                    console.log(resp.data)
                    context.commit('SET_SELECTED_ORDER', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки заказов');
                    console.log(resp);
                });
        },
        getOrderHistory(context, order_id) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios.get(`/api/v1/orders/${order_id}/history/`)
                .then((resp) => {
                    console.log(resp.data);
                    context.commit('SET_SELECTED_ORDER_HISTORY', resp.data);
                })
                .catch((resp) => {
                    alert('Ошибка загрузки заказов');
                    console.log(resp);
                });
        },
        updateOrder(context, { order_id, order, index }) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios.put('/api/v1/orders/' + order_id, order)
                .then(resp => {
                    context.commit('UPDATE_ORDER', {  order_index: index, order:resp.data })
                })
                .catch((resp) => {
                    alert('Ошибка при обновлении заказа');
                    console.log(resp.data);
                })
        },
        getFindedOrders (context) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios
                .post('/api/v1/search/orders/', { search_param: context.getters.searchParam })
                .then(resp => { context.commit('SET_ALL_ORDERS', resp.data) })
                .catch(error => console.log('Ошибка при поиске', error) )
        },
        trashOrder (context, { order_id, order_index }) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios.delete(`/api/v1/orders/${order_id}`)
                .then(resp => {
                    context.commit(`REMOVE_ORDERS_ITEM`, order_index)
                })
                .catch(error => {
                    console.log('Ошибка при удалении')
                })
        },

        // Order statuses
        getOrderStatuses(context) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
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
        // order Items
        updateOrderItem (context, { item_id, body, item_index, order_index }) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            return new Promise((resolve, reject) => {
                axios.put('/api/v1/orderItems/' + item_id, body)
                    .then((resp) => {
                        context.commit('UDPATE_ORDER_ITEM', { order_index, item_index, order_item: resp.data })
                        resolve(resp)
                    })
                    .catch((error) => {
                        alert('Ошибка при обновлении заказа')
                        console.log(error)
                        reject(error)
                    });
            })
        },
        createOrderItem (context, order) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/orderItems', { order_id: order.order_id, product_id: order.product_id, amount: order.amount })
                    .then((resp) => {
                        context.commit('ADD_ORDER_ITEM', resp.data)
                        resolve(resp)
                    })
                    .catch((error) => {
                        alert('Ошибка при обновлении заказа')
                        console.log(error)
                        reject(error)
                    })
            })
        },
        removeOrderItem (context, { orderItemId, itemIndex }) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            return new Promise((resolve, reject) => {
                axios.delete(`/api/v1/orderItems/${orderItemId}`)
                    .then((resp) => {
                        context.commit('REMOVE_ORDER_ITEM', itemIndex)
                        resolve(resp)
                    })
                    .catch((error) => {
                        alert('Ошибка при обновлении заказа')
                        console.log(error)
                        reject(error)
                    })
            })
        },

        // users
        getUsers(context) {
            axios.get('/api/v1/users/')
            .then((resp) => {
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
            axios.put(`/api/v1/users/replaceDiscounts/${old_discount_id}`, { new_discount_id })
                .then(resp => {
                    context.commit('CLEAR_USERS', resp.data);
                    context.commit('SET_ALL_USERS', resp.data);
                })
                .catch(error => {
                    alert('Ошибка при обновлении категорий пользователей');
                    console.log(error);
                })
        },
        findUsers (context, search_param) {
            axios.defaults.headers.common["Authorization"] = `Bearer ${context.state.token}`
            axios
                .post('/api/v1/users/search', { search_param })
                .then(resp => {
                    context.commit('SET_FILTERED_USERS', resp.data)
                })
                .catch(error => console.log('Ошибка при поиске', error) )
        }
    }
}
