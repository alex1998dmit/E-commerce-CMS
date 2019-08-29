<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row title-sign-block">
                <div class="col-md-4 text-left">
                    <h2>Продукция</h2>
                    <br>
                </div>
                <div class="col-md-8 text-right">
                    <router-link :to="{ name: 'createProduct' }"><button class="btn add-product-button">Добавить продукт</button></router-link>
                    <!-- <b-button variant="primary">Главное меню</b-button> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-left">
                    <form action="" @submit.prevent="findProducts">
                        <div class="search-field">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control search-input" v-model="search_param" @click="showAllProducts" placeholder="Поиск по продукции...">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                </div>
            </div>
            <div class="row filter-block">
                <div class="col-md-6 text-left">
                    <br>
                    <a class="search-param-field" @click="showAllProducts(); clearSearchParam()" v-if="show_search_result">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        {{ search_param }}
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="card-body">
                    <div class="col-md-12">
                        <table class="table" v-if="!show_search_result">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Название</th>
                                <th scope="col">Категория</th>
                                <th scope="col">Цена</th>
                                <th scope="col">В корзине:</th>
                                <th scope="col">Покупок:</th>
                                <th></th>
                                <th></th>
                                <!-- <th scope="col">Редактировать</th>
                                <th scope="col">Подробнее</th>
                                <th scope="col">Удалить</th> -->
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td>{{ product.id }}</td>
                                    <td>
                                        <a
                                            class="aboutProduct"
                                            @click="openAboutProductModal(product)">
                                            {{ product.name }}
                                        </a>
                                    </td>
                                    <td>{{ product.category.name }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>{{ product.wish_list.length }}</td>
                                    <td>{{ product.order_items.length }}</td>
                                    <td>
                                        <router-link href="#" class="edit-icon" :to="{ name: 'editProduct', params: { id: product.id }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </router-link>
                                    </td>
                                    <td>
                                        <a href="#" class="trash-icon" @click="trashProduct(product.id)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <div class="row" v-if="show_search_result">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">По имени</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">По названию категории</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">По id продукт</a>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <SearchResults :products="filteredItems.byName" @trashProduct="trashProduct" @openProduct="openAboutProductModal"></SearchResults>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <SearchResults :products="filteredItems.byCategoryName" @trashProduct="trashProduct" @openProduct="openAboutProductModal"></SearchResults>
                            </div>
                            <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <SearchResults :products="filteredItems.byProductId"></SearchResults>
                            </div> -->
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <AboutProductModule></AboutProductModule>
        </div>
        <Pager
            v-if="!show_search_result"
            routerName="products"
            :frame=10
            :pageCount="page_count"
            @updateItems="getProducts">
        </Pager>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import { deleteProduct } from './mixins/deleteProduct.js';
import AboutProductModule from './includes/aboutProductModule';
import SearchResults from './includes/SearchResults';
import Pager from '../helpers/Pager'

export default {
    mixins: ["deleteProduct"],
    data: () => {
        return {
            search_param: null,
            show_search_result: false,
        }
    },
    components: {
        AboutProductModule, SearchResults, Pager
    },
    mounted() {
        const page = this.$route.query.page
        this.getProducts(page)
    },
    computed: {
        ...mapGetters(['products']),
        page_count() {
            return this.$store.getters.productsPageCount
        },
        filteredItems() {
            return this.$store.getters.filtered_products
        }
    },
    methods: {
        openAboutProductModal(product) {
            this.$store.commit('SET_CURRENT_PRODUCT', product);
            this.$store.commit('SET_OPENED_PRODUCT_IMAGES', product.photo);
            this.$bvModal.show('bv-modal-about-product');
        },
        trashProduct(id) {
            if (confirm("Вы уверены что хотите удалить продукт ?")) {
                this.$store.dispatch('trashProduct', id);
            }
        },
        getProducts (page) {
            this.$store.commit('SET_PRODUCTS_CURRENT_PAGE', page)
            this.$store.dispatch('getProducts', page);
        },
        findProducts () {
            this.$store.dispatch('getFilteredProducts', this.search_param)
                .then(resp => {
                    this.show_search_result = true
                })
                .catch(error => {
                    this.show_search_result = false
                    console.log(error)
                })
        },
        showAllProducts () {
            this.show_search_result = false
        },
        clearSearchParam () {
            this.search_param = null
        }
    },
    watch: {
        '$route.query.page'(newPage) {
            this.getProducts(newPage)
        }
    }
}
</script>
<style scoped>
    .fa .fa-pencil {
        color: black;
    }
    .edit-icon {
        color: black;
    }
    .trash-icon {
        color: red;
    }
    .add-product-button {
        border-bottom: 2px solid lightgrey;
        border-radius: 0px;
        color: black;
    }
    .add-product-button:hover {
        border-bottom: 2px solid black;
    }
    .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    .search-field {
        padding-left: 3%;
    }
    .search-input {
        padding-left: 10%;
    }
    .aboutProduct {
        color: #333;
        text-decoration: none;
    }
    .search-param-field {
        padding: 10px;
        border: 0px;
        border-radius: 0px;
        background: lightgrey;
    }
    .search-param-field:hover {
        background: white;
        /* border: 1px solid; */
    }
    .filter-block, .title-sign-block {
        padding-left: 1.5%;
    }
</style>
