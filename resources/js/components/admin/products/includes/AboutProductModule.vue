<template>
    <div>
        <b-modal id="bv-modal-about-product" size="xl" hide-footer title="О продукте">
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
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" id="photos">
                <div class="col-md-12">
                    <h5>Фотографии продукта</h5>
                </div>
            </div>
            <div class="row" id="price_changing">
                <div class="col-md-12">
                    <h5>История изменения цен</h5>
                </div>
            </div>
            <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example'); showInfo()">Close Me</b-button>
        </b-modal>
    </div>
</template>

<script>
  import { mapGetters, mapMutations } from 'vuex';
  import { deleteProduct } from '../mixins/deleteProduct.js';

export default {
    mixins: ["deleteProducts"],
    computed: {
        ...mapGetters(['openedProduct']),
    },
    mounted() {

        // console.log(this.openedProduct);
    },
    methods: {
        showInfo() {
            console.log(this.openedProduct);
        }
    }
}
</script>
