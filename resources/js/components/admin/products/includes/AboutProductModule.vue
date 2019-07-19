<template>
    <div>
        <b-modal id="bv-modal-about-product" size="xl" hide-footer title="О продукте">
            <div class="row">
                <div class="col-md-12 text-right">
                    <router-link :to="{ name: 'editProduct', params: { id: openedProduct.id }}" class="btn btn-xs btn-info">Редактировать</router-link>
                    <b-button variant="danger">Удалить</b-button>
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
                            <tr v-if="openedProduct !== undefined">
                                <td>{{ openedProduct.id }}</td>
                                <td>{{ openedProduct.name }}</td>
                                <td>{{ openedProduct.category.name }}</td>
                                <td>{{ openedProduct.price }}</td>
                                <td>{{ openedProduct.wish_list.length }}</td>
                                <td>{{ openedProduct.order.length }}</td>
                                <td>{{ openedProduct.created_at }}</td>
                                <td>{{ openedProduct.updated_at ? openedProduct.updated_at : "-" }}</td>
                                <td>{{ openedProduct.photo.length }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" id="photos">
                <div class="col-md-12">
                    <h5>Фотографии продукта</h5>
                    <div class="col-md-12">
                        <gallery :images="productImages" :index="index" @close="index = null"></gallery>
                        <div
                            class="image"
                            v-for="(image, imageIndex) in productImages"
                            :key="imageIndex"
                            @click="index = imageIndex"
                            :style="{ backgroundImage: 'url(' + image + ')', width: '300px', height: '200px' }"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="row" id="price_changing">
                <div class="col-md-12">
                    <h5>История изменения цен</h5>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import { deleteProduct } from '../mixins/deleteProduct.js';
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
        ...mapGetters(['openedProduct', 'productImages']),
    },
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


</style>
