// import { getLocalUser } from './helpers/auth';

// const user = getLocalUser();

export default {
    state: {
        testState:[],

        host: 'http://passportapi',
        product_images_forlder: 'upload/products',

        currentUser: {},
        isLoggedIn: 1,
        loading: false,
        auth_error: null,

        grant_type: "password",
        client_id: 2,
        client_secret: "WhYqHBDCWfGGecC4XcRc6yur09AJxxCvn3FiPJJT",

        // categories
        categories: [],
        selected_category: {
            name: "",
            parent_id: 0,
        },
        selected_category_for_adding_products: 1,
        final_categories: [],
        new_category: {
            name: "",
            parent_id: 0
        },

        // discount
        discounts: [],
        new_discount: {
            name: "",
            discount: "",
        },
        updating_discount: {
            index: 0,
            discount: "",
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
        finalCategories(state) {
            return state.final_categories;
        },
        categoryIdForAddProudct(state) {
            return state.selected_category_for_adding_products;
        },
        selectedCategory(state) {
            return state.selected_category;
        },
        categoryByIndex(state) {
            return (index) => {
                return state.categories[index] ? state.categories[index] : { name: "", parent_id: 0 };
            };
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
        },
        productImages(state) {
            return state.opened_product_images;
        },
        updatingProduct(state) {
            return state.updating_product;
        },
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

        // categories
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
        UPDATE_ALL_CATEGORIES(state, { category_id, updating_category }) {

        },
        SET_CURRENT_CATEGORY(state, category) {
            state.selected_category = category;
        },
        SET_CURRENT_CATEGORY_ID(state, category_id) {
            state.selected_category_for_adding_products = category_id;
        },
        SET_FINAL_CATEGORIES(state, final_categories) {
            state.final_categories = final_categories;
        },
        UPDATE_CATEGORIES(state, { category_index, updated_category }) {
            state.categories[category_index] = updated_category;
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
        SET_FINDED_PRODUCTS(state, products) {

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
        createCategory(context, category) {
            axios.post('/api/v1/categories', category)
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
        updateCategory(context, { category_id, updating_category }) {
            const category_index = context.getters.categories.map((obj) => obj.id).indexOf(category_id);
            axios.patch(`/api/v1/categories/${category_id}`, updating_category)
                .then((resp) => {
                    const updated_category = resp.data;
                    // context.commit('UPDATE_CATEGORIES', { category_index, updated_category });
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
                    console.log(resp.data);
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
    }
}
