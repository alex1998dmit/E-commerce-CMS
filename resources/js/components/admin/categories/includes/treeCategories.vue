<template>
    <div>
        <b-modal id="modal-xl" size="xl" title="Дерево категорий">
            <div class="row">
                <div class="col-md-12 text-left">
                    <button type="button" class="btn btn-success btn-sm" @click="changeParentCategory(0); resetNewCategory();">+</button>
                </div>
            </div>
            <li v-for="(category) in categoryTree" :key="category.id">
                {{ category.name }}
                <button type="button" class="btn btn-success btn-sm" @click="changeParentCategory(category.id);">+</button>
                <button type="button" class="btn btn-danger btn-sm"  @click="removeCategory(category)">x</button>
                <button type="button" class="btn btn-warning btn-sm"  @click="changeCategory(category)">изменить</button>
                <childCategories v-if="category.childs.length > 0" :childs="category.childs"></childCategories>
            </li>
        </b-modal>
        <b-modal id="bv-modal-create-category" hide-footer title="Добавить новую категорию">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="category_name">Название новой категории</label>
                    <input type="text" class="form-control" name="category_name" v-model="new_category.name">
                </div>
            </div>
            <br>
            <b-button block variant="outline-success" @click="addSubcategory()">Добавить</b-button>
            <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-create-category')">Отмена</b-button>
        </b-modal>
        <b-modal id="bv-modal-change-category" hide-footer>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="category_name">Название категории</label>
                    <input type="text" class="form-control" name="category_name" v-model="updating_category.name">
                </div>
            </div>
            <br>
            <b-button block variant="outline-success" @click="updateCategory()">Добавить</b-button>
            <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-change-category')">Отмена</b-button>
        </b-modal>
        <b-modal id="bv-modal-add-product-category" size="xl" hide-footer title="Добавить продукт к категориии">
            <div class="row">
                <div class="col-md-12">
                     <form action="" id="createProductForm">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="product_name">Название</label>
                                <input type="text" class="form-control" id="product_name" v-model="product.name">
                            </div>
                            <br>
                            <div class="col-md-4">
                                <label for="exampleInputEmail1">Категория</label>
                                {{ product.category_id }}
                                <select name="category_id" id="category" class="form-control" v-model="product.category_id">
                                    <option v-for="category in final_categories" :key="category.id" v-bind:value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <br>
                            <div class="col-md-4">
                                <label for="price">Стоимость</label>
                                <input type="text" class="form-control" id="price" v-model="product.price">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for="price">Описание</label>
                                <textarea class="form-control" name="product_desc" id="" cols="30" rows="10" v-model="product.description"></textarea>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <label for=""></label>
                                <input type="file" class="form-control" ref="file_input" id="attachments" @change="uploadFiles" multiple>
                            </div>
                            <br>
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <br>
                                    <b-button class="btn btn-success" @click="createProduct(); $bvModal.hide('bv-modal-add-product-category'); showProductsWithCurCategory(product.category_id)">Создать</b-button>
                                    <b-button class="btn btn-danger" @click="$bvModal.hide('bv-modal-add-product-category')">Отмена</b-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </b-modal>
        <b-modal id="bv-modal-products-with-category" size="xl" hide-footer title="Продукты категории">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по продуктам категории">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">Дата создания</th>
                                    <th scope="col">Дата обновления</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in productsWithCategory"  :key="product.id">
                                        <td>{{ product.id }}</td>
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.price }}</td>
                                        <td>{{ product.created_at }}</td>
                                        <td>{{ product.updated_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </b-modal>
    </div>
</template>
<script>
import { createCategoryMixin } from '../mixins/createCategoryMixin.js';
import childCategories from './childCategories.vue';
import { generateArrayOfCategoriesTree } from '../../../../helpers/categoryTree';
import ProductCreate from '../../products/ProductCreate';

export default {
    mixins: [createCategoryMixin ],
    data: () => {
        return {
            product: {
                name: "",
                category_id: 0,
                price: 0,
                description: "",
                photos: []
            },
            productsWithCategory: [],
            search_param: "",
        }
    },
    components: {
        childCategories, ProductCreate
    },
    props: {
        categories: Array,
    },
    computed: {
        categoryTree() {
            return generateArrayOfCategoriesTree(this.$store.getters.categories);
        },
        final_categories() {
            return this.$store.getters.finalCategories;
        },
        selected_category() {
            return this.$store.getters.categoryIdForAddProudct;
        },
    },
    mounted() {
        this.$store.dispatch('getFinalCategories');
        this.$store.dispatch('getProducts');
    },
    methods: {
        createProduct(e) {
            let form = new FormData();
            form.append('name',this.product.name);
            form.append('category_id',this.product.category_id);
            form.append('price',this.product.price);
            form.append('description',this.product.description);
            for (let i = 0; i < this.product.photos.length; i++) {
                form.append('photo[]', this.product.photos[i])
            }
            this.$store.dispatch('createProduct', form);
        },
        uploadFiles(e) {
            this.product.photos = e.target.files;
        },
        updateProductsWithCategory(category_id) {
            this.productsWithCategory = this.getProductWithCategory(category_id);
        },
        getProductWithCategory(category_id) {
            let products = this.$store.getters.products;
            return products.filter(product => product.category_id === category_id);
        }
    },
    watch: {
        selected_category(category_id) {
            this.product.category_id = category_id;
            this.updateProductsWithCategory(category_id);
        },
        search_param(param) {
            if (param === "") {
                this.productsWithCategory = this.getProductWithCategory(this.$store.getters.categoryIdForAddProudct);
            } else {
                this.productsWithCategory = this.productsWithCategory.filter((product) => product.name.toLowerCase().includes(param.toLocaleLowerCase()))
            }
        }
    }
}
</script>
