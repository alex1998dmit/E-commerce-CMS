<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 text-left">
                    <h2>Продукция</h2>
                    <br>
                </div>
                <div class="col-md-8 text-right">
                    <router-link :to="{ name: 'createProduct' }"><b-button variant="success">Добавить продукт</b-button></router-link>
                    <!-- <b-button variant="info">Главное меню</b-button> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-left">
                    <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по продукции...">
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="card-body">
                <div class="row">
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
                                <th scope="col">Подробнее</th>
                                <th scope="col">Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td>{{ product.id }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.category.name }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>{{ product.wish_list.length }}</td>
                                    <td>{{ product.order.length }}</td>
                                    <td>
                                        <b-button
                                            id="show-btn"
                                            @click="openAboutProductModal(product)">
                                                Подробнее
                                        </b-button>
                                    </td>
                                    <td>
                                        <a href="#"
                                            class="btn btn-xs btn-danger"
                                            @click="trashProduct(product.id)">
                                                Удалить
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" v-if="show_search_result">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">По названию</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">По id</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">По категории</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <SearchResults :products="filteredProductsByName"></SearchResults>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <SearchResults :products="filteredProductsById"></SearchResults>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <SearchResults :products="fileteredByCategoryName"></SearchResults>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <AboutProductModule></AboutProductModule>
        </div>
    </div>
</template>

<script>
  import { mapGetters, mapMutations } from 'vuex';
  import { deleteProduct } from './mixins/deleteProduct.js';
  import AboutProductModule from './includes/aboutProductModule.vue';
  import SearchResults from './includes/SearchResults.vue';

export default {
    mixins: ["deleteProduct"],
    data: () => {
        return {
            search_param: null,
            show_search_result: false,
        }
    },
    components: {
        AboutProductModule,SearchResults
    },
    mounted() {
        this.$store.dispatch('getProducts');
    },
    computed: {
        ...mapGetters(['products']),
        filteredProductsByName() {
            return this.products.filter((product) => product.name.toLowerCase().includes(this.$data.search_param.toLocaleLowerCase()));
        },
        filteredProductsById() {
            return this.products.filter((product) => product.id == this.search_param);
        },
        fileteredByCategoryName() {
            return this.products.filter((product) => product.category.name.toLowerCase().includes(this.$data.search_param.toLocaleLowerCase()))
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
    },
    watch: {
        search_param(val) {
            if(val === "") {
                this.show_search_result = false;
            } else {
                this.show_search_result = true;
            }
        }
    }
}
</script>
