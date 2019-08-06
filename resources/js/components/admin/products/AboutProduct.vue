<template>
    <div>
        <div class="row">
            <div class="col-md-6 text-left">
                <h4>{{ product.name }}</h4>
                <h6>{{ product.category.name }}</h6>
            </div>
            <div class="col-md-6 text-right">
                <router-link :to="{ name: 'products' }" class="btn btn-xs btn-info">Продукты</router-link>
                <router-link :to="{ name: 'editProduct', params: { id: product.id }}" class="btn btn-xs btn-success">Редактировать</router-link>
            </div>
        </div>
        <br>
        <div class="row" id="about">
            <div class="col-md-12">
                <h5>Общая информация</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Категория</th>
                            <th>Цена</th>
                            <th>В корзине</th>
                            <th>Покупок</th>
                            <th>Создан</th>
                            <th>Обновлен в последний раз</th>
                            <th>Количество фото</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="product !== undefined">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.category.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.wish_list.length }}</td>
                            <td>{{ product.order.length }}</td>
                            <td>{{ product.created_at }}</td>
                            <td>{{ product.updated_at ? product.updated_at : "-" }}</td>
                            <td>{{ product.photo.length }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" id="photos">
            <div class="col-md-12">
                <h5>Фотографии продукта</h5>
                <div class="col-md-12">
                    <gallery :images="selectedProductImages" :index="index" @close="index = null"></gallery>
                    <div
                        class="image"
                        v-for="(image, imageIndex) in selectedProductImages"
                        :key="imageIndex"
                        @click="index = imageIndex"
                        :style="{ backgroundImage: 'url(' + image + ')', width: '300px', height: '200px' }"
                    ></div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" id="price_changing">
            <div class="col-md-12">
                <h5>История изменения цен</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Старая цена</th>
                            <th>Новая цена</th>
                            <th>Разница</th>
                            <th>Дата обновления</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="price_changing in product.price_changings" :key="price_changing.id">
                            <td>{{ price_changing.id }}</td>
                            <td>{{ price_changing.old_price }}</td>
                            <td>{{ price_changing.new_price }}</td>
                            <td>{{ Math.abs(price_changing.new_price - price_changing.old_price) }}</td>
                            <td>{{ price_changing.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import VueGallery from 'vue-gallery';

export default {
    mixins: ["deleteProducts"],
    components: {
      'gallery': VueGallery
    },
    data: () => {
        return {
            index: null,
        };
    },
    computed: {
        ...mapGetters(['product', 'selectedProductImages']),
    },
    mounted() {
        this.$store.dispatch('getProduct', this.$route.params.id);
    }
}
</script>

<style>
.image {
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border: 1px solid #ebebeb;
    margin: 5px;
}

a .next {
    background: white;
}

a .close {
    color: white;
}

</style>
