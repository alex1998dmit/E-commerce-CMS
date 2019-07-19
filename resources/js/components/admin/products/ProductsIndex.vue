<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 text-left">
                    <h2>Продукция</h2>
                    <br>
                </div>
                <div class="col-md-8 text-right">
                    <b-button variant="success">Добавить продукт</b-button>
                    <b-button variant="info">Главное меню</b-button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-left">
                    <input type="text" class="form-control" placeholder="Поиск по продукции...">
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
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
                                            @click="fasfa()">
                                                Удалить
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

export default {
    mixins: ["deleteProduct"],
    components: {
        AboutProductModule
    },
    mounted() {
        this.$store.dispatch('getProducts');
    },
    computed: {
        ...mapGetters(['products']),
    },
    methods: {
        openAboutProductModal(product) {
            this.$store.commit('SET_CURRENT_PRODUCT', product);
            this.$store.commit('SET_OPENED_PRODUCT_IMAGES', product.photo);
            this.$bvModal.show('bv-modal-about-product');
        }
    },
}
</script>
